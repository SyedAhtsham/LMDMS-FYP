<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Area;
use App\Models\CompVehicle;
use App\Models\Consignment;
use App\Models\ContVehicle;
use App\Models\DeliverySheet;
use App\Models\Staff;
use App\Models\Vehicle;
use App\Models\VehicleAssignment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Nette\Utils\ArrayList;
use function Sodium\add;

class DeliverySheetController extends Controller
{


    public function create()
    {
        $area = Area::all();
        $url = url('/frontend/dsheet');
        $title = "Delivery Sheet";
        $data = compact('url', 'title', 'area');
        return view('frontend.createDSheet')->with($data);
    }

    public function generate(Request $request)
    {
        $area = $request['area'];

        $allAreas = Area::all();

$isGenerated = false;
//        foreach ($allAreas as $area) {
//            //Returned consignments should be added to a new devliery sheet
//
//            $consBike = DB::table('consignment')->select('cons_id', 'area_id', 'consWeight', 'consVolume', 'created_at')->orderBy('created_at')->where('area_id', $area->area_id)->where('deliverySheet_id', '=', null)->where('consWeight', '<=', 2)->get();
//            //this query is sorting on the basis of the volume and then on the basis of the created_at because, we want to add consignments to the ddlivery sheet first the earlier one and the one with lower volume to the vehile with a lower volume capacity and then
//            $consVehicle = DB::table('consignment')->select('cons_id', 'area_id', 'consWeight', 'consVolume', 'created_at')->orderBy('consVolume')->orderBy('created_at')->where('area_id', $area->area_id)->where('deliverySheet_id', '=', null)->where('consWeight', '>', 2)->get();
//            //$consignments = DB::table('consignment')->select('cons_id', 'area_id')->get();
//
//            echo "<pre>";
//            echo "FOR AREA ID: ".$area->area_id."<br>";
//            print_r($consVehicle->toArray());
//
//            echo "</pre>";
//
//            echo "<br>";
//            echo "<br>";
//            echo "<br>";
//
//        }


        $bikes = DB::table('vehicle')->select('vehicle.vehicle_id', 'vehicle_assignment.assignedTo')->where('status', 'Idle')->where('dsAssigned', '=', '0')
            ->leftJoin('vehicle_assignment', function($join){
                $join->on('vehicle.vehicle_id', '=', 'vehicle_assignment.vehicle_id')
                ;
            })
                ->join('vehicle_type', function($join){
                $join->on('vehicle.vehicleType_id', '=', 'vehicle_type.vehicleType_id')
                    ->where('typeName', '=', 'Bike');
            })->get();



//        $vehicles = DB::table('vehicle')->select('vehicle.vehicle_id', 'vehicle_type.volumeCap','vehicle_type.weightCap')->where('status', 'Idle')
//            ->join('vehicle_type', function($join){
//                $join->on('vehicle.vehicleType_id', '=', 'vehicle_type.vehicleType_id')
//                ->where('typeName', '!=', 'Bike');
//
//            })->orderBy('vehicle_type.volumeCap')->get();
//

        //Query to fetch the assignedTo from the Vehicle assignment table along with the other vehicle's details
        $vehicles = DB::table('vehicle')->select('vehicle.vehicle_id', 'vehicle_type.volumeCap','vehicle_type.weightCap', 'vehicle_assignment.assignedTo')->where('status', 'Idle')->where('dsAssigned', '=', '0')
            ->leftJoin('vehicle_assignment', function($join){
                $join->on('vehicle.vehicle_id', '=', 'vehicle_assignment.vehicle_id')
                ;

            })->orderBy('vehicle_type.volumeCap')
            ->join('vehicle_type', function($join) {
                $join->on('vehicle.vehicleType_id', '=', 'vehicle_type.vehicleType_id')->where('typeName', '!=', 'Bike');

            })
            ->get();

//        foreach ($vehicles as $vehicle){
//            print_r($vehicle);
//echo "<br>";
//            echo "<br>";
//        }
//
//        die;

        $vehiclesArr = $vehicles->toArray();
        $bikesArr = $bikes->toArray();
//        echo "<pre>";
//        print_r($vehicles);
//        die;

        $j = -1;
        $b = -1;
        foreach ($allAreas as $area) {
            //Returned consignments should be added to a new devliery sheet

            $consBike = DB::table('consignment')->select('cons_id', 'area_id', 'consWeight', 'consVolume', 'created_at')->orderBy('created_at')->where('area_id', $area->area_id)->where('deliverySheet_id', '=', null)->where('consWeight', '<=', 2)->get();
            //this query is sorting on the basis of the volume and then on the basis of the created_at because, we want to add consignments to the ddlivery sheet first the earlier one and the one with lower volume to the vehile with a lower volume capacity and then
            $consVehicle = DB::table('consignment')->select('cons_id', 'area_id', 'consWeight', 'consVolume', 'created_at')->orderBy('consVolume')->orderBy('created_at')->where('area_id', $area->area_id)->where('deliverySheet_id', '=', null)->where('consWeight', '>', 2)->get();
            //$consignments = DB::table('consignment')->select('cons_id', 'area_id')->get();

//            echo "<pre>";
//            echo "FOR AREA ID: ".$area->area_id."<br>";
//            print_r($consVehicle->toArray());

//        define("MAXBIKEWEIGHT", );

            $lenBikeCons = count($consBike);
            $lenVehicleCons = count($consVehicle);

            $consVehicleArr = $consVehicle->toArray();
            $consBikeArr = $consBike->toArray();



//        if($lenVehicleCons > 0){
//
//            $k = 0;
//            $i = 0;
//            $flag = true;
//
//
//            foreach ($consVehicle as $cons){
//
//
//            if($flag){
//                    $deliverySheet = new DeliverySheet;
//
//                    $deliverySheet->deliverySheetCode = "DS-";
//
//                    $cons->deliverySheet_id = $deliverySheet->deliverySheet_id;
//
//                    $k++;
//                    $flag = false;
//                }else{
//                    $cons->deliverySheet_id = $deliverySheet->deliverySheet_id;
//                    $k++;
//                }
//                if($k == MAXBIKE || $i == ($lenVehicleCons-1)){
//
//                    $deliverySheet->noOfCons = $k;
//                    $deliverySheet->fuelAssigned = 2.5;
//                    $deliverySheet->area_id = 2;
//                    $deliverySheet->driver_id = 498;
//                    $deliverySheet->vehicle_id = 88;
//
//                    $deliverySheet->save();
//                    $deliverySheet->deliverySheetCode = $deliverySheet->deliverySheetCode."".$deliverySheet->deliverySheet_id;
//                    $deliverySheet->save();
//                    $flag = true;
//                    $k=0;
//                }
//                $i++;
//
//            }


            if($lenBikeCons > 0){

                $m = 0;
                $n = 0;



                while($n < $lenBikeCons) {

                    if($m == 0){
                        $deliverySheet = new DeliverySheet;
                        $b++;

                        $deliverySheet->deliverySheetCode = "DSB-";

                        $isGenerated = true;
                        $deliverySheet->area_id = $area->area_id;
                        $deliverySheet->driver_id = $bikesArr[$b]->assignedTo ?? null;
                        $deliverySheet->vehicle_id = $bikesArr[$b]->vehicle_id ?? null; // if null, then display a message about the need of hiring of vehicles of type

                        $deliverySheet->save();

                    }

                    if($m < 40){

                        $tempCons = Consignment::find($consBikeArr[$n]->cons_id);

                        $tempCons->deliverySheet_id = $deliverySheet->deliverySheet_id;

                        $tempCons->save();


                        $m++;

                    }else{

                        $deliverySheet->noOfCons = $m;

                        $deliverySheet->fuelAssigned = ceil((70/($bikesArr[$b]->mileage ?? 30)) + $area->extraFuel);

                        $deliverySheet->save();
                        $deliverySheet->deliverySheetCode = $deliverySheet->deliverySheetCode . "" . $deliverySheet->deliverySheet_id;
                        $deliverySheet->save();




                        // Update the status of a vehicle that the delivery sheet is assgned to this vehicle
                        $tempVehicle = Vehicle::find($bikesArr[$b]->vehicle_id ?? null) ?? null;
                        if($tempVehicle != null) {
                            echo "<pre>";
                            print($tempVehicle);
                            $tempVehicle->dsAssigned = 1;
                            $tempVehicle->save();
                        }

                        $m = 0;
                    }

                    if((($n == $lenBikeCons-1) || ($lenBikeCons == 1)) && ($m < 40)){

//                        echo "<pre>";
//                        echo $n;
//                        echo "<br>";
//                        echo $m;
//                        echo "<br>";
//                        print_r($deliverySheet);
//                        echo "</pre>";
//                        echo "<br>";echo "<br>";echo "<br>";

                        $tempCons = Consignment::find($consBikeArr[$n]->cons_id);

                        $tempCons->deliverySheet_id = $deliverySheet->deliverySheet_id;

                        $tempCons->save();

                        $n++;

                        $deliverySheet->noOfCons = $m;

                        $deliverySheet->fuelAssigned = ceil((70/($bikesArr[$b]->mileage ?? 30)) + $area->extraFuel);

                        $deliverySheet->save();
                        $deliverySheet->deliverySheetCode = $deliverySheet->deliverySheetCode . "" . $deliverySheet->deliverySheet_id;
                        $deliverySheet->save();


                        // Update the status of a vehicle that the delivery sheet is assgned to this vehicle
                        $tempVehicle = Vehicle::find($bikesArr[$b]->vehicle_id ?? null) ?? null;
                        if($tempVehicle != null) {
                            $tempVehicle->dsAssigned = 1;
                            $tempVehicle->save();
                        }

                        $m = 0;
                    }
                    else{
                        $n++;
                    }

                }
            }


            if ($lenVehicleCons > 0) {

                $k = 0;
                $i = 0;
                     //to iterate through the vehicles
                $flag = true;

                $currentWeight = 0;
                $currentVolume = 0;

                while($i < $lenVehicleCons) {

                    //this means there is no vehicle available
//                    if($j == count($vehiclesArr)-1){
//
//                    }

                    if ($flag) {

                        $deliverySheet = new DeliverySheet;
                        $deliverySheet->deliverySheetCode = "DSV-";

                        $isGenerated = true;
                        $j++;

                        $deliverySheet->area_id = $area->area_id;
                        $deliverySheet->driver_id = $vehiclesArr[$j]->assignedTo ?? null;
                        $deliverySheet->vehicle_id = $vehiclesArr[$j]->vehicle_id ?? null; // if null, then display a message about the need of hiring of vehicles of type

                        $deliverySheet->save();
                        $flag = false;
                    }


                        $tempVolume = $currentVolume + $consVehicleArr[$i]->consVolume;
                        $tempWeight = $currentWeight + $consVehicleArr[$i]->consWeight;

//                        echo $consVehicleArr[$i]->cons_id;
//                    echo "<br>";
//                        echo $tempVolume;
//                        echo "<br>";
//                        echo $tempWeight;
//
//                        die;
                        $volumeLimit = ($vehiclesArr[$j]->volumeCap ?? 500) - 200;
                        $weightLimit = ($vehiclesArr[$j]->weightCap ?? 800) - 100;

//                        echo "<br>";
//                        echo $vehiclesArr[$j]->volumeCap;
//                    echo $vehiclesArr[$j]->weightCap;
//                        die;

//                    echo "<br>";
//echo $volumeLimit;
//
//                    echo "<br>";
//echo $tempVolume;
//                    echo "<br>";
//                    echo $weightLimit;
//                    echo "<br>";
//                 echo $tempWeight;

                    if ($tempVolume <= $volumeLimit && $tempWeight <= $weightLimit) {


                        $tempCons = Consignment::find($consVehicleArr[$i]->cons_id);

                        $tempCons->deliverySheet_id = $deliverySheet->deliverySheet_id;

                        $tempCons->save();
//                        echo "<br>";
//                        echo $tempCons->deliverySheet_id;
////                        echo $consVehicleArr[$i]->cons_id;
//
//                        die;

                        $currentWeight = $tempWeight;
                        $currentVolume = $tempVolume;

                        $k++;
                    }
                    else{


                        $deliverySheet->noOfCons = $k;

                        $deliverySheet->fuelAssigned = ceil((70/($vehiclesArr[$j]->mileage ?? 15)) + $area->extraFuel);

                        $deliverySheet->save();
                        $deliverySheet->deliverySheetCode = $deliverySheet->deliverySheetCode . "" . $deliverySheet->deliverySheet_id;
                        $deliverySheet->save();

                        $currentWeight = 0;
                        $currentVolume = 0;


                        // Update the status of a vehicle that the delivery sheet is assgned to this vehicle
                        $tempVehicle = Vehicle::find($vehiclesArr[$j]->vehicle_id ?? null) ?? null;
                        if($tempVehicle != null) {
                            $tempVehicle->dsAssigned = 1;
                            $tempVehicle->save();
                        }

                        $flag = true;
                        $k = 0;

                    }

                    if($i == $lenVehicleCons-1){

                        $deliverySheet->noOfCons = $k;

                        $deliverySheet->fuelAssigned = ceil((70/($vehiclesArr[$j]->mileage ?? 15)) + $area->extraFuel);

                        $deliverySheet->save();
                        $deliverySheet->deliverySheetCode = $deliverySheet->deliverySheetCode . "" . $deliverySheet->deliverySheet_id;
                        $deliverySheet->save();

                        $currentWeight = 0;
                        $currentVolume = 0;


                        // Update the status of a vehicle that the delivery sheet is assgned to this vehicle
                        $tempVehicle = Vehicle::find($vehiclesArr[$j]->vehicle_id ?? null) ?? null;
                        if($tempVehicle != null) {
                            $tempVehicle->dsAssigned = 1;
                            $tempVehicle->save();
                        }
                        $i++;
                        $flag = true;
                        $k = 0;
                    }else{
                        $i++;
                    }



                }


            }
        }


if($isGenerated) {
    return redirect('/frontend/view-deliverysheets/')->withSuccessMessage('Successfully Generated');
}
else{
    return redirect('/frontend/view-deliverysheets/')->withErrorMessage('Failed to Generate');
}

    }

