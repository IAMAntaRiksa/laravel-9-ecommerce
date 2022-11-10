<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;

class SliderController extends Controller
{
    public function index()
    {
        try {
            $sliders = Slider::latest()->get();
        } catch (\Exception $errors) {
            $this->format(
                '10',
                'Get Item Error',
                $errors->getMessage()
            );
        }
        $return = $this->format(
            '0',
            'Get Item Succes',
            $sliders
        );
        return response()->json($return);
    }
}