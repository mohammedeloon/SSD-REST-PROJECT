<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class webproductController extends Controller
{
    public function index(){
        $products = Product::all();
        return view('products.index', compact('products'));
    }

    public function create(){
        return view('products.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'quantity' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
            // 'seller_id' => 'required|exists:users,id'
        ]);
       
        Product::create($validated);

        return to_route('admin.products.index')->with('message', 'Product Created successfully.');
    }

    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'quantity' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
            // 'seller_id' => 'required|exists:users,id'
        ]);
        $product->update($validated);

        return to_route('admin.products.index', $product)->with('message', 'Product Updated Successfully.');
    }

    public function destroy(Product $product)
    {
        if (!$product) {
            return back()->with('message', 'Product Not Found');
        }

        $product->delete();
        return back()->with('message', 'Product Deleted Successfully');
    }
}
