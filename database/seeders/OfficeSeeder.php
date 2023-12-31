<?php

namespace Database\Seeders;

use App\Enums\OfficeType;
use App\Models\Office;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Laravolt\Indonesia\Models\Village;

class OfficeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Office::truncate();

        $sukun = Village::selectRaw('id,district_code,meta')
            ->with([
                'district:id,code,city_code,meta',
                'district.city:id,code,province_code,meta',
                'district.city.province:id,code'
            ])
            ->where('name', 'sukun')
            ->first();
        $sukunGeo = $sukun->meta;

        $manyar = Village::selectRaw('id,district_code,meta')
            ->with([
                'district:id,code,city_code,meta',
                'district.city:id,code,province_code,meta',
                'district.city.province:id,code'
            ])
            ->where('name', 'manyar')
            ->first();
        $manyarGeo = $manyar->meta;

        $cepu = Village::selectRaw('id,district_code,meta')
            ->with([
                'district:id,code,city_code,meta',
                'district.city:id,code,province_code,meta',
                'district.city.province:id,code'
            ])
            ->where('name', 'cepu')
            ->first();
        $cepuGeo = $cepu->meta;

        $solo = Village::selectRaw('id,district_code,meta')
            ->with([
                'district:id,code,city_code,meta',
                'district.city:id,code,province_code,meta',
                'district.city.province:id,code'
            ])
            ->where('name', 'solo')
            ->first();
        $soloGeo = $solo->meta;

        Office::insert([
            [
                'name' => 'HQ Office',
                'address' => 'Jl. dukuh',
                'province_id' => $sukun->district->city->province->id,
                'city_id' => $sukun->district->city->id,
                'district_id' => $sukun->district->id,
                'village_id' => $sukun->id,
                'latitude' => $sukunGeo['lat'],
                'longitude' => $sukunGeo['long'],
                'office_type' => OfficeType::Office->value,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Branch Office',
                'address' => 'Jl. Manyar Indah',
                'province_id' => $manyar->district->city->province->id,
                'city_id' => $manyar->district->city->id,
                'district_id' => $manyar->district->id,
                'village_id' => $manyar->id,
                'latitude' => $manyarGeo['lat'],
                'longitude' => $manyarGeo['long'],
                'office_type' => OfficeType::Branch->value,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Mining 2',
                'address' => 'Jl. Cepu',
                'province_id' => $cepu->district->city->province->id,
                'city_id' => $cepu->district->city->id,
                'district_id' => $cepu->district->id,
                'village_id' => $cepu->id,
                'latitude' => $cepuGeo['lat'],
                'longitude' => $cepuGeo['long'],
                'office_type' => OfficeType::Mine->value,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Mining 3',
                'address' => 'Jl. Solo Balapan',
                'province_id' => $solo->district->city->province->id,
                'city_id' => $solo->district->city->id,
                'district_id' => $solo->district->id,
                'village_id' => $solo->id,
                'latitude' => $soloGeo['lat'],
                'longitude' => $soloGeo['long'],
                'office_type' => OfficeType::Mine->value,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
