<?php

namespace Database\Seeders;

use App\Enums\VehicleOwnership;
use App\Enums\VehicleStatus;
use App\Enums\VehicleType;
use App\Models\Vehicle;
use App\Models\VehicleBrand;
use App\Models\VehicleModel;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class VehicleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();

        Vehicle::truncate();
        VehicleModel::truncate();
        VehicleBrand::truncate();

        Schema::enableForeignKeyConstraints();

        $models = [
            [
                'brand' => 'Toyota',
                'models' => [
                    ['name' => 'Innova'],
                    ['name' => 'Yaris'],
                    ['name' => 'Raze'],
                    ['name' => 'Avanza'],
                ],
            ],
            [
                'brand' => 'Honda',
                'models' => [
                    ['name' => 'Jazz'],
                    ['name' => 'Brio'],
                ],
            ],
            [
                'brand' => 'Hino',
                'models' => [
                    ['name' => 'Hino 500 Series'],
                    ['name' => 'Hino 700 Series - ZY5041 Euro4'],
                    ['name' => 'Hino 700 Series - ZS4141 Euro4'],
                    ['name' => 'Hino Bus 115 SDB STD - Euro4'],
                    ['name' => 'Hino Bus RM280 ABS - Euro4'],
                    ['name' => 'Hino Bus RM280 STD - Euro4'],
                ],
            ],
            [
                'brand' => 'BMW',
                'models' => [
                    ['name' => 'BMW Series 3'],
                    ['name' => 'BMW X7'],
                    ['name' => 'BMW I7'],
                ],
            ],
        ];

        foreach ($models as $model) {
            $vehicleBrand = VehicleBrand::create(['name' => $model['brand']]);

            foreach ($model['models'] as $modelDetail) {
                VehicleModel::create([
                    'name' => $modelDetail['name'],
                    'vehicle_brand_id' => $vehicleBrand->id,
                ]);
            }
        }

        $zy5041 = VehicleModel::selectRaw('id,vehicle_brand_id')->where('name', 'Hino 700 Series - ZY5041 Euro4')->first();
        $zs4141 = VehicleModel::selectRaw('id,vehicle_brand_id')->where('name', 'Hino 700 Series - ZS4141 Euro4')->first();
        $bus115 = VehicleModel::selectRaw('id,vehicle_brand_id')->where('name', 'Hino Bus 115 SDB STD - Euro4')->first();
        $bus280abs = VehicleModel::selectRaw('id,vehicle_brand_id')->where('name', 'Hino Bus RM280 ABS - Euro4')->first();
        $x7 = VehicleModel::selectRaw('id,vehicle_brand_id')->where('name', 'BMW X7')->first();
        $jazz = VehicleModel::selectRaw('id,vehicle_brand_id')->where('name', 'Jazz')->first();
        $brio = VehicleModel::selectRaw('id,vehicle_brand_id')->where('name', 'Brio')->first();
        $innova = VehicleModel::selectRaw('id,vehicle_brand_id')->where('name', 'Innova')->first();

        Vehicle::insert([
            [
                'vehicle_brand_id' => $zy5041->vehicle_brand_id,
                'vehicle_model_id' => $zy5041->id,
                'license_plate' => 'N 743 UG',
                'status' => VehicleStatus::Idle->value,
                'color' => 'green',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'vehicle_type' => VehicleType::FreightTransportation->value,
                'ownership_status' => VehicleOwnership::Owned->value,
                'fuel_consumption' => '50',
            ],
            [
                'vehicle_brand_id' => $zs4141->vehicle_brand_id,
                'vehicle_model_id' => $zs4141->id,
                'license_plate' => 'N 1234 UGH',
                'status' => VehicleStatus::Idle->value,
                'color' => 'blue',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'vehicle_type' => VehicleType::FreightTransportation->value,
                'ownership_status' => VehicleOwnership::Owned->value,
                'fuel_consumption' => '50',
            ],
            [
                'vehicle_brand_id' => $bus115->vehicle_brand_id,
                'vehicle_model_id' => $bus115->id,
                'license_plate' => 'N 555 UG',
                'status' => VehicleStatus::Idle->value,
                'color' => 'cyan',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'vehicle_type' => VehicleType::PeopleTransportation->value,
                'ownership_status' => VehicleOwnership::Owned->value,
                'fuel_consumption' => '45',
            ],
            [
                'vehicle_brand_id' => $bus280abs->vehicle_brand_id,
                'vehicle_model_id' => $bus280abs->id,
                'license_plate' => 'N 89 UR',
                'status' => VehicleStatus::Idle->value,
                'color' => 'white',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'vehicle_type' => VehicleType::PeopleTransportation->value,
                'ownership_status' => VehicleOwnership::Owned->value,
                'fuel_consumption' => '60',
            ],
            [
                'vehicle_brand_id' => $jazz->vehicle_brand_id,
                'vehicle_model_id' => $jazz->id,
                'license_plate' => 'N 190 UGC',
                'status' => VehicleStatus::Idle->value,
                'color' => 'white',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'vehicle_type' => VehicleType::PeopleTransportation->value,
                'ownership_status' => VehicleOwnership::Rent->value,
                'fuel_consumption' => '115',
            ],
            [
                'vehicle_brand_id' => $brio->vehicle_brand_id,
                'vehicle_model_id' => $brio->id,
                'license_plate' => 'N 3 UGC',
                'status' => VehicleStatus::Idle->value,
                'color' => 'black',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'vehicle_type' => VehicleType::PeopleTransportation->value,
                'ownership_status' => VehicleOwnership::Rent->value,
                'fuel_consumption' => '120',
            ],
        ]);
    }
}
