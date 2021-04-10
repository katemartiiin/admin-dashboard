<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductImages;
use Illuminate\Support\Carbon;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Product::orderBy('created_at', 'DESC')->get();
    }

    public function read($id)
    {
        return Product::find($id);
    }
    public function getImages($id){
        $images = ProductImages::where('product_id', $id)->orderBy('created_at', 'DESC')->get();
        foreach ($images as $data) {
            $data->images = json_decode($data->images);
        }
        return response()->json(['images' => $images]);
    }

    public function search($keyword){
        if ($keyword == 'all'){
            return Product::orderBy('created_at', 'DESC')->get();
        }
        return Product::where('description', 'LIKE', "%{$keyword}%")
        ->orWhere('name', 'LIKE', "%{$keyword}%")->get();
    }

    public function category($category){
        if ($category == 'All'){
            return Product::orderBy('created_at', 'DESC')->get();
        }
        return Product::where('category', $category)->get();
    }

    public function categories(){
        return Product::select('category')->groupBy('category')->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $newProduct = new Product;
        $newProduct->name = $request->product['name'];
        $newProduct->category = $request->product['category'];
        $newProduct->description = $request->product['description'];
        $newProduct->date_time = $request->product['date_time'];
        $newProduct->created_by = $request->product['created_by'];
        $newProduct->save();

        return $newProduct;
    }
    public function images(Request $request){
        $lastId = count(Product::all());
        if ($request->file('files')){
            $pictures = [];

            foreach ($request->file('files') as $file) {
                $filename = '/images/' . $file->getClientOriginalName();
                $file->move(public_path('images'), $filename);
                $pictures[] = $filename;
            }

            ProductImages::create([
                'images' => json_encode($pictures),
                'product_id' => $lastId
            ]);
        }
        return response()->json(['message' => 'Images uploaded']);
    }
    public function addImages(Request $request, $id){
        if ($request->file('files')){
            $pictures = [];

            foreach ($request->file('files') as $file) {
                $filename = '/images/' . $file->getClientOriginalName();
                $file->move(public_path('images'), $filename);
                $pictures[] = $filename;
            }

            ProductImages::create([
                'images' => json_encode($pictures),
                'product_id' => $id
            ]);
        }
        return response()->json(['message' => 'Images uploaded']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $existingProduct = Product::find($id);

        if ($existingProduct) {
            if ($request->product['name']){
                $existingProduct->name = $request->product['name'] ? $request->product['name'] : $existingProduct->name;
            }

            if ($request->product['category']) {
                $existingProduct->category = $request->product['category'] ? $request->product['category'] : $existingProduct->category;
            }

            if ($request->product['description']) {
                $existingProduct->description = $request->product['description'] ? $request->product['description'] : $existingProduct->description;
            }
            
            if ($request->product['date_time']) {
                $existingProduct->date_time = $request->product['date_time'] ? $request->product['date_time'] : $existingProduct->date_time;
            }
            
            $existingProduct->save();
            return $existingProduct;
        }

        return "Product not found.";
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $existingProduct = Product::find($id);

        if ($existingProduct) {
            $existingProduct->delete();
            return "Product successfully deleted.";
        }

        return "Product not found.";
    }
    public function deleteImages($id) {
        $existingImages = ProductImages::find($id);

        if ($existingImages) {
            $existingImages->delete();
            return "Images successfully deleted.";
        }

        return "Images not found.";
    }
}