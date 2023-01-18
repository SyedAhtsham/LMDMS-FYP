<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use App\Models\Area;
use App\Models\CompVehicle;
use App\Models\Consignment;
use App\Models\ContVehicle;
use App\Models\DeliverySheet;
use App\Models\Driver;
use App\Models\Staff;
use App\Models\Vehicle;
use App\Models\VehicleAssignment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use MongoDB\Driver\Session as ses;
use mysql_xdevapi\Table;
use Nette\Utils\ArrayList;
use function Sodium\add;

class DeliverySheetController extends Controller
{
    private $words;
    private $search;

    function __construct()
    {
        $lines = file('englishwords/nouns.txt');
        $count = 0;
        $this->words = array();
        foreach($lines as $line) {
            $count += 1;
            array_push($this->words,trim($line, " \t\n\r\0\x0B"));
        }

        parent::__construct(); //This constructor is called and now the sweet alert is working fine
    }

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


        $bikes = DB::table('vehicle')->select('vehicle.vehicle_id', 'vehicle_assignment.assignedTo')->where('deleted_at','=', null)->where('status', 'Idle')->where('dsAssigned', '=', '0')
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
        $vehicles = DB::table('vehicle')->select('vehicle.vehicle_id', 'vehicle_type.volumeCap','vehicle_type.weightCap', 'vehicle_assignment.assignedTo')->where('deleted_at','=', null)->where('status', 'Idle')->where('dsAssigned', '=', '0')
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

                $flag = true;

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
                        $deliverySheet->deliverySheetCode = $deliverySheet->deliverySheetCode . $deliverySheet->deliverySheet_id;
                        $deliverySheet->save();
    if(isset($deliverySheet->vehicle_id)){
        $bike = Vehicle::find($deliverySheet->vehicle_id);
        $bike->dsAssigned = 1;
        $bike->save();
    }

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
//                        $deliverySheet->deliverySheetCode = $deliverySheet->deliverySheetCode . "" . $deliverySheet->deliverySheet_id;
//                        $deliverySheet->save();




