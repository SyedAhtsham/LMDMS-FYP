<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use App\Models\VehicleAssignment;
use App\Models\VehicleType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class VehicleAssignmentController extends Controller
{
    //
    public function view(Request $request){

        $search = $request['search'] ?? "";

//        $vehicleAssignments = VehicleAssignment::with(['getVehicle','getVehicle.getVehicleType', 'getDriver', 'getSupervisor'])->get();
//
//        echo "<pre>";
//        print_r($vehicleAssignments->toArray());
//        die;

        if($search != ""){

            $vehicleAssignments = DB::table('vehicle_assignment')->select('vehicle_assignment.vehicle_id AS vhID','spv.name AS spvName', 'drv.name AS drvName', 'vehicle.vehicleCode AS vhCode', 'vehicle.make AS make', 'vehicle_type.typeName AS tpName', 'vehicle_assignment.dateAssigned AS dtAss')
                ->leftJoin('staff AS drv', 'vehicle_assignment.assignedTo', '=', 'drv.staff_id')
                ->leftJoin('staff AS spv', 'vehicle_assignment.assignedBy', '=', 'spv.staff_id')
                ->leftJoin('vehicle', 'vehicle_assignment.vehicle_id', '=', 'vehicle.vehicle_id')
                ->leftJoin('vehicle_type', 'vehicle.vehicleType_id', '=', 'vehicle_type.vehicleType_id')
                ->where('drv.name','LIKE', "%$search%")->orwhere('spv.name','LIKE', "%$search%")->orwhere('vehicle.vehicleCode','LIKE', "%$search%")->orwhere('vehicle_type.typeName','LIKE', "%$search%")
                ->paginate(20);

        }
        else{
//            $vehicleAssignments = VehicleAssignment::with(['getVehicle','getVehicle.getVehicleType', 'getDriver', 'getSupervisor'])->paginate(20);

            $vehicleAssignments = DB::table('vehicle_assignment')->select('vehicle_assignment.vehicle_id AS vhID', 'spv.name AS spvName', 'drv.name AS drvName', 'vehicle.vehicleCode AS vhCode', 'vehicle.make AS make', 'vehicle_type.typeName AS tpName', 'vehicle_assignment.dateAssigned AS dtAss')
                ->leftJoin('staff AS drv', 'vehicle_assignment.assignedTo', '=', 'drv.staff_id')
                ->leftJoin('staff AS spv', 'vehicle_assignment.assignedBy', '=', 'spv.staff_id')
                ->leftJoin('vehicle', 'vehicle_assignment.vehicle_id', '=', 'vehicle.vehicle_id')
                ->leftJoin('vehicle_type', 'vehicle.vehicleType_id', '=', 'vehicle_type.vehicleType_id')
                ->paginate(20);

        }
//
        $data = compact('vehicleAssignments', 'search');


        return view('frontend.viewVehicleAssignments')->with($data);
    }

}
