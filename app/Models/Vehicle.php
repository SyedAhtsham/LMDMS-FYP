<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;
    protected $table = 'vehicle';
    protected $primaryKey = 'vehicle_id';

    public function getContVehicle(){
        return $this->hasOne('App\Models\ContVehicle', 'vehicle_id');
    }
    public function getCompVehicle(){
        return $this->hasOne('App\Models\CompVehicle', 'vehicle_id');
    }

    public function getVehicleType(){
        return $this->hasOne(VehicleType::class, 'vehicleType_id', 'vehicleType_id');
    }

    public function getVehicleAssignment(){
        return $this->hasOne(VehicleAssignment::class, 'vehicle_id', 'vehicle_id');
    }

    public function setPlateNoAttribute($value){
        $this->attributes['plateNo'] = strtoupper($value);
    }

}
