<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductColor;
use App\Models\ProductSize;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('images', 'colors', 'sizes')->latest()->get();
        return view('products.index', compact('products'));
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'sku' => 'required|string|max:100|unique:products',
            'price' => 'required|numeric',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'colors' => 'array',
            'sizes' => 'array',
        ]);

        $product = Product::create([
            'name' => $request->name,
            'sku' => $request->sku,
            'price' => $request->price,
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('products', 'public');
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $path,
                ]);
            }
        }

        if ($request->colors) {
            foreach ($request->colors as $color) {
                ProductColor::create([
                    'product_id' => $product->id,
                    'color' => $color,
                ]);
            }
        }

        if ($request->sizes) {
            foreach ($request->sizes as $size) {
                ProductSize::create([
                    'product_id' => $product->id,
                    'size' => $size,
                ]);
            }
        }

        return redirect()->route('products.index')->with('success', 'Product created successfully!');
    }

    public function edit($id)
{
    $product = Product::with('images', 'colors', 'sizes')->findOrFail($id);
    return view('products.edit', compact('product'));
}

// Update Product
public function update(Request $request, $id)
{
    $product = Product::findOrFail($id);

    $request->validate([
        'name' => 'required|string|max:255',
        'sku' => 'required|string|max:100|unique:products,sku,' . $product->id,
        'price' => 'required|numeric',
        'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $product->update([
        'name' => $request->name,
        'sku' => $request->sku,
        'price' => $request->price,
    ]);

    // If new images uploaded
    if ($request->hasFile('images')) {
        foreach ($request->file('images') as $image) {
            $path = $image->store('products', 'public');
            $product->images()->create([
                'image_path' => $path,
            ]);
        }
    }

    // Update Colors
    $product->colors()->delete();
    if ($request->colors) {
        foreach ($request->colors as $color) {
            $product->colors()->create([
                'color' => $color,
            ]);
        }
    }

    // Update Sizes
    $product->sizes()->delete();
    if ($request->sizes) {
        foreach ($request->sizes as $size) {
            $product->sizes()->create([
                'size' => $size,
            ]);
        }
    }

    return redirect()->route('products.index')->with('success', 'Product updated successfully!');
}

// Delete Product
public function destroy($id)
{
    $product = Product::findOrFail($id);
    $product->delete();

    return redirect()->route('products.index')->with('success', 'Product deleted successfully!');
}
}
