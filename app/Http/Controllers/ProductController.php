<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $products = $user->products()->with('media')->get()->map(function ($product) {
            return [
                'id' => $product->id,
                'name' => $product->name,
                'is_active' => $product->is_active,
                'price' => $product->price,
                'description' => $product->description,
                'images' => $product->getMedia('images')->map(fn($media) => $media->getUrl()),
                'category' => $product->category->name,
            ];
        });
        return inertia('product/Index', [
            'products' => $products,
        ]);
    }
    public function create()
    {
        return inertia('product/Create' , [
            'categories' => auth()->user()->categories,
        ]);
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required',
            'category_id' => 'required|numeric|id_exists:categories',
        ]);
        $product = Product::create($request->all());
        if ($request->input('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image['file']->store('images' , 'public');
                $product->addMedia(storage_path('app/public/' . $path))->toMediaCollection('images');
                Storage::disk('public')->delete( $path);
            }
        }
        return redirect()->route('products.index')->with('success', 'Ürün Eklendi.');
    }
    public function show(Product $product)
    {
        return inertia('product/Show', [
            'product' => $product->load('category'),
            'images' => $product->getMedia('images')->map(fn($media) => $media->getUrl()),
        ]);
    }
    public function edit(Product $product)
    {
        return inertia('product/Edit', [
            'product' => $product->load('category'),
            'categories' => auth()->user()->categories,
        ]);
    }
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required',
            'category_id' => 'required',
        ]);
        $product->update($request->all());
        if ($request->input('images')) {
            $product->clearMediaCollection('images');
            foreach ($request->file('images') as $image) {
                $path = $image['file']->store('images', 'public');
                $product->addMedia(storage_path('app/public/images/' . basename($path)))->toMediaCollection('images');
                Storage::disk('public')->delete( $path);
            }
        }
        return redirect()->route('products.index')->with('success', 'Ürün Güncellendi.');
    }
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Ürün Silindi.');
    }
}
