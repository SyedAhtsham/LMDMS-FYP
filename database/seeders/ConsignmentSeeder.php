<?php

namespace Database\Seeders;

use App\Models\Area;
use App\Models\Consignment;
use App\Models\VehicleType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class ConsignmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $type = new VehicleType;
        $type->volumeCap = 1200;
        $type->weightCap = 1200;
        $type->typeName = "Shahzore";
        $type->save();
        $type = new VehicleType;
        $type->volumeCap = 600;
        $type->weightCap = 350;
        $type->typeName = "Carry";
        $type->save();
        $type = new VehicleType;
        $type->volumeCap = 1000;
        $type->weightCap = 450;
        $type->typeName = "Hilux";
        $type->save();
        $type = new VehicleType;
        $type->volumeCap = 30;
        $type->weightCap = 80;
        $type->typeName = "Bike";
        $type->save();
        $type = new VehicleType;
        $type->volumeCap = 800;
        $type->weightCap = 400;
        $type->typeName = "Van";
        $type->save();







//        $lines = file('englishwords/addresses.txt');
//
//        $cons = Consignment::all();
//
//        foreach($lines as $line) {
//
//        $cons->
//            echo $line;
//        }

//        $faker = Faker::create();





//        $consignment = Consignment::all();
//
//        foreach ($consignment as $cons) {
//            $cons->shipper = $faker->name();
//            $cons->consignee = $faker->name();
//            $cons->save();
//        }

//        $area1 = new Area;
//
//$area1->areaCode = "4400";
//$area1->areaName = "Barakahu/Banigala";
//$area1->extraFuel = 1.5;
//$area1->city = "Islamabad";
//
//$area1->save();
//
//        $area = new Area;
//
//        $area->areaCode = "4100";
//        $area->areaName = "G-5 Sector";
//        $area->extraFuel = 0.5;
//        $area->city = "Islamabad";
//
//        $area->save();

//        $areas = Area::all();



//        for($i=1; $i<=90; $i++) {
//            $consignment = new Consignment;
//            $consignment->consCode = "";
//            $consignment->area_id = $areas[0]->area_id;
//            $consignment->consWeight = 2;
////            $consignment->consVolume = $faker->randomNumber(2);
//                        $consignment->consVolume = 0.5;
//            $consignment->toAddress = $faker->address();
//            $consignment->fromAddress = $faker->address();
//            $consignment->toContact = $faker->phoneNumber();
//            $consignment->fromContact = $faker->phoneNumber();
//            $consignment->consType = "Overnight";
//            $consignment->shipper = $faker->name();
//            $consignment->consignee = $faker->name();
////            $consignment->COD = $faker->randomNumber(4);
//            $consignment->save();
//            $consignment->consCode = "CN-".$consignment->cons_id;
//            $consignment->save();
//
//        }
//
//        for($i=1; $i<=90; $i++) {
//            $consignment = new Consignment;
//            $consignment->consCode = "";
//            $consignment->area_id = $areas[1]->area_id;
//            $consignment->consWeight = 25;
////            $consignment->consVolume = $faker->randomNumber(2);
//            $consignment->consVolume = 20;
//            $consignment->toAddress = $faker->address();
//            $consignment->fromAddress = $faker->address();
//            $consignment->toContact = $faker->phoneNumber();
//            $consignment->fromContact = $faker->phoneNumber();
//            $consignment->consType = "Overnight";
//            $consignment->shipper = $faker->name();
//            $consignment->consignee = $faker->name();
////            $consignment->COD = $faker->randomNumber(4);
//            $consignment->save();
//            $consignment->consCode = "CN-".$consignment->cons_id;
//            $consignment->save();
//
//        }

    }
}
