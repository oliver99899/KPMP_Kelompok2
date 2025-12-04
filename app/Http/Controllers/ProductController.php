<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Seller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    // --- 1. READ (Lihat Daftar Produk Saya) ---
    public function index()
    {
        // Ambil data seller dari user yang login
        $seller = Seller::where('user_id', Auth::id())->first();

        // Cek apakah akun toko aktif
        if (!$seller || $seller->status !== 'ACTIVE') {
            return redirect()->route('dashboard')->with('error', 'Akun toko Anda belum aktif. Silakan tunggu verifikasi.');
        }
        
        // Ambil produk milik seller tersebut (terbaru di atas)
        $products = Product::where('seller_id', $seller->id)->latest()->get();

        return view('products.index', compact('products'));
    }

    // --- 2. CREATE (Tampilkan Form Buat Baru) ---
    public function create()
    {
        // Cek status toko lagi untuk keamanan
        $seller = Seller::where('user_id', Auth::id())->first();
        if (!$seller || $seller->status !== 'ACTIVE') {
            return redirect()->route('dashboard')->with('error', 'Hanya penjual aktif yang bisa upload produk.');
        }

        // Ambil kategori untuk dropdown
        $categories = Category::all();

        return view('products.create', compact('categories'));
    }

    // --- 3. STORE (Simpan Data Baru ke Database) ---
    public function store(Request $request)
    {
        // Validasi input dengan Pesan Bahasa Indonesia
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:100',
            'stock' => 'required|integer|min:1', // Produk baru minimal stok 1
            'description' => 'nullable|string',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048', // Wajib ada gambar
        ], [
            // KAMUS PESAN ERROR INDONESIA
            'name.required' => 'Nama produk wajib diisi!',
            'category_id.required' => 'Mohon pilih kategori produk!',
            'price.required' => 'Harga produk harus diisi!',
            'price.min' => 'Harga minimal Rp 100.',
            'stock.required' => 'Stok awal harus diisi!',
            'stock.min' => 'Stok minimal 1 pcs untuk produk baru!',
            'image.required' => 'Foto produk wajib diupload!',
            'image.max' => 'Ukuran foto maksimal 2MB!',
            'image.mimes' => 'Format foto harus JPG, JPEG, atau PNG!',
        ]);

        $seller = Seller::where('user_id', Auth::id())->firstOrFail();

        // Upload gambar baru
        $imagePath = $request->file('image')->store('product_images', 'public');

        // Buat slug unik
        $slug = \Str::slug($request->name) . '-' . time();

        Product::create([
            'seller_id' => $seller->id,
            'category_id' => $request->category_id,
            'name' => $request->name,
            'slug' => $slug,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'image_path' => $imagePath,
        ]);

        return redirect()->route('products.index')->with('success', 'Produk berhasil diupload!');
    }

    // --- 4. EDIT (Tampilkan Form Edit) ---
    public function edit(Product $product)
    {
        // Security Check: Pastikan produk ini milik si penjual yang sedang login
        $seller = Seller::where('user_id', Auth::id())->firstOrFail();
        
        // Jika ID toko di produk beda dengan ID toko user login, tolak akses
        if ($product->seller_id !== $seller->id) {
            abort(403, 'Anda tidak berhak mengedit produk ini.');
        }

        $categories = Category::all();
        return view('products.edit', compact('product', 'categories'));
    }

    // --- 5. UPDATE (Simpan Perubahan ke Database) ---
    public function update(Request $request, Product $product)
    {
        // Security Check
        $seller = Seller::where('user_id', Auth::id())->firstOrFail();
        if ($product->seller_id !== $seller->id) abort(403);

        // Validasi dengan Pesan Bahasa Indonesia
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:1',
            'stock' => 'required|integer|min:0', // Boleh 0 saat edit
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Image boleh kosong saat edit
        ], [
            // KAMUS PESAN ERROR INDONESIA
            'name.required' => 'Nama produk tidak boleh kosong!',
            'price.required' => 'Harga produk harus diisi!',
            'price.min' => 'Harga tidak boleh kurang dari 1!',
            'stock.required' => 'Stok produk harus diisi!',
            'stock.min' => 'Stok tidak boleh kurang dari 0!',
            'image.max' => 'Ukuran foto maksimal 2MB!',
        ]);

        // Handle Image Upload (Jika ada gambar baru)
        if ($request->hasFile('image')) {
            // Hapus gambar lama dari penyimpanan agar hemat space
            if ($product->image_path) {
                Storage::disk('public')->delete($product->image_path);
            }
            // Upload gambar baru
            $product->image_path = $request->file('image')->store('product_images', 'public');
        }

        // Update data produk
        $product->update([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'slug' => \Str::slug($request->name) . '-' . $product->id, // Update slug juga
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            // image_path sudah dihandle di atas
        ]);

        return redirect()->route('products.index')->with('success', 'Produk berhasil diperbarui!');
    }

    // --- 6. DESTROY (Hapus Produk) ---
    public function destroy(Product $product)
    {
        // Security Check
        $seller = Seller::where('user_id', Auth::id())->firstOrFail();
        if ($product->seller_id !== $seller->id) abort(403);

        // Hapus file gambar dari penyimpanan
        if ($product->image_path) {
            Storage::disk('public')->delete($product->image_path);
        }

        // Hapus data dari database
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Produk berhasil dihapus.');
    }
}