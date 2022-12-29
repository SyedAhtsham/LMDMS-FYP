<?php

namespace Database\Seeders;

use App\Models\Driver;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Staff;
use Faker\Factory as Faker;

class StaffSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        for($i=1; $i<=5; $i++) {
            $staff = new Staff;
            $staff->staffCode = "";
            $staff->name = $faker->name;
            $staff->email = $faker->email;
            $staff->contact = $faker->phoneNumber;
            $staff->address = $faker->address;
            $staff->cnic = $faker->randomNumber();
            $staff->position = 'Driver';
            $staff->dob = $faker->date;
            $staff->gender = 'Male';
            $staff->save();
            $staff1 = Staff::all();
            $uniqueStaffCode = 'ST-';
            $temp = 1000;
            if (sizeof($staff1) > 0) {
                $lastIndex = $staff1[sizeof($staff1) - 1]['staff_id'];
            } else {
                $lastIndex = 0;
            }
            $staffId = $lastIndex;
            $lastIndex += $temp;

            if ($staff1[sizeof($staff1) - 1]['position'] == 'Driver') {
                $uniqueStaffCode .= 'D' . $lastIndex;
            }elseif($staff1[sizeof($staff1) - 1]['position'] == 'Supervisor'){
                $uniqueStaffCode .= 'S' . $lastIndex;
            }else{
                $uniqueStaffCode .= 'M' . $lastIndex;
            }


            $staff->staffCode = $uniqueStaffCode;

            $staff->save();

            if ($staff1[sizeof($staff1) - 1]['position'] == 'Driver') {
            $driver = new Driver;
            $driver->staff_id = $staffId;
            $driver->licenseNo = $faker->randomNumber(4);

            $driver->yearsExp = $faker->randomNumber(1);
            $driver->canDrive = 'Bike, Hilux';

            $driver->save();
            }

            $user = new User;
            $user->email = $staff1[sizeof($staff1) - 1]['email'];

            $user->password = $faker->password;
            $user->staff_id = $staffId;

            $user->save();

        }


    }
}
