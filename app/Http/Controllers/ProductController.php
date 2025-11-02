<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // if (!Auth::check()) {
        //     return redirect()->route('login');
        // }


        if (Auth::user()->usertype == 'user') {
            $products = Product::orderBy('created_at', 'desc')->get();
            return view('products.index', ['products' => $products]);
        }

        // return view('welcome');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'sku' => 'required|unique:products,sku',
            'image' => 'image|mimes:jpeg,png,gif|max:2048',
            'price' => 'required|numeric',
            'status' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect(route('products.create'))->withErrors($validator)->withInput();
        }

        $product = new Product();
        $product->name = $request->name;
        $product->sku = $request->sku;
        $product->price = $request->price;
        $product->status = $request->status;
        $product->save();


        if ($request->hasFile('image')) {
            $image = $request->image;
            $imagename = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/products'), $imagename);
            $product->image = $imagename;
            $product->save();
        }



        return redirect(route('products.index'))->with('success', 'product created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $product = Product::findorfail($id);
        return view('products.edit', ['product' => $product]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id, Request $request)
    {
        $product = Product::findorfail($id);

        $oldimage = $product->image;

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'image' => 'image|mimes:jpeg,png,gif|max:2048',
            'price' => 'required|numeric',
            'status' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect(route('products.edit', $product->id))->withErrors($validator)->withInput();
        }

        $product->name = $request->name;
        $product->sku = $request->sku;
        $product->price = $request->price;
        $product->status = $request->status;
        $product->save();


        if ($request->hasFile('image')) {
            if ($oldimage != null && File::exists(public_path('uploads/products/' . $oldimage))) {
                File::delete(public_path('uploads/products/' . $oldimage));
            }
            $image = $request->image;
            $imagename = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/products'), $imagename);
            $product->image = $imagename;
            $product->save();
        }



        return redirect(route('products.index'))->with('success', 'product updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        if ($product->image != null && File::exists(public_path('uploads/products/' . $product->image))) {
            File::delete(public_path('uploads/products/' . $product->image));
        }
        $product->delete();

        return redirect(route('products.index'))->with('success', 'product deleted successfully');
    }
}
