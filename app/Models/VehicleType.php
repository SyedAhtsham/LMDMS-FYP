<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleType extends Model
{
    use HasFactory;
    protected $table = 'vehicle_type';
    protected $primaryKey = 'vehicleType_id';

    public function getVehicle(){
        return $this->hasMany('App\Models\Vehicle', 'vehicleType_id', 'vehicleType_id');
    }

}
