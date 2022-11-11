<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Province;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class RajaOngkirController extends Controller
{
    public function getProvinces()
    {
        try {
            $provinces = Province::all();
            return response()->json($provinces, 200);
        } catch (\Exception $errors) {
            $this->format(
                "10",
                "Get Item Error",
                $errors->getMessage()
            );
        }
    }

    public function getCities(Request $request)
    {
        try {
            //get cities by province
            $cities = City::where(
                'province_id',
                $request->province_id
            )->get();
            return response()->json($cities);
        } catch (\Exception $errors) {
            $this->format(
                "10",
                "Get Item Error",
                $errors->getMessage()
            );
        }
    }

    public function checkOngkir(Request $request)
    {
        $response = Http::withHeaders([
            'key' => config('services.rajaongkir.key'),
        ])->post('https://api.rajaongkir.com/starter/cost', [
            'origin' => 113,
            'destination' => $request->destination,
            'weight' => $request->weight,
            'courier' => $request->courier
        ]);

        $datas = $response['rajaongkir']['results'][0];
        return response()->json($datas);
    }
}