    public function view(Request $request)
    {

        //This will disable the Generate Delivery Sheets button if false
        $newConsignments = true;
        $cons = DB::table('consignment')->select('cons_id')->where('deliverySheet_id', '=', null)->get();
        if(count($cons) == 0){
            $newConsignments = false;
        }


        $search = $request['search'] ?? "";

//        $vehicle = Vehicle::with(['getContVehicle', 'getCompVehicle', 'getVehicleType'])->get();
//        echo "<pre>";
//        print_r($vehicle->toArray());
//        die;

        if ($search != "") {

            $deliverySheets = DB::table('delivery_sheet')->select('delivery_sheet.*', 'spv.name AS spvName', 'drv.name AS drvName', 'vehicle.vehicleCode AS vhCode', 'vehicle.make AS make', 'vehicle_type.typeName AS tpName', 'area.areaCode AS arCD', 'area.areaName AS arNM', 'area.city AS arCT')
                ->leftJoin('staff AS drv', 'delivery_sheet.driver_id', '=', 'drv.staff_id')
                ->leftJoin('staff AS spv', 'delivery_sheet.supervisor_id', '=', 'spv.staff_id')
                ->leftJoin('vehicle', 'delivery_sheet.vehicle_id', '=', 'vehicle.vehicle_id')
                ->leftJoin('vehicle_type', 'vehicle.vehicleType_id', '=', 'vehicle_type.vehicleType_id')
                ->join('area', 'delivery_sheet.area_id', '=', 'area.area_id')
                ->where('delivery_sheet.status', '=', "$search")->orwhere('drv.name', 'LIKE', "%$search%")->orwhere('spv.name', 'LIKE', "%$search%")->orwhere('vehicle.vehicleCode', 'LIKE', "%$search%")->orwhere('vehicle_type.typeName', 'LIKE', "%$search%")->orwhere('area.areaName', 'LIKE', "%$search%")->orwhere('area.areaCode', 'LIKE', "%$search%")
                ->orderBy('delivery_sheet.deliverySheet_id')->paginate(20);


        } else {
            $search = "";
            $deliverySheets = DB::table('delivery_sheet')->select('delivery_sheet.*', 'spv.name AS spvName', 'drv.name AS drvName', 'vehicle.vehicleCode AS vhCode', 'vehicle.make AS make', 'vehicle_type.typeName AS tpName', 'area.areaCode AS arCD', 'area.areaName AS arNM', 'area.city AS arCT')
                ->leftJoin('staff AS drv', 'delivery_sheet.driver_id', '=', 'drv.staff_id')
                ->leftJoin('staff AS spv', 'delivery_sheet.supervisor_id', '=', 'spv.staff_id')
                ->leftJoin('vehicle', 'delivery_sheet.vehicle_id', '=', 'vehicle.vehicle_id')
                ->leftJoin('vehicle_type', 'vehicle.vehicleType_id', '=', 'vehicle_type.vehicleType_id')
                ->join('area', 'delivery_sheet.area_id', '=', 'area.area_id')
                ->orderBy('delivery_sheet.deliverySheet_id')->paginate(20);

        }

        $data = compact('deliverySheets', 'search', 'newConsignments');


        return view('frontend.viewdeliverysheets')->with($data);
    }

