<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\CompVehicle;
use App\Models\ContVehicle;
use App\Models\Driver;
use App\Models\Staff;
use App\Models\User;
use App\Models\Vehicle;
use App\Models\VehicleAssignment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use function Sodium\compare;


class VehicleController extends Controller
{

    public function create()
    {

        $vehicle = Vehicle::with('getCompVehicle')->find(134);
        $vehicle = Vehicle::with(['getContVehicle', 'getCompVehicle', 'getVehicleType'])->find(0);
        $url = url('/frontend/add-vehicle');
        $title = "Add Vehicle";
        $data = compact('url', 'title', 'vehicle');
//        $data = compact('url', 'title');
        return view('frontend.addvehicle')->with($data);
    }


    public function view(Request $request){

        $search = $request['search'] ?? "";

//        $vehicle = Vehicle::with(['getContVehicle', 'getCompVehicle', 'getVehicleType'])->get();
//        echo "<pre>";
//        print_r($vehicle->toArray());
//        die;

        if($search != ""){

            $vehicle = Vehicle::with(['getContVehicle', 'getCompVehicle', 'getVehicleType'])
            ->where('assignStatus','=', "$search")->orwhere('vehicleCode', "LIKE", "%$search%")->orwhere('plateNo', "LIKE", "%$search%")->orwhere('model', "LIKE", "%$search%")->orwhere('condition', "LIKE", "%$search%")->orwhere('status', "LIKE", "%$search%")
                ->orwhere('make', "LIKE", "%$search%")->paginate(20);

        }
        else{
            $search = "";
            $vehicle = Vehicle::with(['getContVehicle', 'getCompVehicle', 'getVehicleType'])->paginate(20);
        }

        $data = compact('vehicle', 'search');


        return view('frontend.viewvehicle')->with($data);
    }



    public function insert(Request $request)
    {



//        if(sizeof(DB::table('users')->where('email', $request['email'])->get()) > 0){
//            echo 'Sorry this email already exists';
//            die;
//        }



        $request->validate(
            [
                'plateNo' => 'required',
                'model' => 'required',
                'make' => 'required',
                'vehicleType' => 'required',
                'status' => 'required',
                'condition' => 'required',
                'ownership' => 'required',
                'price' => 'required',
                'dop' => 'required',

            ]
        );


        //in order to get the last staff_id and create a unique staffCode

        $vehicle = new Vehicle;
        $vehicle->vehicleCode = "";
        $vehicle->plateNo = $request['plateNo'];
        $vehicle->model = $request['model'];
        $vehicle->condition = $request['condition'];
        $vehicle->status = $request['status'];
        $vehicle->make = $request['make'];

        $vehicle->vehicleType_id = $request['vehicleType'];



        $vehicle->save();


        $id = $vehicle->vehicle_id;
        $uniqueVehicleCode = 'VH-';

        if ($request['ownership'] == 'Company Owned') {
            $uniqueVehicleCode .= 'P' .$id;
        } elseif ($request['ownership'] == 'Contractual Vehicle') {
            $uniqueVehicleCode .= 'R' .$id;
        }

        $vehicle->vehicleCode = $uniqueVehicleCode;

        $vehicle->save();


        if ($request['ownership'] == "Company Owned") {
            $compVehicle = new CompVehicle;
            $compVehicle->vehicle_id = $id;
            $compVehicle->price = $request['price'];
            $compVehicle->purchasedDate = $request['dop'];
            $compVehicle->save();
        } elseif ($request['ownership'] == "Contractual Vehicle") {
            $contVehicle = new ContVehicle;
            $contVehicle->vehicle_id = $id;
            $contVehicle->rentPerDay = $request['price'];
            $contVehicle->dateOfContract = $request['dop'];
            $contVehicle->save();
        }



        return redirect('/frontend/view-vehicle')->withSuccessMessage('Successfully added');

    }

    public function delete(Request $request){

        $id = $request->vehicle_delete_id;

        $vehicle = Vehicle::find($id);
        if(!is_null($vehicle)) {

            $vehicleAssignment = VehicleAssignment::find($id);
            if(!is_null($vehicleAssignment)){
                $vehicleAssignment->delete();
            }

            $temp1 = CompVehicle::find($id);
            $temp2 = ContVehicle::find($id);
            if (!is_null($temp1)) {
                $temp1->delete();
            }
            elseif (!is_null($temp2)){
                $temp2->delete();
            }
        $vehicle->delete();
        }


        return redirect('/frontend/view-vehicle')->withSuccessMessage('Successfully deleted');
    }

    public function edit($id){
//        $staff = Staff::find($id);
        $vehicle = Vehicle::with(['getContVehicle', 'getCompVehicle', 'getVehicleType'])->find($id);
        if(is_null($vehicle)) {
            return redirect('/frontend/view-vehicle');
        }else{
            $url = url('/frontend/update-vehicle').'/'.$id;
            $title = "Update Vehicle";
            $data = compact('vehicle', 'url', 'title');
            return view('frontend.addvehicle')->with($data);
        }

    }


