<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CategoryController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $categories = $user->categories()
            ->with('media' , 'products')
            ->get()->map(function ($category) {
            return [
                'id' => $category->id,
                'name' => $category->name,
                'description' => $category->description,
                'is_active' => $category->is_active,
                'images' => $category->getMedia('images')->map(fn($media) => $media->getUrl()),
                'products_count' => $category->products->count(),
            ];
        });
        return Inertia::render('categories/Index', [
            'categories' => $categories
        ]);
    }
    public function create()
    {
        return Inertia::render('categories/Create');
    }
    public function store(Request $request)
    {
        $data = $request->all();
        $data['user_id'] = auth()->id();
        $category = Category::create($data);
        if($request->input('images')) {
            foreach ($request->file('images') as $image) {;
                $path = $image['file']->store('images', 'public');
                $category->addMedia(storage_path('app/public/images/' . basename($path)))->toMediaCollection('images');
                Storage::disk('public')->delete( $path);
            }
        }

        return redirect()->route('categories.index')->with('success', 'Kategori Eklendi.');
    }
    public function show(Category $category)
    {
        return Inertia::render('categories/Show', [
            'category' => [
                'id' => $category->id,
                'name' => $category->name,
                'description' => $category->description,
                'images' => $category->getMedia('images')->map(fn($media) => $media->getUrl()),
                'products_count' => $category->products->count(),
                'products' => $category->products->map(function ($product) {
                    return [
                        'id' => $product->id,
                        'name' => $product->name,
                        'description' => $product->description,
                        'price' => $product->price,
                        'images' => $product->getMedia('images')->map(fn($media) => $media->getUrl()),
                    ];
                }),
            ]
        ]);
    }
    public function edit(Category $category)
    {
        return Inertia::render('categories/Edit', [
            'category' => $category,
        ]);
    }
    public function update(Request $request, Category $category)
    {
        $category->update($request->all());
        if ($request->input('images')) {
            $category->clearMediaCollection('images');
            foreach ($request->file('images') as $image) {
                $path = $image['file']->store('images', 'public');
                $category->addMedia(storage_path('app/public/images/' . basename($path)))->toMediaCollection('images');
                Storage::disk('public')->delete( $path);
            }
        }
        return redirect()->route('categories.index')->with('success', 'Kategori Güncellendi.');
    }
    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('categories.index')->with('success', 'Kategori Silindi.');
    }
}
