<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Fuel;

class FuelController extends Controller
{

    public function view(){
        $fuel = Fuel::all();
        $fuel = $fuel[0];
        $data = compact('fuel');
        return view('frontend.viewfuel')->with($data);
    }
}
