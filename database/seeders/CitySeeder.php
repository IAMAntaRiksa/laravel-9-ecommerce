<?php

namespace Database\Seeders;

use App\Models\City;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $response = Http::withHeaders([
            'key' => config('services.rajaongkir.key')
        ])->get('https://api.rajaongkir.com/starter/city');

        $datas = $response['rajaongkir']['results'];

        foreach ($datas as  $result) {
            City::create([
                'city_id' => $result['city_id'],
                'province_id' => $result['province_id'],
                'name' => $result['type'] . ' - ' . $result['city_name'],
            ]);
        }
    }
}