                        // Update the status of a vehicle that the delivery sheet is assgned to this vehicle
                        $tempVehicle = Vehicle::find($bikesArr[$b]->vehicle_id ?? null) ?? null;
                        if($tempVehicle != null) {
//                            echo "<pre>";
//                            print($tempVehicle);
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
//                        $deliverySheet->deliverySheetCode = $deliverySheet->deliverySheetCode . "" . $deliverySheet->deliverySheet_id;
//                        $deliverySheet->save();


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
                        if($m == 0){
                            $n--;
                        }

//if($flag) {
//    $n++;
//    $flag = true;
//}
//
//                        if(((($n-1) % 40)==0) && ($n!=0)){
//                            $n--;
//                            $flag = false;
//                        }
//                        else if(!$flag) {
//                            $n++;
//                            $flag = true;
//
//                        }


                    }

                }

                if($lenBikeCons <= 40){
                    if(isset($deliverySheet->deliverySheet_id)) {
                        $consCount = DB::table('consignment')->where('deliverySheet_id', $deliverySheet->deliverySheet_id)->count();
                        $deliverySheet->noOfCons = $consCount;
                        $deliverySheet->fuelAssigned = ceil((70/($bikesArr[0]->mileage ?? 30)) + $area->extraFuel);
                        $deliverySheet->save();
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

                        if(isset($deliverySheet->vehicle_id)){
                            $vehicle = Vehicle::find($deliverySheet->vehicle_id);
                            $vehicle->dsAssigned = 1;
                            $vehicle->save();
                        }

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
                        $volumeLimit = ($vehiclesArr[$j]->volumeCap ?? 500) - 0;
                        $weightLimit = ($vehiclesArr[$j]->weightCap ?? 800) - 0;

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

                        if($k==0){
                            $i--;
                        }
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

$this->search = lcfirst($this->search);

        $search = $request['search'] ?? "";

        $this->search = $request['search'] ?? "";
        $actual = $this->search;
        $statusView = "";
        $initialvalue = "";
        $status = "";

        if($this->search == "in:checked-out " || $this->search == "in:un-checked-out " ){

            $status = trim( explode(":", $this->search)[1]);
            $statusView = ucfirst($status);


            $status = ucfirst($status);
            $search = $statusView;
        }



//    $vehicleObject = new VehicleController();
//    foreach ($words as $word){
//        echo $word;
//        echo "<br>";
//    }
        $arr = [];
        if($request['search']) {
            $arr = explode(" ", $request['search']);
        }


        if($this->search == "checked-out" || $this->search == "un-checked-out"){
            $statusView = $this->search;

        }

        if(count($arr)>1){
            if($arr[0] == "in:checked-out" || $arr[0] == "in:un-checked-out"){
                $status = explode(":", $arr[0])[1];
                $statusView = ucfirst($status);

                for($i = 1; $i<count($arr); $i++){
                    $initialvalue = $initialvalue .' '. $arr[$i];
                }


            }
            else{
                $initialvalue = $this->search;
            }
        }else{
            $initialvalue = $this->search;
        }


        $this->search = $initialvalue;



        if($this->search != "") {

// input misspelled word
            $input = $this->search;


// no shortest distance found, yet
            $shortest = -1;

            $lev = 0;
            $resultantLev = 0;
// loop through words to find the closest
            foreach ($this->words as $word) {


                // calculate the distance between the input word,
                // and the current word
                $lev = levenshtein($input, $word);

                // check for an exact match
                if ($lev == 0) {

                    // closest word is this one (exact match)
                    $closest = $word;
                    $shortest = 0;

                    // break out of the loop; we've found an exact match
                    break;
                }

                // if this distance is less than the next found shortest
                // distance, OR if a next shortest word has not yet been found
                if ($lev <= $shortest || $shortest < 0) {
                    // set the closest match, and shortest distance
                    $closest = $word;
                    $shortest = $lev;
                }
            }


//        $vehicle = Vehicle::with(['getContVehicle', 'getCompVehicle', 'getVehicleType'])->get();
//        echo "<pre>";
//        print_r($vehicle->toArray());
//        die;

            if ($closest != "" && strlen($closest) != 1 && $shortest <= 3)
            {
                $this->search = $closest;
//        echo "<div style='margin-left: 400px;'>".$shortest."'</div>";
            }
        }


        $search =  $this->search;



        $search = trim($search, " \t\n\r\0\x0B");
//type of the vehicle should also be included in the query


//        $vehicle = Vehicle::with(['getContVehicle', 'getCompVehicle', 'getVehicleType'])->get();
//        echo "<pre>";
//        print_r($vehicle->toArray());
//        die;

        if($status != ''){
            if ($search != "") {


                $deliverySheets = DB::table('delivery_sheet')->select('delivery_sheet.*', 'spv.name AS spvName', 'drv.staff_id AS stID', 'drv.name AS drvName', 'vehicle.vehicle_id AS vhID', 'vehicle.vehicleCode AS vhCode', 'vehicle.make AS make', 'vehicle_type.typeName AS tpName', 'area.areaCode AS arCD', 'area.areaName AS arNM', 'area.city AS arCT')
                    ->leftJoin('staff AS drv', 'delivery_sheet.driver_id', '=', 'drv.staff_id')
                    ->leftJoin('staff AS spv', 'delivery_sheet.supervisor_id', '=', 'spv.staff_id')
                    ->leftJoin('vehicle', 'delivery_sheet.vehicle_id', '=', 'vehicle.vehicle_id')
                    ->leftJoin('vehicle_type', 'vehicle.vehicleType_id', '=', 'vehicle_type.vehicleType_id')
                    ->join('area', 'delivery_sheet.area_id', '=', 'area.area_id')
                    ->where('delivery_sheet.status', '=', "$status")
                    ->where(function ($query) use($search) {
                        $query->where('delivery_sheet.deliverySheetCode', 'LIKE', "%$search%")->orwhere('drv.name', 'LIKE', "%$search%")->orwhere('spv.name', 'LIKE', "%$search%")->orwhere('vehicle.vehicleCode', 'LIKE', "%$search%")->orwhere('vehicle_type.typeName', 'LIKE', "%$search%")->orwhere('area.areaName', 'LIKE', "%$search%")->orwhere('area.areaCode', 'LIKE', "%$search%");
                    })
                    ->orderByDesc('delivery_sheet.created_at')->paginate(20);


            } else {
                $search = "";
                $deliverySheets = DB::table('delivery_sheet')->select('delivery_sheet.*', 'spv.name AS spvName', 'drv.staff_id AS stID', 'drv.name AS drvName', 'vehicle.vehicle_id AS vhID', 'vehicle.vehicleCode AS vhCode', 'vehicle.make AS make', 'vehicle_type.typeName AS tpName', 'area.areaCode AS arCD', 'area.areaName AS arNM', 'area.city AS arCT')->where('delivery_sheet.status', '=', "$status")
                    ->leftJoin('staff AS drv', 'delivery_sheet.driver_id', '=', 'drv.staff_id')
                    ->leftJoin('staff AS spv', 'delivery_sheet.supervisor_id', '=', 'spv.staff_id')
                    ->leftJoin('vehicle', 'delivery_sheet.vehicle_id', '=', 'vehicle.vehicle_id')
                    ->leftJoin('vehicle_type', 'vehicle.vehicleType_id', '=', 'vehicle_type.vehicleType_id')
                    ->join('area', 'delivery_sheet.area_id', '=', 'area.area_id')
                    ->orderByDesc('delivery_sheet.created_at')->paginate(20);

            }

        }else {
            if ($search != "") {


                $deliverySheets = DB::table('delivery_sheet')->select('delivery_sheet.*', 'spv.name AS spvName', 'drv.staff_id AS stID', 'drv.name AS drvName', 'vehicle.vehicle_id AS vhID', 'vehicle.vehicleCode AS vhCode', 'vehicle.make AS make', 'vehicle_type.typeName AS tpName', 'area.areaCode AS arCD', 'area.areaName AS arNM', 'area.city AS arCT')
                    ->leftJoin('staff AS drv', 'delivery_sheet.driver_id', '=', 'drv.staff_id')
                    ->leftJoin('staff AS spv', 'delivery_sheet.supervisor_id', '=', 'spv.staff_id')
                    ->leftJoin('vehicle', 'delivery_sheet.vehicle_id', '=', 'vehicle.vehicle_id')
                    ->leftJoin('vehicle_type', 'vehicle.vehicleType_id', '=', 'vehicle_type.vehicleType_id')
                    ->join('area', 'delivery_sheet.area_id', '=', 'area.area_id')

                    ->where(function ($query) use($search) {
                        $query->where('delivery_sheet.status', '=', "$search")->orwhere('delivery_sheet.deliverySheetCode', 'LIKE', "%$search%")->orwhere('drv.name', 'LIKE', "%$search%")->orwhere('spv.name', 'LIKE', "%$search%")->orwhere('vehicle.vehicleCode', 'LIKE', "%$search%")->orwhere('vehicle_type.typeName', 'LIKE', "%$search%")->orwhere('area.areaName', 'LIKE', "%$search%")->orwhere('area.areaCode', 'LIKE', "%$search%");
                    })
                    ->orderByDesc('delivery_sheet.created_at')->paginate(20);

            } else {
                $search = "";
                $deliverySheets = DB::table('delivery_sheet')->select('delivery_sheet.*', 'spv.name AS spvName', 'drv.staff_id AS stID', 'drv.name AS drvName', 'vehicle.vehicle_id AS vhID', 'vehicle.vehicleCode AS vhCode', 'vehicle.make AS make', 'vehicle_type.typeName AS tpName', 'area.areaCode AS arCD', 'area.areaName AS arNM', 'area.city AS arCT')
                    ->leftJoin('staff AS drv', 'delivery_sheet.driver_id', '=', 'drv.staff_id')
                    ->leftJoin('staff AS spv', 'delivery_sheet.supervisor_id', '=', 'spv.staff_id')
                    ->leftJoin('vehicle', 'delivery_sheet.vehicle_id', '=', 'vehicle.vehicle_id')
                    ->leftJoin('vehicle_type', 'vehicle.vehicleType_id', '=', 'vehicle_type.vehicleType_id')
                    ->join('area', 'delivery_sheet.area_id', '=', 'area.area_id')
                    ->orderByDesc('delivery_sheet.created_at')->paginate(20);

            }
        }


        $statusView = lcfirst($statusView);

        if(($statusView == "checked-out" || $statusView == "un-checked-out") && !($search == "checked-out" || $search == "un-checked-out")){

            $search = 'in'. ':'. $statusView .' '. $search;

//            $search = $search . $initialvalue;
        }






        $data = compact('deliverySheets', 'search', 'newConsignments', 'statusView');


        return view('frontend.viewdeliverysheets')->with($data);
    }

    public function viewSingle($id, Request $request)
    {


        $search = $request['search'] ?? "";

        $totalVolume = 0;
        $totalWeight = 0;

        $dSheet = DeliverySheet::find($id);
        if (!isset($dSheet)) {
            return $this->view($request);
        }

        $consignments1 = Consignment::select('consignment.*')
            ->where('deliverySheet_id', '=', "$id")->get();

        foreach ($consignments1 as $cons){
//            echo $cons->consWeight;
            $totalWeight += $cons->getWeight();
            $totalVolume += $cons->getVolume();
        }



        $deliverySheets = DB::table('delivery_sheet')->select('delivery_sheet.*', 'spv.name AS spvName','drv.staff_id AS stID', 'drv.name AS drvName', 'drv.staffCode AS staffCode', 'vehicle.vehicleCode AS vhCode', 'vehicle.make AS make', 'vehicle_type.typeName AS tpName', 'area.areaCode AS arCD', 'area.areaName AS arNM', 'area.city AS arCT')->where('delivery_sheet.deliverySheet_id', '=', "$id")
            ->leftJoin('staff AS drv', 'delivery_sheet.driver_id', '=', 'drv.staff_id')
            ->leftJoin('staff AS spv', 'delivery_sheet.supervisor_id', '=', 'spv.staff_id')
            ->leftJoin('vehicle', 'delivery_sheet.vehicle_id', '=', 'vehicle.vehicle_id')
            ->leftJoin('vehicle_type', 'vehicle.vehicleType_id', '=', 'vehicle_type.vehicleType_id')
            ->join('area', 'delivery_sheet.area_id', '=', 'area.area_id')
            ->get();

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





        if(isset($deliverySheet->driver_id)){

$driver = DB::table('staff')->select('staff.staff_id','staff.staffCode','staff.name')->where('staff.deleted_at','=',null)
    ->where('staff.staff_id', $deliverySheet->driver_id)->get();

            $drivers = DB::table('staff')->select('staff.staff_id','staff.staffCode','staff.name')->where('staff.deleted_at','=',null)->where('staff.staff_id', '!=', $deliverySheet->driver_id)
                ->leftJoin('driver', 'staff.staff_id', '=', 'driver.staff_id')->where('driver.status', '=', 'Unassigned')->where('driver.canDrive', 'LIKE', "%$deliverySheet->tpName%")
                ->get();

//            ->orwhere('driver.canDrive','LIKE', "%$deliverySheet->tpName%")->get();

            if(isset($driver[0])) {
                $drivers->prepend($driver[0]);
            }
//echo $deliverySheet->tpName;
//echo "<br>";
//echo "<pre>";
//print_r($drivers1);
//die;
        }else{


            if(isset($consignments1[0]->consWeight)) {

                if ($consignments1[0]->consWeight <= 2) {

                    $type = "Bike";
                    $drivers = DB::table('staff')->select('staff.staff_id', 'staff.staffCode', 'staff.name')->where('staff.deleted_at', '=', null)
                        ->leftJoin('driver', 'staff.staff_id', '=', 'driver.staff_id')->where('driver.status', '=', 'Unassigned')->where('driver.canDrive', 'LIKE', "%$type%")
                        ->get();


                }
                else{
                    $type = "Bike";
                    $drivers = DB::table('staff')->select('staff.staff_id', 'staff.staffCode', 'staff.name')->where('staff.deleted_at', '=', null)
                        ->leftJoin('driver', 'staff.staff_id', '=', 'driver.staff_id')->where('driver.status', '=', 'Unassigned')->where('driver.canDrive', 'NOT LIKE', "$type")
                        ->get();

                }
            }
//            echo $deliverySheet->tpName;
//            echo "<br>";
//            echo "<pre>";
//            print_r($drivers1);
//            die;
        }




    if(isset($deliverySheet->vehicle_id)){



        //Query to fetch the assignedTo from the Vehicle assignment table along with the other vehicle's details
        $vehicles1 = DB::table('vehicle')->select('vehicle.vehicle_id', 'vehicle.vehicleCode', 'vehicle.make', 'vehicle_type.typeName', 'vehicle_type.volumeCap', 'vehicle_type.weightCap', 'vehicle_assignment.assignedTo')->where('status', 'Idle')->where('dsAssigned', '=', '1')->where('vehicle.vehicle_id', $deliverySheet->vehicle_id)
            ->leftJoin('vehicle_assignment', function ($join) {
                $join->on('vehicle.vehicle_id', '=', 'vehicle_assignment.vehicle_id');

            })->orderBy('vehicle_type.volumeCap')
            ->join('vehicle_type', function ($join) use ($deliverySheet) {
                $join->on('vehicle.vehicleType_id', '=', 'vehicle_type.vehicleType_id')->where('vehicle_type.typeName', $deliverySheet->tpName);

            })->get();


        $vehicles = DB::table('vehicle')->select('vehicle.vehicle_id', 'vehicle.vehicleCode', 'vehicle.make', 'vehicle_type.typeName', 'vehicle_type.volumeCap', 'vehicle_type.weightCap', 'vehicle_assignment.assignedTo')->where('status', 'Idle')->where('dsAssigned','=',0)
            ->leftJoin('vehicle_assignment', function ($join) {
                $join->on('vehicle.vehicle_id', '=', 'vehicle_assignment.vehicle_id');

            })->orderBy('vehicle_type.volumeCap')
            ->join('vehicle_type', function ($join) use ($deliverySheet) {
                $join->on('vehicle.vehicleType_id', '=', 'vehicle_type.vehicleType_id')->where('vehicle_type.typeName', $deliverySheet->tpName);

            })->get();

        if(isset($vehicles1[0])) {
            if(in_array($vehicles1[0],$vehicles->toArray())){
                $vehicles = $vehicles->filter(function($item) use($vehicles1) {
                    return $item->vehicle_id != $vehicles1[0]->vehicle_id;
                });

                $vehicles->prepend($vehicles1[0]);
            }else{
                $vehicles->prepend($vehicles1[0]);
            }

        }
        else{
            $vehicles1 = DB::table('vehicle')->select('vehicle.vehicle_id', 'vehicle.vehicleCode', 'vehicle.make', 'vehicle_type.typeName', 'vehicle_type.volumeCap', 'vehicle_type.weightCap', 'vehicle_assignment.assignedTo')->where('status', 'Active')->where('dsAssigned', '=', '1')->where('vehicle.vehicle_id', $deliverySheet->vehicle_id)
                ->leftJoin('vehicle_assignment', function ($join) {
                    $join->on('vehicle.vehicle_id', '=', 'vehicle_assignment.vehicle_id');

                })->orderBy('vehicle_type.volumeCap')
                ->join('vehicle_type', function ($join) use ($deliverySheet) {
                    $join->on('vehicle.vehicleType_id', '=', 'vehicle_type.vehicleType_id')->where('vehicle_type.typeName', $deliverySheet->tpName);

                })->get();
            if(isset($vehicles1[0])) {
                if(in_array($vehicles1[0],$vehicles->toArray())){

                    $vehicles = $vehicles->filter(function($item) use($vehicles1) {
                        return $item->vehicle_id != $vehicles1[0]->vehicle_id;
                    });

                    $vehicles->prepend($vehicles1[0]);
                }else{
                    $vehicles->prepend($vehicles1[0]);
                }

            }
        }
//echo "<pre>";
//
//        print_r($vehicles);
//        die;

    }else {

        if (isset($consignments1[0])) {

            if ($consignments1[0]->consWeight <= 2) {
                $vehicles = DB::table('vehicle')->select('vehicle.vehicle_id', 'vehicle.vehicleCode', 'vehicle.make', 'vehicle_type.typeName', 'vehicle_type.volumeCap', 'vehicle_type.weightCap', 'vehicle_assignment.assignedTo')->where('dsAssigned', '=', 0)->where('vehicle.deleted_at', '=', null)->where('status', 'Idle')
                    ->leftJoin('vehicle_assignment', function ($join) {
                        $join->on('vehicle.vehicle_id', '=', 'vehicle_assignment.vehicle_id');

                    })
                    ->join('vehicle_type', function ($join) {
                        $join->on('vehicle.vehicleType_id', '=', 'vehicle_type.vehicleType_id')->where('typeName', '=', 'Bike');

                    })->orderBy('vehicle_type.volumeCap')
                    ->get();

            } else {

                //greater then weight of current delivery sheet


//                Query to fetch the assignedTo from the Vehicle assignment table along with the other vehicle's details
                $vehicles = DB::table('vehicle')->select('vehicle.vehicle_id', 'vehicle.vehicleCode', 'vehicle.make', 'vehicle_type.typeName', 'vehicle_type.volumeCap', 'vehicle_type.weightCap', 'vehicle_assignment.assignedTo')->where('dsAssigned', '=', 0)->where('vehicle.deleted_at', '=', null)->where('status', 'Idle')
                    ->leftJoin('vehicle_assignment', function ($join) {
                        $join->on('vehicle.vehicle_id', '=', 'vehicle_assignment.vehicle_id');

                    })
                    ->join('vehicle_type', function ($join) use ($totalVolume, $totalWeight) {
                        $join->on('vehicle.vehicleType_id', '=', 'vehicle_type.vehicleType_id')->where('typeName', '!=', 'Bike')->where('vehicle_type.weightCap', '>=', "$totalWeight")->where('vehicle_type.volumeCap', '>=', "$totalVolume");

                    })->orderBy('vehicle_type.volumeCap')->get();

            }
        }
    }

//        if ($deliverySheet->tpName != "Bike") {
//
//            //Query to fetch the assignedTo from the Vehicle assignment table along with the other vehicle's details
//            $vehicles = DB::table('vehicle')->select('vehicle.vehicle_id', 'vehicle.vehicleCode', 'vehicle.make', 'vehicle_type.typeName', 'vehicle_type.volumeCap', 'vehicle_type.weightCap', 'vehicle_assignment.assignedTo')->where('vehicle.deleted_at','=', null)->where('status', 'Idle')->where('dsAssigned', '=', '0')
//                ->leftJoin('vehicle_assignment', function ($join) {
//                    $join->on('vehicle.vehicle_id', '=', 'vehicle_assignment.vehicle_id');
//
//                })->orderBy('vehicle_type.volumeCap')
//                ->join('vehicle_type', function ($join) {
//                    $join->on('vehicle.vehicleType_id', '=', 'vehicle_type.vehicleType_id')->where('typeName', '!=', 'Bike');
//
//                })->get();
//        } else {
//
//            $vehicles = DB::table('vehicle')->select('vehicle.vehicle_id', 'vehicle.vehicleCode', 'vehicle.make', 'vehicle_type.typeName', 'vehicle_type.volumeCap', 'vehicle_type.weightCap', 'vehicle_assignment.assignedTo')->where('vehicle.deleted_at','=', null)->where('status', 'Idle')->where('dsAssigned', '=', '0')
//                ->leftJoin('vehicle_assignment', function ($join) {
//                    $join->on('vehicle.vehicle_id', '=', 'vehicle_assignment.vehicle_id');
//
//                })->orderBy('vehicle_type.volumeCap')
//                ->join('vehicle_type', function ($join) {
//                    $join->on('vehicle.vehicleType_id', '=', 'vehicle_type.vehicleType_id')->where('typeName', '=', 'Bike');
//
//                })
//                ->get();
//        }




//    echo "<pre>";
//    print_r($vehicles);
//    die;

        if(!isset($vehicles)){
            $vehicles = Vehicle::where('vehicle_id',-1)->get();

        }
        if(!isset($drivers)){
            $drivers = Driver::where('driver_id', -1)->get();
        }


        if(isset($vehicles)){
            $idleVehicles = count($vehicles);
        }


        $vehicleCode = "";
        if(isset($deliverySheet->vehicle_id)){
            $vehicleData = Vehicle::find($deliverySheet->vehicle_id);
            $vehicleCode = $vehicleData->vehicleCode;
        }

        $driverCode = "";
        if(isset($deliverySheet->driver_id)){
            $driverData = Staff::find($deliverySheet->driver_id);
            $driverCode = $driverData->staffCode;
        }


//        echo "<pre>";
//        print_r($deliverySheet);
//
//        die;
        $data = compact('deliverySheet', 'consignments', 'vehicleCode','driverCode', 'search', 'totalWeight', 'totalVolume', 'vehicles','drivers', 'idleVehicles');



        return view('frontend.viewdeliverysheet')->with($data);


    }


    public function removeConsignment(Request $request)
    {

        $id = $request->cons_id;
        $consignment = Consignment::find($id);
        if (!is_null($consignment)) {
            $deliverySheet_id = $consignment->deliverySheet_id;

            $dSheet = DeliverySheet::find($deliverySheet_id);
            $dSheet->noOfCons = $dSheet->noOfCons-1;
            $dSheet->save();

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


                if(isset($deliverySheet->driver_id)) {
                    $driver = Driver::find($deliverySheet->driver_id);

                    $driver->status = "Unassigned";
                    $driver->save();

                    }

                if(isset($deliverySheet->vehicle_id)) {
                    $vehicle = Vehicle::find($deliverySheet->vehicle_id);

                    $vehicle->dsAssigned = 0;
                    $vehicle->status = "Idle";
                    $vehicle->save();

                }

                $deliverySheet->finished = 1;

                $deliverySheet->save();

                return redirect('/frontend/view-deliverysheet/'.$id)->withSuccessMessage('Successfully marked Delivered!');
            } else {
                $deliverySheet->status = 'checked-out';
                $deliverySheet->checkOutTime = date("Y-m-d H:i:s");

                $deliverySheet->supervisor_id = Session::get('staff_id');
                $vehicle = Vehicle::find($deliverySheet->vehicle_id);

                $vehicle->status = "Active";
                $vehicle->save();

                $deliverySheet->save();
                return redirect('/frontend/view-deliverysheet/'.$id)->withSuccessMessage('Successfully Checked-out');
            }
        }

    }

    public function addConsignments($id, Request $request){

        $search = $request['search'] ?? "";


        $totalVolume = 0;
        $totalWeight = 0;

        $dSheet = DeliverySheet::find($id);
        if ($dSheet == null) {
            return $this->view($request);
        }

        $deliverySheets = DB::table('delivery_sheet')->select('delivery_sheet.*', 'spv.name AS spvName', 'drv.name AS drvName', 'drv.staffCode AS staffCode', 'vehicle.vehicleCode AS vhCode', 'vehicle.make AS make', 'vehicle_type.typeName AS tpName', 'area.areaCode AS arCD', 'area.areaName AS arNM', 'area.city AS arCT')
            ->leftJoin('staff AS drv', 'delivery_sheet.driver_id', '=', 'drv.staff_id')
            ->leftJoin('staff AS spv', 'delivery_sheet.supervisor_id', '=', 'spv.staff_id')
            ->leftJoin('vehicle', 'delivery_sheet.vehicle_id', '=', 'vehicle.vehicle_id')
            ->leftJoin('vehicle_type', 'vehicle.vehicleType_id', '=', 'vehicle_type.vehicleType_id')
            ->join('area', 'delivery_sheet.area_id', '=', 'area.area_id')
            ->where('delivery_sheet.deliverySheet_id', '=', "$id")->get();

        $deliverySheet = $deliverySheets[0];

        $vehicleType = strval($deliverySheet->tpName);

//        echo "<pre>";
//        print_r($deliverySheet->toArray());


if($deliverySheet->tpName == "Bike") {
    if ($search != "") {

        $consignments = DB::table('consignment')->select('consignment.*')
            ->orderBy('created_at')->where('area_id', $deliverySheet->area_id)
            ->where('deliverySheet_id', '=', null)
            ->where('consWeight', '<=', 2)
            ->where(function ($query) use ($search) {
                $query->where('consCode', 'LIKE', "%$search%")->orwhere('consWeight', 'LIKE', "%$search%")
                    ->orwhere('consVolume', 'LIKE', "%$search%")->orwhere('toAddress', 'LIKE', "%$search%")

                    ->orwhere('consType', 'LIKE', "%$search%");
            })->orderBy('consignment.consVolume')
            ->paginate(20);


        //->orwhere('canDrive','LIKE', "%$search%")

    } else {
        $consignments = DB::table('consignment')->select('consignment.*')
            ->orderBy('created_at')->where('area_id', $deliverySheet->area_id)
            ->where('deliverySheet_id', '=', null)
            ->where('consWeight', '<=', 2)->orderBy('consignment.consVolume')->paginate(20);
    }
}else {

    if ($search != "") {

        $consignments = DB::table('consignment')->select('consignment.*')
            ->orderBy('created_at')->where('area_id', $deliverySheet->area_id)
            ->where('deliverySheet_id', '=', null)
            ->where('consWeight', '>', 2)
            ->where(function ($query) use ($search) {
                $query->where('consCode', 'LIKE', "%$search%")->orwhere('consWeight', 'LIKE', "%$search%")
                    ->orwhere('consVolume', 'LIKE', "%$search%")->orwhere('toAddress', 'LIKE', "%$search%")

                    ->orwhere('consType', 'LIKE', "%$search%");
            })->orderBy('consignment.consVolume')->paginate(20);


        //->orwhere('canDrive','LIKE', "%$search%")

    } else {
        $consignments = DB::table('consignment')->select('consignment.*')
            ->orderBy('created_at')->where('area_id', $deliverySheet->area_id)
            ->where('deliverySheet_id', '=', null)
            ->where('consWeight', '>', 2)->orderBy('consignment.consVolume')->paginate(20);
    }

}
//        echo "<pre>";
//        print_r($consignments->toArray());

        $deliverySheetCons = Consignment::select('consignment.*')
            ->where('deliverySheet_id', '=', "$id")->get();

        foreach ($deliverySheetCons as $cons){
//            echo $cons->consWeight;

            $totalWeight += $cons->getWeight();
            $totalVolume += $cons->getVolume();
        }



        if(isset($deliverySheet->driver_id)){
            $driver = DB::table('staff')->select('staff.staff_id','staff.staffCode','staff.name')->where('staff.staff_id', $deliverySheet->driver_id)->get();

            $drivers = DB::table('staff')->select('staff.staff_id','staff.staffCode','staff.name')->where('staff.staff_id', '!=', $deliverySheet->driver_id)
                ->leftJoin('driver', 'staff.staff_id', '=', 'driver.staff_id')->where('driver.canDrive', 'LIKE', "%$deliverySheet->tpName%")->where('driver.status', '=', 'Unassigned')
                ->get();

//            ->orwhere('driver.canDrive','LIKE', "%$deliverySheet->tpName%")->get();

            $drivers->prepend($driver[0]);
//echo $deliverySheet->tpName;
//echo "<br>";
//echo "<pre>";
//print_r($drivers1);
//die;
        }else{
            $drivers = DB::table('staff')->select('staff.staff_id','staff.staffCode','staff.name')->where('staff.deleted_at','=', null)
                ->leftJoin('driver', 'staff.staff_id', '=', 'driver.staff_id')->where('driver.canDrive', 'LIKE', "%$deliverySheet->tpName%")->where('driver.status', '=', 'Unassigned')
                ->get();


//            echo $deliverySheet->tpName;
//            echo "<br>";
//            echo "<pre>";
//            print_r($drivers1);
//            die;
        }




        if(isset($deliverySheet->vehicle_id)){
            //Query to fetch the assignedTo from the Vehicle assignment table along with the other vehicle's details
            $vehicles1 = DB::table('vehicle')->select('vehicle.vehicle_id', 'vehicle.vehicleCode', 'vehicle.make', 'vehicle_type.typeName', 'vehicle_type.volumeCap', 'vehicle_type.weightCap', 'vehicle_assignment.assignedTo')->where('status', 'Idle')->where('dsAssigned', '=', '1')->where('vehicle.vehicle_id', $deliverySheet->vehicle_id)
                ->leftJoin('vehicle_assignment', function ($join) {
                    $join->on('vehicle.vehicle_id', '=', 'vehicle_assignment.vehicle_id');

                })->orderBy('vehicle_type.volumeCap')
                ->join('vehicle_type', function ($join) use ($deliverySheet) {
                    $join->on('vehicle.vehicleType_id', '=', 'vehicle_type.vehicleType_id')->where('vehicle_type.typeName', $deliverySheet->tpName);

                })->get();


            $vehicles = DB::table('vehicle')->select('vehicle.vehicle_id', 'vehicle.vehicleCode', 'vehicle.make', 'vehicle_type.typeName', 'vehicle_type.volumeCap', 'vehicle_type.weightCap', 'vehicle_assignment.assignedTo')->where('status', 'Idle')->where('dsAssigned', '=', '0')
                ->leftJoin('vehicle_assignment', function ($join) {
                    $join->on('vehicle.vehicle_id', '=', 'vehicle_assignment.vehicle_id');

                })->orderBy('vehicle_type.volumeCap')
                ->join('vehicle_type', function ($join) use ($deliverySheet) {
                    $join->on('vehicle.vehicleType_id', '=', 'vehicle_type.vehicleType_id')->where('vehicle_type.typeName', $deliverySheet->tpName);

                })->get();
            if(isset($vehicles1[0])) {
                $vehicles->prepend($vehicles1[0]);
            }
//echo "<pre>";
//
//        print_r($vehicles);
//        die;

        }else {

            if ($deliverySheet->tpName != "Bike") {

                //Query to fetch the assignedTo from the Vehicle assignment table along with the other vehicle's details
                $vehicles = DB::table('vehicle')->select('vehicle.vehicle_id', 'vehicle.vehicleCode', 'vehicle.make', 'vehicle_type.typeName', 'vehicle_type.volumeCap', 'vehicle_type.weightCap', 'vehicle_assignment.assignedTo')->where('deleted_at','=', null)->where('status', 'Idle')->where('dsAssigned', '=', '0')
                    ->leftJoin('vehicle_assignment', function ($join) {
                        $join->on('vehicle.vehicle_id', '=', 'vehicle_assignment.vehicle_id');

                    })->orderBy('vehicle_type.volumeCap')
                    ->join('vehicle_type', function ($join) {
                        $join->on('vehicle.vehicleType_id', '=', 'vehicle_type.vehicleType_id')->where('typeName', '!=', 'Bike');

                    })->get();
            } else {

                $vehicles = DB::table('vehicle')->select('vehicle.vehicle_id', 'vehicle.vehicleCode', 'vehicle.make', 'vehicle_type.typeName', 'vehicle_type.volumeCap', 'vehicle_type.weightCap', 'vehicle_assignment.assignedTo')->where('deleted_at','=', null)->where('status', 'Idle')->where('dsAssigned', '=', '0')
                    ->leftJoin('vehicle_assignment', function ($join) {
                        $join->on('vehicle.vehicle_id', '=', 'vehicle_assignment.vehicle_id');

                    })->orderBy('vehicle_type.volumeCap')
                    ->join('vehicle_type', function ($join) {
                        $join->on('vehicle.vehicleType_id', '=', 'vehicle_type.vehicleType_id')->where('typeName', '=', 'Bike');

                    })
                    ->get();
            }
        }



    echo "<pre>";
    print_r($vehicles);
    die;


        $data = compact('deliverySheet', 'consignments', 'search', 'totalWeight', 'totalVolume', 'vehicles','drivers', 'vehicleType');

        return view('/frontend/addConsignments')->with($data);
    }


    public function addConsignmentsToDeliverySheet(Request $request){

        $arr = json_decode($request->str);



        for($i=1; $i<count($arr); $i++){
            $cons = Consignment::find($arr[$i]);
            $cons->deliverySheet_id = $arr[0];

            $cons->save();
        }


        $ds = DeliverySheet::find($arr[0]);
$ds->noOfCons = $ds->noOfCons + count($arr)-1;
$ds->save();


        return response()->json([
            'status' => 200,
'str' => count($arr),
        ]);
    }


    public function delete(Request $request){

        $id = $request->vehicle_delete_id;

        $dSheet = DeliverySheet::find($id);
        if(!is_null($dSheet)) {

            if($dSheet->driver_id != null){
                $driver = Driver::find($dSheet->driver_id);
                $driver->status = "Unassigned";
                $driver->save();
            }

            if($dSheet->vehicle_id != null){
                $vehicle = Vehicle::find($dSheet->vehicle_id);
                $vehicle->dsAssigned = 0;
                $vehicle->save();
            }

            $consignments = Consignment::where('deliverySheet_id', '=', "$id")->update(['deliverySheet_id' => null]);

            $dSheet->delete();

        }


        return redirect('/frontend/view-deliverysheets')->withSuccessMessage('Successfully Deleted!');
    }


}


