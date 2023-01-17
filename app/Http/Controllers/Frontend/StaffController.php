<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Controller;
use App\Models\DeliverySheet;
use App\Models\Fuel;
use App\Models\Vehicle;
use App\Models\VehicleAssignment;
use App\Models\VehicleType;
use Illuminate\Http\Request;
use App\Models\Staff;
use App\Models\Driver;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class StaffController extends Controller
{
    //

    public function create()
    {
        $vehicleTypes = VehicleType::all();
        $staff = Staff::with('getDriver')->find(134);
        $url = url('/frontend/add-staff');
        $title = "Add Staff";
        $data = compact('url', 'title', 'staff', 'vehicleTypes');
        return view('frontend.addstaff')->with($data);
    }


    public function randomPassword()
    {
        $alphabet = 'abcdefghijklmnopqrstuvwxyz1234567890';
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < 4; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); //turn the array into a string
    }


    public function insert(Request $request)
    {


//        if(sizeof(DB::table('users')->where('email', $request['email'])->get()) > 0){
//            echo 'Sorry this email already exists';
//            die;
//        }

        if ($request['position'] == 'Driver') {
            $request->validate(
                [
                    'licenseNo' => 'required|unique:driver',
                    'email' => 'required|string|email|max:255|unique:users',
                    'name' => 'required',
                    'contact' => 'required',
                    'cnic' => 'required|unique:staff',
                    'gender' => 'required',
                    'position' => 'required',
                    'address' => 'required',
                    'canDrive' => 'required',

                ]
            );
        }

        $request->validate(
            [
                'email' => 'required|string|email|max:255|unique:users',
                'name' => 'required',
                'contact' => 'required',
                'cnic' => 'required|unique:staff',
                'gender' => 'required',
                'position' => 'required',
                'address' => 'required',

            ]
        );


        //in order to get the last staff_id and create a unique staffCode

        $staff = new Staff;
        $staff->staffCode = "";
        $staff->name = $request['name'];
        $staff->email = $request['email'];
        $staff->contact = $request['contact'];
        if (!($request['address'] == "")) {
            $staff->address = $request['address'];
        }
        $staff->cnic = $request['cnic'];
        $staff->position = $request['position'];
        if (!($request['dob'] == "")) {
            $staff->dob = $request['dob'];
        }
        $staff->gender = $request['gender'];

        $staff->save();

        $staff1 = Staff::all();

        $uniqueStaffCode = 'ST';

        if (sizeof($staff1) > 0) {
            $lastIndex = $staff1[sizeof($staff1) - 1]['staff_id'];
        } else {
            $lastIndex = 0;
        }
        $staffId = $lastIndex;


        if ($request['position'] == 'Driver') {
            $uniqueStaffCode .= 'D-' . $lastIndex;
        } elseif ($request['position'] == 'Supervisor') {
            $uniqueStaffCode .= 'S-' . $lastIndex;
        } else {
            $uniqueStaffCode .= 'M-' . $lastIndex;
        }


        $staff->staffCode = $uniqueStaffCode;

        $staff->save();

        if ($request['position'] == 'Driver') {
            $driver = new Driver;
            $driver->staff_id = $staffId;
            $driver->licenseNo = $request['licenseNo'];
            if ($request['yearsExperience'] != "")
                $driver->yearsExp = $request['yearsExperience'];
            $canDrive = $request['canDrive'];
            $canDrive = array_unique($canDrive);

            $canDriveStr = implode(', ', $canDrive);
            $driver->canDrive = $canDriveStr;

            $driver->save();

        }

        $user = new User;
        $user->email = $request['email'];
        $myPassword = $this->randomPassword();
        $user->password = $myPassword;
        $user->staff_id = $staffId;


        $user->save();

//        echo "Your username is " . $request['email'] . " and your password is " . $myPassword;
        return redirect('/frontend/staff/'.$staffId)->withSuccessMessage('Successfully added and User Account has been created!');

    }

    public function view(Request $request)
    {

        $search = $request['search'] ?? "";

        if ($search != "") {


            $staff = Staff::with('getDriver')
                ->where('deleted_at', '=', null)
                ->where(function ($query) use($search) {
                    $query->where('name', 'LIKE', "%$search%")->orwhere('staffCode', 'LIKE', "%$search%")->orwhere('position', 'LIKE', "%$search%")->orwhere('address', 'LIKE', "%$search%")->orwhere('gender', 'LIKE', "%$search%");
})
                ->orderByDesc('staff.created_at')
                ->paginate(20);
            //->orwhere('canDrive','LIKE', "%$search%")

        } else {
//          $staff = Staff::with('getDriver')->get();
            $staff = Staff::with('getDriver')
                ->where('deleted_at', '=', null)
                ->orderByDesc('staff.created_at')
                ->paginate(20);
        }
        $data = compact('staff', 'search');
        return view('frontend.viewstaff')->with($data);
    }

    public function delete(Request $request)
    {

        $id = $request->staff_delete_id;

        $timestamp = date("Y-m-d H:i:s");

        $vehicleAssignment = VehicleAssignment::where('assignedTo','=', "$id")->first();

        if(!is_null($vehicleAssignment)){
            $veh = Vehicle::find($vehicleAssignment->vehicle_id);

            $veh->assignStatus = "Unassigned";
            $veh->save();
            $vehicleAssignment->delete();
        }

        $staff = Staff::find($id);
        if (!is_null($staff)) {
            if ($staff->position == "Driver") {

                $driver = Driver::find($id);
                if (!is_null($driver)) {

                    $dSheet = DeliverySheet::where('driver_id', '=', "$id")->where('status', '=', 'un-checked-out')->orderByDesc('created_at')->first();
                    if(isset($dSheet->driver_id)){
                    $dSheet->driver_id = null;
                    $dSheet->save();
                    }

                    $driver->vhAssigned = 0;
                 $driver->status = "Unassigned";
                    $driver->deleted_at = $timestamp;
                    $driver->save();
                }
//            echo "<pre>";
//            print_r($driver->toArray());

            }

            $user = User::find($id);
            if (!is_null($user)) {
                $user->delete();
            }



$staff->deleted_at = $timestamp;



            $staff->save();
        }
        return redirect('/frontend/view-staff')->withSuccessMessage('Successfully Deleted!');

    }

    public function edit($id)
    {
//        $staff = Staff::find($id);
        $vehicleTypes = VehicleType::all();
        $staff = Staff::with('getDriver')->where('deleted_at', '=', null)->find($id);

        if (is_null($staff)) {
            return redirect('/frontend/view-staff');
        } else {
            $url = url('/frontend/update-staff') . '/' . $id;
            $title = "Edit Staff";
            $data = compact('staff', 'url', 'title', 'vehicleTypes');
            return view('frontend.addstaff')->with($data);
        }

    }

    public function update($id, Request $request)
    {

        $staff = Staff::find($id);

        $userEmail = $staff->email ?? '';
        $cnic = $staff->cnic ?? '';

        $driver = Driver::find($id);
        $licenseNo = $driver->licenseNo ?? '';



        if ($userEmail != $request['email']) {
            $request->validate([
                'email' => 'required|string|email|max:255|unique:users',
            ]);

        }

        if ($cnic != $request['cnic']) {
            $request->validate([
                'cnic' => 'required|unique:staff',
            ]);

        }

        if ($licenseNo != $request['licenseNo']) {
            $request->validate([
                'licenseNo' => 'required|unique:driver',
            ]);

        }

        if ($request['position'] == 'Driver') {
            $request->validate(
                [


                    'name' => 'required',
                    'contact' => 'required',

                    'gender' => 'required',
                    'position' => 'required',
                    'address' => 'required',
                    'canDrive' => 'required',

                ]
            );
        }

        $request->validate(
            [

                'name' => 'required',
                'contact' => 'required',

                'gender' => 'required',
                'position' => 'required',
                'address' => 'required',

            ]
        );


        //in order to get the last staff_id and create a unique staffCode
        $staff = Staff::find($id);
        $staff->staffCode = "";
        $staff->name = $request['name'];
        $staff->email = $request['email'];
        $staff->contact = $request['contact'];
        if (!($request['address'] == "")) {
            $staff->address = $request['address'];
        }
        $staff->cnic = $request['cnic'];


        $staff->position = $request['position'];

        if (!($request['dob'] == "")) {
            $staff->dob = $request['dob'];
        }
        $staff->gender = $request['gender'];

        $staff->save();

        $uniqueStaffCode = 'ST';

        $staffId = $id;


        if ($request['position'] == 'Driver') {
            $uniqueStaffCode .= 'D-' . $staffId;
        } elseif ($request['position'] == 'Supervisor') {
            $uniqueStaffCode .= 'S-' . $staffId;
        } else {
            $uniqueStaffCode .= 'M-' . $staffId;
        }

        $staff->staffCode = $uniqueStaffCode;

        $staff->save();

        $driver = Driver::find($id);
        if ($request['position'] == 'Driver') {
            if (is_null($driver)) {
                $driver1 = new Driver;
                $driver1->staff_id = $id;
                $driver1->licenseNo = $request['licenseNo'];
                $driver1->yearsExp = $request['yearsExperience'];
                $canDrive = $request['canDrive'];
                $canDrive = array_unique($canDrive);
                $canDriveStr = implode(', ', $canDrive);
                echo $canDriveStr;
                $driver1->canDrive = $canDriveStr;
                $driver1->save();
            } else {
                $driver = Driver::find($id);
                $driver->licenseNo = $request['licenseNo'];
                $driver->yearsExp = $request['yearsExperience'];
                $canDrive = $request['canDrive'];
                $canDrive = array_unique($canDrive);
                $canDriveStr = implode(', ', $canDrive);
                echo $canDriveStr;
                $driver->canDrive = $canDriveStr;
                $driver->save();
            }


        } else {
            if (!is_null($driver)) {
                $driver->delete();
            }
        }

        $user = User::find($id);
        if (!is_null($request['email'])) {
            $user->email = $request['email'];
        }
        $user->save();

//        return redirect('/frontend/view-staff')->withSuccessMessage('Successfully updated');


        return redirect('/frontend/staff/'.$staffId)->withSuccessMessage('Successfully Updated!');
    }

    public function viewSingle($id){

        $staff = Staff::find($id);
$vehicleAssignment = DB::table('vehicle_assignment')->where('assignedTo','=', "$id")->first();


if(isset($vehicleAssignment->vehicle_id)) {
    $vehicle = Vehicle::find($vehicleAssignment->vehicle_id);
}else{
    $vehicle = null;
}

$dSheet = DB::table('delivery_sheet')->where('finished',0)->where('driver_id','=', "$id")->orderByDesc('created_at')->first();


        $driver = Driver::find($id);

        $accounts = User::where('staff_id', '=', $id)->get();
        if(isset($accounts[0])) {
            $account = $accounts[0];
        }else{
            $account = null;
        }

if(!isset($staff)){
    return redirect('/frontend/view-staff')->withErrorMessage('Sorry no record found!');
}

        $data = compact( 'staff', 'driver', 'account','dSheet', 'vehicleAssignment', 'vehicle');
//        $data = compact('url', 'title');

            return view('frontend.viewsinglestaff')->with($data);



    }


    public function changePassword($str){
        $arr = explode(",", $str);

        $userID = $arr[0];
        $password = $arr[1];

        $user = User::find($userID);

        if(isset($user)){
            $user->password = $password;
$user->save();

        }
        return response()->json([
            'status' => 200,
        ]);


    }

}
