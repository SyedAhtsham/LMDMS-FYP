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

        $consignments = Consignment::all()->where('area_id', $area);


        $MAXBIKE = 20;
        $forBike = new ArrayList();
        $i = 0;
        foreach ($consignments as $consignment) {
            if ($consignment->consWeight <= 2) {
                echo $consignment->cons_id;
                $i++;
            }
            echo "\n";
        }

//        echo "<pre>";
//        print_r($forBike->toArray());


    }

    public function view(Request $request)
    {

        $search = $request['search'] ?? "";

//        $vehicle = Vehicle::with(['getContVehicle', 'getCompVehicle', 'getVehicleType'])->get();
//        echo "<pre>";
//        print_r($vehicle->toArray());
//        die;

        if ($search != "") {

            $deliverySheets = DB::table('delivery_sheet')->select('delivery_sheet.*', 'spv.name AS spvName', 'drv.name AS drvName', 'vehicle.vehicleCode AS vhCode', 'vehicle.make AS make', 'vehicle_type.typeName AS tpName', 'area.areaCode AS arCD', 'area.areaName AS arNM', 'area.city AS arCT')
                ->join('staff AS drv', 'delivery_sheet.driver_id', '=', 'drv.staff_id')
                ->leftJoin('staff AS spv', 'delivery_sheet.supervisor_id', '=', 'spv.staff_id')
                ->join('vehicle', 'delivery_sheet.vehicle_id', '=', 'vehicle.vehicle_id')
                ->join('vehicle_type', 'vehicle.vehicleType_id', '=', 'vehicle_type.vehicleType_id')
                ->join('area', 'delivery_sheet.area_id', '=', 'area.area_id')
                ->where('delivery_sheet.status', '=', "$search")->orwhere('drv.name', 'LIKE', "%$search%")->orwhere('spv.name', 'LIKE', "%$search%")->orwhere('vehicle.vehicleCode', 'LIKE', "%$search%")->orwhere('vehicle_type.typeName', 'LIKE', "%$search%")->orwhere('area.areaName', 'LIKE', "%$search%")->orwhere('area.areaCode', 'LIKE', "%$search%")
                ->orderBy('delivery_sheet.deliverySheet_id')->paginate(20);


        } else {
            $search = "";
            $deliverySheets = DB::table('delivery_sheet')->select('delivery_sheet.*', 'spv.name AS spvName', 'drv.name AS drvName', 'vehicle.vehicleCode AS vhCode', 'vehicle.make AS make', 'vehicle_type.typeName AS tpName', 'area.areaCode AS arCD', 'area.areaName AS arNM', 'area.city AS arCT')
                ->join('staff AS drv', 'delivery_sheet.driver_id', '=', 'drv.staff_id')
                ->leftJoin('staff AS spv', 'delivery_sheet.supervisor_id', '=', 'spv.staff_id')
                ->join('vehicle', 'delivery_sheet.vehicle_id', '=', 'vehicle.vehicle_id')
                ->join('vehicle_type', 'vehicle.vehicleType_id', '=', 'vehicle_type.vehicleType_id')
                ->join('area', 'delivery_sheet.area_id', '=', 'area.area_id')
                ->orderBy('delivery_sheet.deliverySheet_id')->paginate(20);

        }

        $data = compact('deliverySheets', 'search');


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


