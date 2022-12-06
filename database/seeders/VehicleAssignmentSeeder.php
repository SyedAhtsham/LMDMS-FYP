<?php

namespace Database\Seeders;

use App\Models\Driver;
use App\Models\Staff;
use App\Models\Vehicle;
use App\Models\VehicleAssignment;
use Faker\Factory as Faker;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VehicleAssignmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $faker = Faker::create();

        $drivers = DB::table('driver')->select('staff_id')->get();
        $supervisors = DB::table('staff')->select('staff_id')->where('position', 'Supervisor')->get();
        $vehicles = DB::table('vehicle')->select('vehicle_id')->where('assignmentStatus', '=', '0')->get();

        for ($i = 0; $i < sizeof($drivers) && $i < sizeof($vehicles); $i++) {
            $vAss = new VehicleAssignment;
            $vAss->vehicle_id = $vehicles[$i]->vehicle_id;
            $vAss->assignedBy = $supervisors[0]->staff_id;
            $vAss->assignedTo = $drivers[$i]->staff_id;
            $vAss->dateAssigned = $faker->date();
            $vAss->save();
        }
    }
}
