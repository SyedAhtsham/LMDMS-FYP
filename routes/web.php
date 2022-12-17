<?php

use App\Http\Controllers\Frontend\ConsignmentController;
use App\Http\Controllers\Frontend\DeliverySheetController;
use App\Http\Controllers\Frontend\FuelController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\StaffController;
use App\Http\Controllers\Frontend\VehicleAssignmentController;
use App\Http\Controllers\Frontend\VehicleController;
use App\Models\VehicleAssignment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [HomeController::class, 'index']);
Route::get('/frontend/add-staff', [StaffController::class, 'create']);
Route::post('/frontend/add-staff', [StaffController::class, 'insert']);
Route::get('/frontend/view-staff', [StaffController::class, 'view']);
Route::post('/frontend/view-staff', [StaffController::class, 'view']);
//Route::get('/frontend/delete-staff/{id}', [StaffController::class, 'delete'])->name('staff.delete');
Route::post('/frontend/delete-staff', [StaffController::class, 'delete'])->name('staff.delete');
Route::get('/frontend/edit-staff/{id}', [StaffController::class, 'edit'])->name('staff.edit');
Route::post('/frontend/update-staff/{id}', [StaffController::class, 'update'])->name('staff.update');


Route::get('/frontend/add-vehicle', [VehicleController::class, 'create']);
Route::post('/frontend/add-vehicle', [VehicleController::class, 'insert']);
Route::get('/frontend/view-vehicle', [VehicleController::class, 'view']);
Route::post('/frontend/view-vehicle', [VehicleController::class, 'view']);
//Route::get('/frontend/delete-vehicle/{id}', [VehicleController::class, 'delete'])->name('vehicle.delete');
Route::post('/frontend/delete-vehicle', [VehicleController::class, 'delete'])->name('vehicle.delete');
Route::get('/frontend/edit-vehicle/{id}', [VehicleController::class, 'edit'])->name('vehicle.edit');
Route::get('/frontend/vehicle-assignment/{type}', [VehicleController::class, 'assignDriver'])->name('vehicle.assign');
Route::post('/frontend/vehicle-assignment/', [VehicleController::class, 'addVehicleAssignment'])->name('vehicle.assignment');
Route::post('/frontend/update-vehicle/{id}', [VehicleController::class, 'update'])->name('vehicle.update');


Route::get('/frontend/view-consignments', [ConsignmentController::class, 'view']);
Route::post('/frontend/view-consignments', [ConsignmentController::class, 'view']);

Route::get('/frontend/view-fuel', [FuelController::class, 'view']);

Route::get('/frontend/view-deliverysheets', [DeliverySheetController::class, 'view']);
Route::post('/frontend/view-deliverysheets', [DeliverySheetController::class, 'view']);
Route::get('/frontend/view-deliverysheet/{id}', [DeliverySheetController::class, 'viewSingle'])->name('view.deliverysheet');
Route::post('/frontend/remove-consignment', [DeliverySheetController::class, 'removeConsignment'])->name('remove.consignment');
Route::get('/frontend/dsheet', [DeliverySheetController::class, 'create']);
Route::post('/frontend/checkout-deliverySheet', [DeliverySheetController::class, 'checkoutDeliverySheet'])->name('checkout.deliverySheet');
Route::get('/frontend/generateDSheet', [DeliverySheetController::class, 'generate']);



Route::get('/frontend/view-vehicleAssignments', [VehicleAssignmentController::class, 'view']);
Route::post('/frontend/view-vehicleAssignments', [VehicleAssignmentController::class, 'view']);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');






