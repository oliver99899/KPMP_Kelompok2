<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Seller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $type = $request->input('type', 'product');
        $isSearching = $request->filled('search') || $request->filled('category') || 
                       $request->filled('provinces') || $request->filled('cities') || 
                       $request->filled('min_price') || $request->filled('max_price');

        $products = collect(); 
        $sellers = collect();

        // --- 1. PENCARIAN PRODUK ---
        if ($type === 'product') {
            $query = Product::with(['category', 'seller'])
                            ->withAvg('reviews', 'rating')
                            ->withCount('reviews');

            if ($request->filled('search')) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('description', 'like', "%{$search}%");
                });
            }

            if ($request->filled('categories')) {
                $query->whereIn('category_id', $request->categories);
            } elseif ($request->filled('category')) {
                $query->where('category_id', $request->category);
            }

            // Filter Lokasi
            if ($request->filled('provinces')) {
                $query->whereHas('seller', fn($q) => $q->whereIn('pic_province', $request->provinces));
            }
            if ($request->filled('cities')) {
                $query->whereHas('seller', fn($q) => $q->whereIn('pic_city', $request->cities));
            }

            if ($request->filled('min_price')) $query->where('price', '>=', $request->min_price);
            if ($request->filled('max_price')) $query->where('price', '<=', $request->max_price);

            $products = $query->latest()->paginate(12)->withQueryString();
        }
        
        // --- 2. PENCARIAN TOKO ---
        elseif ($type === 'store') {
            $query = Seller::where('status', 'ACTIVE')->withCount('products');

            if ($request->filled('search')) {
                $query->where('store_name', 'like', "%{$request->search}%");
            }
            if ($request->filled('provinces')) {
                $query->whereIn('pic_province', $request->provinces);
            }
            if ($request->filled('cities')) {
                $query->whereIn('pic_city', $request->cities);
            }

            $sellers = $query->latest()->paginate(9)->withQueryString();
        }

        // --- 3. DATA FILTER DINAMIS ---
        $allCategories = Category::all();
        
        // Ambil Propinsi (Selalu Full)
        $allProvinces = Seller::where('status', 'ACTIVE')->distinct()->pluck('pic_province');

        // Ambil Kota (DINAMIS: Menyesuaikan Propinsi Terpilih)
        $cityQuery = Seller::where('status', 'ACTIVE');
        if ($request->filled('provinces')) {
            // Kalau ada propinsi dipilih, ambil kota DARI propinsi itu saja
            $cityQuery->whereIn('pic_province', $request->provinces);
        }
        $allCities = $cityQuery->distinct()->pluck('pic_city');

        // Data Populer (Statik untuk contoh)
        $topProvinces = Seller::where('status', 'ACTIVE')
            ->select('pic_province', DB::raw('count(*) as total'))
            ->groupBy('pic_province')
            ->orderByDesc('total')
            ->limit(3)
            ->pluck('pic_province');

        return view('welcome', compact('products', 'sellers', 'type', 'isSearching', 
                    'allCategories', 'allProvinces', 'allCities', 'topProvinces'));
    }

    public function show($slug)
    {
        $product = Product::where('slug', $slug)
                    ->with(['seller', 'reviews' => fn($q) => $q->latest()])
                    ->withAvg('reviews', 'rating')
                    ->withCount('reviews')
                    ->firstOrFail();

        return view('products.show', compact('product'));
    }

    // 4. HALAMAN DETAIL TOKO (PROFIL TOKO)
    public function storeDetail(Request $request, $id)
    {
        // 1. Ambil Data Toko
        $seller = Seller::where('status', 'ACTIVE')->findOrFail($id);

        // 2. Siapkan Query Produk Toko Ini
        $query = Product::where('seller_id', $id)
                        ->with(['category'])
                        ->withAvg('reviews', 'rating')
                        ->withCount('reviews');

        // 3. Filter Kategori (Khusus di dalam toko ini)
        if ($request->has('category')) {
            $query->where('category_id', $request->category);
        }

        // 4. Ambil Produk
        $products = $query->latest()->paginate(12);

        // 5. Ambil Daftar Kategori yang DIMILIKI toko ini saja (Untuk filter)
        $storeCategories = Category::whereHas('products', function($q) use ($id) {
            $q->where('seller_id', $id);
        })->get();

        return view('stores.show', compact('seller', 'products', 'storeCategories'));
    }
}