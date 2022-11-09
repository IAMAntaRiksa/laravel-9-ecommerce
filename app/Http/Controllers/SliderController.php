<?php

namespace App\Http\Controllers;

use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class SliderController extends Controller
{
    public function index()
    {
        $datas = Slider::latest()->paginate(5);
        return view('page.slider.index', compact('datas'));
    }

    public function store(Request $request)
    {
        $message = [
            'file' => Lang::get('web.file-mimes'),
            'file.required' => Lang::get('web.file-required'),
            'link.required' => Lang::get('web.link-required'),
        ];

        $validator = Validator::make($request->all(), [
            'file' => 'required|image|mimes:jpeg,jpg,png|max:2000',
            'link' => 'required'
        ], $message);

        if ($validator->fails()) {
            $validator->errors()->add('message', Lang::get('web.create-failed'));
            return redirect()->back()->withInput()->withErrors($validator);
        }

        $image = $request->file('file');
        $image->storeAs('/public/sliders/', $image->hashName());

        $data = Slider::create([
            'image' => $image->hashName(),
            'link' => $request->link,
        ]);

        try {
            $data->save();
        } catch (\Exception $errors) {
            return redirect()->back()
                ->withInput()->withErrors(['message' => Lang::get('web.create-failed')]);
        }

        Session::flash('message', Lang::get('web.create-success'));
        return redirect()->route('slider.index');
    }

    public function destroy(Slider $slider)
    {
        Storage::disk('local')->delete('/public/sliders/' . basename($slider->image));
        $slider->delete();
        if ($slider) {
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