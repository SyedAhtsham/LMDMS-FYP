<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
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

        echo "Your username is " . $request['email'] . " and your password is " . $myPassword;
        return redirect('/frontend/view-staff')->withSuccessMessage('Successfully added');

    }

    public function view(Request $request)
    {

        $search = $request['search'] ?? "";

        if ($search != "") {

            $staff = Staff::with('getDriver')
                ->where('name', 'LIKE', "%$search%")->orwhere('staffCode', 'LIKE', "%$search%")->orwhere('position', 'LIKE', "%$search%")->orwhere('address', 'LIKE', "%$search%")->orwhere('gender', 'LIKE', "%$search%")->paginate(20);
            //->orwhere('canDrive','LIKE', "%$search%")

        } else {
//          $staff = Staff::with('getDriver')->get();
            $staff = Staff::with('getDriver')
                ->paginate(20);
        }
        $data = compact('staff', 'search');
        return view('frontend.viewstaff')->with($data);
    }

    public function delete(Request $request)
    {

        $id = $request->staff_delete_id;
        $vehicleAssignment = VehicleAssignment::where('assignedTo','=', $id)->first();

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
                    $driver->delete();
                }
//            echo "<pre>";
//            print_r($driver->toArray());

            }
            $user = User::find($id);
            if (!is_null($user)) {
                $user->delete();
            }

            $staff->delete();
        }
        return redirect('/frontend/view-staff')->withSuccessMessage('Successfully deleted');;

    }

    public function edit($id)
    {
//        $staff = Staff::find($id);
        $vehicleTypes = VehicleType::all();
        $staff = Staff::with('getDriver')->find($id);
        if (is_null($staff)) {
            return redirect('/frontend/view-staff');
        } else {
            $url = url('/frontend/update-staff') . '/' . $id;
            $title = "Update Staff";
            $data = compact('staff', 'url', 'title', 'vehicleTypes');
            return view('frontend.addstaff')->with($data);
        }

    }

    public function update($id, Request $request)
    {

        $staff = Staff::find($id);
        $userEmail = $staff->email ?? '';

        if ($userEmail != $request['email']) {
            $request->validate([
                'email' => 'required|string|email|max:255|unique:users',
            ]);

        }

        if ($request['position'] == 'Driver') {
            $request->validate(
                [
                    'licenseNo' => 'required'
                ]
            );
        }

        $request->validate(
            [
                'name' => 'required',
                'contact' => 'required',
                'cnic' => 'required',
                'email' => 'required|string|email|max:255',
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

        $uniqueStaffCode = 'ST-';

        $staffId = $id;


        if ($request['position'] == 'Driver') {
            $uniqueStaffCode .= 'D' . $staffId;
        } elseif ($request['position'] == 'Supervisor') {
            $uniqueStaffCode .= 'S' . $staffId;
        } else {
            $uniqueStaffCode .= 'M' . $staffId;
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
                $canDriveStr = implode(', ', $canDrive);
                echo $canDriveStr;
                $driver1->canDrive = $canDriveStr;
                $driver1->save();
            } else {
                $driver = Driver::find($id);
                $driver->licenseNo = $request['licenseNo'];
                $driver->yearsExp = $request['yearsExperience'];
                $canDrive = $request['canDrive'];
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

        return redirect('/frontend/view-staff')->withSuccessMessage('Successfully updated');

    }


}
