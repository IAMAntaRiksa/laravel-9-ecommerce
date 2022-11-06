<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        $datas =  Category::when(request()->q, function ($categories) {
            $categories = $categories->where('name', 'like', '%' . request()->q . '%');
        })->orderBy('id', 'DESC')->paginate(5);

        return view('page.category.index', compact('datas'));
    }

    public function create()
    {
        return view('page.category.create');
    }

    public function store(Request $request)
    {
        $message = [
            'name.required' => Lang::get('web.name-required'),
            'file.required' => Lang::get('web.file-required'),
            'file-mimes' => Lang::get('web.file-mimes'),
        ];
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:categories',
            'file' => 'required|image|mimes:jpeg,jpg,png|max:2000',
            'file-mimes' => 'required|image|mimes:jpeg,jpg,png|max:2000',
        ], $message);

        if ($validator->fails()) {
            $validator->errors()->add('message', Lang::get('web.create-failed'));
            return redirect()->back()->withInput()->withErrors($validator);
        }

        $image = $request->file('file');
        $image->storeAs('/public/categories/', $image->hashName());

        $data = Category::create([
            'name' => $request->name,
            'image' => $image->hashName(),
            'slug' => Str::slug($request->name, '-'),
        ]);

        try {
            $data->save();
        } catch (\Exception $errors) {
            return redirect()->back()
                ->withInput()->withErrors(['message' => Lang::get('web.create-failed')]);
        }
        Session::flash('message', Lang::get('web.create-success'));
        return redirect()->route('category.index');
    }

    public function edit(Category $category)
    {
        return view('page.category.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $message = [
            'name.required' => Lang::get('web.name-required'),
        ];
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:categories,name,' . $category->id,
            'file' => 'nullable|image|mimes:jpeg,jpg,png|max:2000',

        ], $message);

        if ($validator->fails()) {
            $validator->errors()->add('message', Lang::get('web.update-failed'));
            return redirect()->back()->withInput()->withErrors($validator);
        }

        if ($request->file('file')) {
            Storage::disk('local')->delete('/public/categories/' . basename($category->image));

            $image = $request->file('file');
            $image->storeAs('/public/categories/', $image->hashName());

            $category->update([
                'image' => $image->hashName(),
                'name' => $request->name,
                'slug' => Str::slug($request->name, '-')
            ]);
        }

        try {
            $category->update([
                'name' => $request->name,
                'slug' => Str::slug($request->name, '-')
            ]);
        } catch (\Exception $errors) {
            return redirect()->back()
                ->withInput()->withErrors(['message' => Lang::get('web.update-failed')]);
        }

        Session::flash('message', Lang::get('web.update-success'));
        return redirect()->route('category.index');
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);

        if ($category) {
            Storage::disk('local')->delete('/public/categories/' . basename($category->image));
            $category->delete();
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