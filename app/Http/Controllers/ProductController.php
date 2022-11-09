<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $datas = Product::with('category')->when(request()->q, function ($products) {
            $products = $products->where('title', 'like', '%' . request()->q . '%');
        })->orderBy('id', 'DESC')->paginate(5);

        return view('page.product.index',  compact('datas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        return view('page.product.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $message = [
            'file.required' =>  Lang::get('web.file-required'),
            'file' => Lang::get('web.file-mimes'),
            'title.required' => Lang::get('web.name-required'),
            'title' => Lang::get('web.name'),
            'category_id.required' => Lang::get('web.select-item'),
            'content.required' => Lang::get('web.content-required'),
            'weight.required' => Lang::get('web.weight-required'),
            'price.required' => Lang::get('web.price-required'),
        ];

        $validator = Validator::make($request->all(), [
            'file' => 'required|image|mimes:jpeg,jpg,png|max:2000',
            'title' => 'required|unique:products',
            'category_id' => 'required',
            'content' => 'required',
            'weight' => 'required',
            'price' => 'required',
        ], $message);

        if ($validator->fails()) {
            $validator->errors()->add('message', Lang::get('web.create-failed'));
            return redirect()->back()->withInput()->withErrors($validator);
        }

        $image = $request->file('file');
        $image->storeAs('/public/products', $image->hashName());

        $data = Product::create([
            'image' => $image->hashName(),
            'title' => $request->title,
            'slug' => Str::slug($request->title, '-'),
            'category_id' => $request->category_id,
            'content' => $request->content,
            'weight' => $request->weight,
            'price' => $request->price,
            'discount' => $request->discount,
        ]);

        try {
            $data->save();
        } catch (\Exception $errors) {
            return redirect()->back()
                ->withInput()->withErrors(['message' => Lang::get('web.create-failed')]);
        }
        Session::flash('message', Lang::get('web.create-success'));
        return redirect()->route('product.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('page.product.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $message = [
            'file.required' =>  Lang::get('web.file-required'),
            'file' => Lang::get('web.file-mimes'),
            'title.required' => Lang::get('web.name-required'),
            'title' => Lang::get('web.name'),
            'category_id.required' => Lang::get('web.select-item'),
            'content.required' => Lang::get('web.content-required'),
            'weight.required' => Lang::get('web.weight-required'),
            'price.required' => Lang::get('web.price-required'),
            'discount.required' => Lang::get('web.discount-required'),
        ];

        $validator = Validator::make($request->all(), [
            'file' => 'nullable|image|mimes:jpeg,jpg,png|max:2000',
            'title' => 'required|unique:products,title,' . $product->id,
            'category_id' => 'required',
            'content' => 'required',
            'weight' => 'required',
            'price' => 'required',
            'discount' => 'nullable',
        ], $message);

        if ($validator->fails()) {
            $validator->errors()->add('message', Lang::get('web.create-failed'));
            return redirect()->back()->withInput()->withErrors($validator);
        }

        if ($request->file('file')) {
            Storage::disk('local')->delete('/public/products/' . basename($product->image));

            $image = $request->file('file');
            $image->storeAs('/public/products/', $image->hashName());

            $product->update([
                'image' => $image->hashName(),
                'title' => $request->title,
                'slug' => Str::slug($request->title, '-'),
                'category_id' => $request->category_id,
                'content' => $request->content,
                'unit' => $request->unit,
                'weight' => $request->weight,
                'price' => $request->price,
                'discount' => $request->discount,
                'keywords' => $request->keywords,
                'description' => $request->description
            ]);
        }

        try {
            $product->update([
                'title' => $request->title,
                'slug' => Str::slug($request->title, '-'),
                'category_id' => $request->category_id,
                'content' => $request->content,
                'unit' => $request->unit,
                'weight' => $request->weight,
                'price' => $request->price,
                'discount' => $request->discount,
                'keywords' => $request->keywords,
                'description' => $request->description
            ]);
        } catch (\Exception $errors) {
            return redirect()->back()
                ->withInput()->withErrors(['message' => Lang::get('web.update-failed')]);
        }

        Session::flash('message', Lang::get('web.update-success'));
        return redirect()->route('product.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)

    {
        Storage::disk('local')->delete('public/products/' . basename($product->image));
        $product->delete();

        if ($product) {
            return response()->json([
                'status' => 'success'
            ]);
        } else {
            return response()->json([
                'status' => 'error'
            ]);
        }
    }
}