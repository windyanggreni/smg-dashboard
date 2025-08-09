<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductApiController extends Controller
{
    public function index(Request $request)
    {
        $categoryId = $request->query('category_id');

        $products = Product::with('category')
            ->when($categoryId, function ($query, $categoryId) {
                return $query->where('category_id', $categoryId);
            })
            ->where('is_active', true)
            ->get();

        // Ubah path image menjadi full URL
        $products->transform(function ($product) {
            if ($product->image) {
                $product->image = asset('storage/' . $product->image);
            }
            return $product;
        });

        return response()->json([
            'message' => 'Daftar produk berhasil diambil',
            'products' => $products
        ]);
    }
}
