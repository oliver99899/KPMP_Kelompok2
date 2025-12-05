<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['category', 'seller'])
                        ->withAvg('reviews', 'rating') //
                        ->withCount('reviews');

        // Filter Pencarian
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Filter Kategori
        if ($request->has('category') && $request->category != '') {
            $query->where('category_id', $request->category);
        }

        $products = $query->latest()->paginate(12);
        $categories = Category::all();

        return view('welcome', compact('products', 'categories'));
    }

    public function show($slug)
    {
        $product = Product::where('slug', $slug)
                    ->with(['seller', 'reviews' => function($q) {
                        $q->latest();
                    }])
                    ->withAvg('reviews', 'rating')
                    ->firstOrFail();

        return view('products.show', compact('product'));
    }
}