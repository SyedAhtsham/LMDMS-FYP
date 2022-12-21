<?php

namespace Database\Seeders;

use App\Models\Consignment;
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
        $faker = Faker::create();

//        $consignment = Consignment::all();

//        foreach ($consignment as $cons) {
//            $cons->shipper = $faker->name();
//            $cons->consignee = $faker->name();
//            $cons->save();
//        }


        for($i=1; $i<=6; $i++) {
            $consignment = new Consignment;
            $consignment->consCode = "";
            $consignment->area_id = 1;
            $consignment->consWeight = $faker->randomNumber(2);
            $consignment->consVolume = $faker->randomNumber(2);
            $consignment->toAddress = $faker->address();
            $consignment->fromAddress = $faker->address();
            $consignment->toContact = $faker->phoneNumber();
            $consignment->fromContact = $faker->phoneNumber();
            $consignment->consType = "Overnight";
            $consignment->shipper = $faker->name();
            $consignment->consignee = $faker->name();
//            $consignment->COD = $faker->randomNumber(4);
            $consignment->save();
            $consignment->consCode = "CN-".$consignment->cons_id;
            $consignment->save();

        }
    }
}
