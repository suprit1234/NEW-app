<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
class ProductController extends Controller
{
    public function index(){
        $products = Product::all();
        return view('products.index', ['products' => $products]);
    }
    
    public function create(){
        return view('products.create');
    }


    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z\s]*$/'],
            'qty' => 'required|numeric',
            'price' => 'required|numeric',
            'description' => 'nullable',

        ]);
        

        $newProduct = Product::create($request->all());

        return redirect()->route('product.index');
    }
    
    public function edit(Product $product){
        return view('products.edit', ['product' => $product]);
    }

    public function update(Request $request, Product $product)
    {   
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z\s]*$/'],
            'qty' => 'required|numeric',
            'price' => 'required|numeric',
            'description' => 'nullable',

        ]);


        $product->update($request->all());
        // $newProduct = Product::create($request->all());

        return redirect()->route('product.index')->with('success', 'Product updates successfully');
    }

    public function destroy(Product $product){
        $product->delete();
        return redirect()->route('product.index')->with('success','Product deleted successfully');
    }
}
