<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Consignment;
use App\Models\Staff;
use Illuminate\Http\Request;

class ConsignmentController extends Controller
{

    public function view(Request $request){

        $search = $request['search'] ?? "";

        if($search != ""){


            $consignment = Consignment::select('consignment.*')
                ->where('consCode','LIKE', "%$search%")->orwhere('consWeight','LIKE', "%$search%")->orwhere('consVolume','LIKE', "%$search%")->orwhere('toAddress','LIKE', "%$search%")->orwhere('fromAddress','LIKE', "%$search%")
                ->orwhere('consType','LIKE', "%$search%")->paginate(20);
            //->orwhere('canDrive','LIKE', "%$search%")

        }
        else{
            $consignment = Consignment::paginate(20);
        }
        $data = compact('consignment', 'search');
        return view('frontend.viewconsignments')->with($data);
    }
}
