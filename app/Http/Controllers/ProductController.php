<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;
use Gate;
class ProductController extends Controller
{
    public function __construct(){
        abort_if(Gate::denies('product_management_access'),
        Response::HTTP_FORBIDDEN, '403 Forbidden');
    }
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
    public function store(ProductRequest $request)
    {

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
        Gate::authorize('update', $product);
        return inertia('product/Edit', [
            'product' => $product->load('category'),
            'categories' => auth()->user()->categories,
        ]);
    }
    public function update(ProductRequest $request, Product $product)
    {
        Gate::authorize('update', $product);
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
        Gate::authorize('delete', $product);
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Ürün Silindi.');
    }
}