    public function update($id, Request $request){

        date_default_timezone_set("Asia/Karachi");

        $line = '';
        $f = fopen("logFile.txt", "r") or die("Unable to open file!");

        $cursor = -1;
        fseek($f, $cursor, SEEK_END);
        $char = fgetc($f);
//Trim trailing newline characters in the file
        while ($char === "
" || $char === "\r") {
            fseek($f, $cursor--, SEEK_END);
            $char = fgetc($f);
        }
//Read until the next line of the file begins or the first newline char
        while ($char !== false && $char !== "
" && $char !== "\r") {
            //Prepend the new character
            $line = $char . $line;
            fseek($f, $cursor--, SEEK_END);
            $char = fgetc($f);
        }

        $line = substr($line, 0, -1);
        $lineNumber = (int) $line;
        fclose($f);

        $f = fopen("logFile.txt", "a") or die("Unable to open file!");

        $request->validate(
            [
                'plateNo' => 'required',
                'model' => 'required',
                'make' => 'required',
                'vehicleType' => 'required',
                'status' => 'required',
                'condition' => 'required',
                'ownership' => 'required',
                'price' => 'required',
                'dop' => 'required',

            ]
        );

        $vehicle = Vehicle::with(['getContVehicle', 'getCompVehicle', 'getVehicleType'])->find($id);
        $previousVehicleCode = $vehicle->vehicleCode;

        $vehicle->vehicleCode = "";
        if(strcmp($vehicle->plateNo, $request['plateNo']) != 0){
            $newLogEntry = " vehicle plateNo varchar(12) " . date_format(date_create(), 'd/m/Y H:i:s') . " " . $vehicle->plateNo . " \n" . ++$lineNumber;
            fwrite($f, $newLogEntry);
        }
        $vehicle->plateNo = $request['plateNo'];



        $vehicle->model = $request['model'];
        $vehicle->condition = $request['condition'];
        $vehicle->status = $request['status'];
        $vehicle->make = $request['make'];

        $vehicle->vehicleType_id = $request['vehicleType'];

        $uniqueVehicleCode = 'VH-';

        if ($request['ownership'] == 'Company Owned') {
            $uniqueVehicleCode .= 'P' .$id;
        } elseif ($request['ownership'] == 'Contractual Vehicle') {
            $uniqueVehicleCode .= 'R' .$id;
        }

        if(strcmp($uniqueVehicleCode, $previousVehicleCode) != 0) {
            $newLogEntry = " vehicle vehicleCode varchar(10) " . date_format(date_create(), 'd/m/Y H:i:s') . " " . $previousVehicleCode . " \n" .++$lineNumber;
            fwrite($f, $newLogEntry);

        }

        $vehicle->vehicleCode = $uniqueVehicleCode;

        $vehicle->save();


        if ($request['ownership'] == "Company Owned" && !isset($vehicle->getCompVehicle)) {
            $compVehicle = new CompVehicle;
            $compVehicle->vehicle_id = $id;
            $compVehicle->price = $request['price'];
            $compVehicle->purchasedDate = $request['dop'];
            $compVehicle->save();
            $contVehicle = ContVehicle::find($id);
            $contVehicle->delete();
        }elseif($request['ownership'] == "Company Owned") {
        $compVehicle = CompVehicle::find($id);
            $compVehicle->price = $request['price'];
            $compVehicle->purchasedDate = $request['dop'];
            $compVehicle->save();
        }elseif($request['ownership'] == "Contractual Vehicle" && !isset($vehicle->getContVehicle)) {
            $contVehicle = new ContVehicle;
            $contVehicle->vehicle_id = $id;
            $contVehicle->rentPerDay = $request['price'];
            $contVehicle->dateOfContract = $request['dop'];
            $contVehicle->save();
            $compVehicle = CompVehicle::find($id);
            $compVehicle->delete();
        }elseif($request['ownership'] == "Contractual Vehicle") {
            $contVehicle = ContVehicle::find($id);
            $contVehicle->rentPerDay = $request['price'];
            $contVehicle->dateOfContract = $request['dop'];
            $contVehicle->save();
        }
        fclose($f);
        return redirect('/frontend/view-vehicle')->withSuccessMessage('Successfully updated');

    }


    public function assignDriver($vehicleType): \Illuminate\Http\JsonResponse
    {

        $drivers = DB::table('staff')->select('staff.name AS stName', 'driver.canDrive AS canDrive')
            ->join('driver', 'staff.staff_id', '=', 'driver.staff_id')->where('canDrive', 'LIKE', "%$vehicleType%")
            ->get();
        return response()->json([
            'status' => 200,
            'drivers' => $drivers,
        ]);
    }

    public function addVehicleAssignment($id){

    }

}