    public function viewSingle($id, Request $request)
    {

        $search = $request['search'] ?? "";

        $dSheet = DeliverySheet::find($id);
        if ($dSheet == null) {
            return $this->view($request);
        }

        $deliverySheets = DB::table('delivery_sheet')->select('delivery_sheet.*', 'spv.name AS spvName', 'drv.name AS drvName', 'vehicle.vehicleCode AS vhCode', 'vehicle.make AS make', 'vehicle_type.typeName AS tpName', 'area.areaCode AS arCD', 'area.areaName AS arNM', 'area.city AS arCT')
            ->join('staff AS drv', 'delivery_sheet.driver_id', '=', 'drv.staff_id')
            ->leftJoin('staff AS spv', 'delivery_sheet.supervisor_id', '=', 'spv.staff_id')
            ->join('vehicle', 'delivery_sheet.vehicle_id', '=', 'vehicle.vehicle_id')
            ->join('vehicle_type', 'vehicle.vehicleType_id', '=', 'vehicle_type.vehicleType_id')
            ->join('area', 'delivery_sheet.area_id', '=', 'area.area_id')
            ->where('delivery_sheet.deliverySheet_id', '=', "$id")->get();

//        echo "<pre>";
//        print_r($deliverySheet->toArray());


        if ($search != "") {


            $consignments = Consignment::select('consignment.*')
                ->where('deliverySheet_id', '=', "$id")
                ->where(function ($query) use ($search) {
                    $query->where('consCode', 'LIKE', "%$search%")->orwhere('consWeight', 'LIKE', "%$search%")->orwhere('consVolume', 'LIKE', "%$search%")->orwhere('toAddress', 'LIKE', "%$search%")->orwhere('fromAddress', 'LIKE', "%$search%")
                        ->orwhere('consType', 'LIKE', "%$search%");
                })
                ->paginate(20);
            //->orwhere('canDrive','LIKE', "%$search%")

        } else {
            $consignments = Consignment::select('consignment.*')
                ->where('deliverySheet_id', '=', "$id")->paginate(20);
        }
//        echo "<pre>";
//        print_r($consignments->toArray());

        $deliverySheet = $deliverySheets[0];

        $data = compact('deliverySheet', 'consignments', 'search');


        return view('frontend.viewdeliverysheet')->with($data);


    }


    public function removeConsignment(Request $request)
    {

        $id = $request->cons_id;
        $consignment = Consignment::find($id);
        if (!is_null($consignment)) {
            $deliverySheet_id = $consignment->deliverySheet_id;
            $consignment->deliverySheet_id = null;
            $consignment->save();

        }
        return redirect('/frontend/view-deliverysheet/'.$deliverySheet_id)->withSuccessMessage('Successfully removed');
    }


    public function checkoutDeliverySheet(Request $request){

        $id = $request->deliverySheet_id;
        $deliverySheet = DeliverySheet::find($id);

        if (!is_null($deliverySheet)) {
            if ($deliverySheet->status == 'checked-out') {
                $deliverySheet->status = 'un-checked-out';
                $deliverySheet->save();
                return redirect('/frontend/view-deliverysheet/'.$id)->withSuccessMessage('Successfully Un-Checked-out');
            } else {
                $deliverySheet->status = 'checked-out';
                $deliverySheet->save();
                return redirect('/frontend/view-deliverysheet/'.$id)->withSuccessMessage('Successfully Checked-out');
            }
        }

    }


}


