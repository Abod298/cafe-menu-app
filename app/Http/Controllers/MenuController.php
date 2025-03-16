<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($slug)
    {
        $user = User::where('slug', $slug)->firstOrFail();

        $categories = $user->categories()
            ->where('is_active', true)
            ->with(['media', 'products'])
            ->get()
            ->map(function ($category) {
                return [
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
                ];
            });
        return inertia('Welcome' , [
            'categories' => $categories
        ]);
    }
}
