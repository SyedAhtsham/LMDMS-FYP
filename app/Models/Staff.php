<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Staff extends Model
{
    use HasFactory;
    protected $table = 'staff';
    protected $primaryKey = 'staff_id';

    public function getDriver(){
        return $this->hasOne('App\Models\Driver', 'staff_id');
    }

    public function getUser(){
        return $this->hasOne('App\Models\User', 'staff_id');
    }

    public function getVehAssAsSupervisor(){
        return $this->hasMany('App\Models\VehicleAssignment', 'assignedBy', 'staff_id');
    }

    public function getVehAssAsDriver(){
        return $this->hasOne('App\Models\VehicleAssignment', 'assignedTo', 'staff_id');
    }


    public function setNameAttribute($value){
        $this->attributes['name'] = ucwords($value);
    }

    public function setAddressAttribute($value){
        $this->attributes['address'] = ucwords($value);
    }

    public function getDob($value){
        return date("d-M-Y", strtotime($value));
    }
}
