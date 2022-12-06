<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompVehicle extends Model
{
    use HasFactory;

    protected $table = 'comp_vehicle';
    protected $primaryKey = 'vehicle_id';

    public function vehicle(){
        return $this->belongsTo(Vehicle::class);
    }

    public function getPurchasedDate($value){
        return date("d-M-Y", strtotime($value));
    }

}
