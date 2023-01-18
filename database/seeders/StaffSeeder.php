<?php

namespace Database\Seeders;

use App\Models\Driver;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Staff;
//use Faker\Factory as Faker;

class StaffSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        $faker = Faker::create();

        for($i=1; $i<=1; $i++) {
            $staff = new Staff;

            $staff->name = "Ahtsham";
            $staff->email = "syedahtshamqau@gmail.com";
            $staff->contact = "0315-5726162";
            $staff->address = "Prince Road, North Banigala Islamabad";
            $staff->cnic = "61101-6869830-5";
            $staff->position = 'Manager';
            $staff->dob = null;
            $staff->gender = 'Male';
            $staff->staffCode = 'STM-4213';

//            $staff->save();
//            $staff1 = Staff::all();
//            $uniqueStaffCode = 'ST';
//            $temp = 1000;
//            if (sizeof($staff1) > 0) {
//                $lastIndex = $staff1[sizeof($staff1) - 1]['staff_id'];
//            } else {
//                $lastIndex = 0;
//            }
//
//            if ($staff1[sizeof($staff1) - 1]['position'] == 'Driver') {
//                $uniqueStaffCode .= 'D-' . $lastIndex;
//            }elseif($staff1[sizeof($staff1) - 1]['position'] == 'Supervisor'){
//                $uniqueStaffCode .= 'S-' . $lastIndex;
//            }else{
//                $uniqueStaffCode .= 'M-' . $lastIndex;
//            }




//            $staff->save();

//            if ($staff1[sizeof($staff1) - 1]['position'] == 'Driver') {
//            $driver = new Driver;
//            $driver->staff_id = $staffId;
//            $driver->licenseNo = $faker->randomNumber(4);
//
//            $driver->yearsExp = $faker->randomNumber(1);
//            $driver->canDrive = 'Hilux, Bike, Carry';
//
//            $driver->save();
//            }

            $staff->save();
            $user = new User;
            $user->email = "m@gmail.com";

            $user->password = "1234";
            $user->staff_id = $staff->staff_id;

            $user->save();

        }


    }
}
