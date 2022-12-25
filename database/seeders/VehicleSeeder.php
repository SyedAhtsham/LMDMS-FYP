<?php

namespace Database\Seeders;

use App\Models\CompVehicle;
use App\Models\ContVehicle;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Vehicle;
use Faker\Factory as Faker;

class VehicleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


        $faker = Faker::create();

        for ($i = 1; $i <= 10; $i++) {
            $vehicle = new Vehicle;
            $vehicle->vehicleCode = "";
            $vehicle->plateNo = $faker->randomNumber();
            $vehicle->vehicleModel = $faker->year;
            $vehicle->condition = "Normal";
            $vehicle->status = "Active";
            $vehicle->make = "Honda";
            $vehicle->mileage = 15;
            $vehicle->vehicleType_id = 3;


            $vehicle->save();


            $id = $vehicle->vehicle_id;
            $uniqueVehicleCode = 'VH-';

//        if ($request['ownership'] == 'Company Owned') {
            $uniqueVehicleCode .= 'P' . $id;
//        } elseif ($request['ownership'] == 'Contractual Vehicle') {
//            $uniqueVehicleCode .= 'R' .$id;
//        }

            $vehicle->vehicleCode = $uniqueVehicleCode;

            $vehicle->save();


//        if ($request['ownership'] == "Company Owned") {
            $compVehicle = new CompVehicle;
            $compVehicle->vehicle_id = $id;
            $compVehicle->price = $faker->randomNumber();
            $compVehicle->purchasedDate = $faker->date;
            $compVehicle->save();
//        } elseif ($request['ownership'] == "Contractual Vehicle") {
//            $contVehicle = new ContVehicle;
//            $contVehicle->vehicle_id = $id;
//            $contVehicle->rentPerDay = $faker->randomNumber();
//            $contVehicle->dateOfContract = $faker->date;
//            $contVehicle->save();
//        }

        }
    }
}