Route::get('/view', function () {



    $consignments = DB::table('consignment');


    print_r($consignments);


die;



//    $lines = file('englishwords/nouns.txt');
//    $count = 0;
//    $words = array();
//    foreach($lines as $line) {
//        $count += 1;
//        array_push($words, $line);
//    }
//
////    foreach ($words as $word){
////        echo $word;
////        echo "<br>";
////    }
//
//
//
//// input misspelled word
//    $input = 'drver';
//
//
//// no shortest distance found, yet
//    $shortest = -1;
//
//// loop through words to find the closest
//    foreach ($words as $word) {
//
//        // calculate the distance between the input word,
//        // and the current word
//        $lev = levenshtein($input, $word);
//
//        // check for an exact match
//        if ($lev == 0) {
//
//            // closest word is this one (exact match)
//            $closest = $word;
//            $shortest = 0;
//
//            // break out of the loop; we've found an exact match
//            break;
//        }
////        echo $lev."<br>";
//        // if this distance is less than the next found shortest
//        // distance, OR if a next shortest word has not yet been found
//        if ($lev <= $shortest || $shortest < 0) {
//            // set the closest match, and shortest distance
//
//            $closest  = $word;
//            $shortest = $lev;
//        }
//    }
//
//    echo "Input word: $input\n";
//    if ($shortest == 0) {
//        echo "Exact match found: $closest\n";
//    } else {
//        echo "Did you mean: $closest?\n";
//    }





//    $vehicleType = "Bike";
//    echo "<pre>";
//    $drivers = DB::table('staff')->select('staff.name AS stName', 'driver.canDrive AS canDrive')
//        ->join('driver', 'staff.staff_id', '=', 'driver.staff_id')->where('canDrive', 'LIKE', "%$vehicleType%")
//        ->get();
//    print_r($drivers);


//    $vehicleAssignments = VehicleAssignment::with(['getVehicle','getVehicle.getVehicleType', 'getDriver', 'getSupervisor'])
//        ->where('vehicleCode', "LIKE", "%$search%")->orwhere('getVehicle.make', "LIKE", "%$search%")->orwhere('getVehicle.getVehicleType.typeName', "LIKE", "%$search%")->orwhere('getDriver.name', "LIKE", "%$search%")->orwhere('getSupervisor.name', "LIKE", "%$search%")
//        ->paginate(20);


//    $vehicleAssignments = DB::table('vehicle_assignment')->select('spv.name AS spvName', 'drv.name AS drvName', 'vehicle.vehicleCode', 'vehicle.make', 'vehicle_type.typeName', 'vehicle_assignment.dateAssigned')
//        ->join('staff AS drv', 'vehicle_assignment.assignedTo', '=', 'drv.staff_id')
//        ->join('staff AS spv', 'vehicle_assignment.assignedBy', '=', 'spv.staff_id')
//        ->join('vehicle', 'vehicle_assignment.vehicle_id', '=', 'vehicle.vehicle_id')
//        ->join('vehicle_type', 'vehicle.vehicleType_id', '=', 'vehicle_type.vehicleType_id')
//        ->get();

//    $drivers = DB::table('driver')->select('staff_id')->get();
//
//    $deliverySheets = DB::table('delivery_sheet')->select('delivery_sheet.deliverySheet_id AS dsID','spv.name AS spvName', 'drv.name AS drvName', 'vehicle.vehicleCode AS vhCode', 'vehicle.make AS make', 'vehicle_type.typeName AS tpName', 'area.areaCode AS arCD', 'area.areaName AS arNM', 'area.city AS arCT')
//        ->join('staff AS drv', 'delivery_sheet.driver_id', '=', 'drv.staff_id')
//        ->leftJoin('staff AS spv', 'delivery_sheet.supervisor_id', '=', 'spv.staff_id')
//        ->join('vehicle', 'delivery_sheet.vehicle_id', '=', 'vehicle.vehicle_id')
//        ->join('vehicle_type', 'vehicle.vehicleType_id', '=', 'vehicle_type.vehicleType_id')
//        ->join('area', 'delivery_sheet.area_id', '=', 'area.area_id')
//        ->orderBy('delivery_sheet.deliverySheet_id')->get();

//    $deliverySheets = \App\Models\DeliverySheet::all();
//        ->join('staff', 'vehicle_assignment.assignedBy', '=', 'staff.staff_id')

////        ->join('staff', 'vehicle_assignment.assignedTo', '=', 'staff.staff_id')
//        ->get();





//    echo "<pre>";
//    print_r($deliverySheets->toArray());

});
