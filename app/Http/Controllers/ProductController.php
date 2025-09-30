<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Traits\CommonTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    use CommonTrait;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = $request->user();
        
        // Admin can see all products, others can only see their own
        if ($user->can('view products')) {
            $products = Product::all();
        } else {
            return $this->sendError(['message' => 'Insufficient permissions'], 403);
        }

        return $this->sendResponse([
            'data' => $products,
            'message' => 'Products retrieved successfully'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!$request->user()->can('create products')) {
            return $this->sendError(['message' => 'Insufficient permissions'], 403);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
        ]);

        $product = Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
        ]);

        return $this->sendResponse([
            'data' => $product,
            'message' => 'Product created successfully'
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Product $product)
    {
        $user = $request->user();

        // Check if user can view this specific product
        if (!$user->can('view products')) {
            return $this->sendError(['message' => 'Insufficient permissions'], 403);
        }

        return $this->sendResponse([
            'data' => $product,
            'message' => 'Product retrieved successfully'
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $user = $request->user();

        // Check if user can update this specific product
        if (!$user->can('edit products')) {
            return $this->sendError(['message' => 'Insufficient permissions'], 403);
        }

        $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'sometimes|required|numeric|min:0',
            'stock' => 'sometimes|required|integer|min:0',
        ]);

        $product->update($request->only(['name', 'description', 'price', 'stock']));

        return $this->sendResponse([
            'message' => 'Product updated successfully'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Product $product)
    {
        $user = $request->user();

        // Check if user can delete this specific product
        if (!$user->can('delete products')) {
            return $this->sendError(['message' => 'Insufficient permissions'], 403);
        }

        $product->delete();

        return $this->sendResponse([
            'message' => 'Product deleted successfully'
        ]);
    }

}
