<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Frontend\ConsignmentController;
use App\Http\Controllers\Frontend\DeliverySheetController;
use App\Http\Controllers\Frontend\FuelController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\StaffController;
use App\Http\Controllers\Frontend\VehicleAssignmentController;
use App\Http\Controllers\Frontend\VehicleController;
use App\Models\Consignment;
use App\Models\DeliverySheet;
use App\Models\Driver;
use App\Models\Staff;
use App\Models\Vehicle;
use App\Models\VehicleAssignment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Kreait\Laravel\Firebase\Facades\Firebase;
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;
use Kreait\Firebase\Database;
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


Route::group(['middleware'=>"web"], function(){

    Route::get('/', [HomeController::class, 'index']);
    Route::get('/frontend/add-staff', [StaffController::class, 'create']);
    Route::post('/frontend/add-staff', [StaffController::class, 'insert']);
    Route::get('/frontend/view-staff', [StaffController::class, 'view']);
    Route::post('/frontend/view-staff', [StaffController::class, 'view']);
    Route::get('/frontend/staff/{id}', [StaffController::class, 'viewSingle'])->name('view.singlestaff');
//Route::get('/frontend/delete-staff/{id}', [StaffController::class, 'delete'])->name('staff.delete');
    Route::post('/frontend/delete-staff', [StaffController::class, 'delete'])->name('staff.delete');
    Route::get('/frontend/edit-staff/{id}', [StaffController::class, 'edit'])->name('staff.edit');
    Route::post('/frontend/update-staff/{id}', [StaffController::class, 'update'])->name('staff.update');
    Route::get('/frontend/changePassword/{str}', [StaffController::class, 'changePassword']);
    Route::get('/frontend/emailValidation/{str}', [VehicleController::class, 'validateEmail']);



    Route::get('/frontend/add-vehicle', [VehicleController::class, 'create']);
    Route::post('/frontend/add-vehicle', [VehicleController::class, 'insert']);
    Route::get('/frontend/view-vehicle', [VehicleController::class, 'view']);
    Route::post('/frontend/view-vehicle', [VehicleController::class, 'view']);
    Route::get('/frontend/vehicle/{id}', [VehicleController::class, 'viewSingle'])->name('view.singlevehicle');
//Route::get('/frontend/delete-vehicle/{id}', [VehicleController::class, 'delete'])->name('vehicle.delete');
    Route::post('/frontend/delete-vehicle', [VehicleController::class, 'delete'])->name('vehicle.delete');
    Route::get('/frontend/edit-vehicle/{id}', [VehicleController::class, 'edit'])->name('vehicle.edit');
    Route::get('/frontend/vehicle-assignment/{type}', [VehicleController::class, 'assignDriver'])->name('vehicle.assign');
    Route::post('/frontend/vehicle-assignment/', [VehicleController::class, 'addVehicleAssignment'])->name('vehicle.assignment');
    Route::post('/frontend/update-vehicle/{id}', [VehicleController::class, 'update'])->name('vehicle.update');
    Route::get('/frontend/vehicleAssignments/{str}', [VehicleController::class, 'fetchDrivers']);
    Route::get('/frontend/vehicleAssignment/{str}', [VehicleController::class, 'updateAssignment']);

//Route::get('/frontend/vehicleAssignment', array('uses'  =>  'VehicleController@updateAssignment'));

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
    Route::get('/frontend/add-consignments/{id}', [DeliverySheetController::class, 'addConsignments']);
    Route::get('/frontend/add-consignments-toDS/{str}', [DeliverySheetController::class, 'addConsignmentsToDeliverySheet']);
    Route::post('/frontend/delete-deliverySheet', [DeliverySheetController::class, 'delete'])->name('deliverySheet.delete');



    Route::get('/frontend/view-vehicleAssignments', [VehicleAssignmentController::class, 'view']);
    Route::post('/frontend/view-vehicleAssignments', [VehicleAssignmentController::class, 'view']);
    Route::post('/frontend/vehicleAssignment-delete', [VehicleAssignmentController::class, 'delete'])->name('vehicleAssignment.delete');





    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::get('login', [AuthController::class,'index'])->name('login');
    Route::post('login', [AuthController::class,'login'])->name('login');


    Route::get('home', [AuthController::class,'home'])->name('home');

    Route::get('homeDriver', [AuthController::class,'homeDriver'])->name('homeDriver');

    Route::get('logout', [AuthController::class,'logout'])->name('logout');





});






//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
