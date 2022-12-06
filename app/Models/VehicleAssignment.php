<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleAssignment extends Model
{
    use HasFactory;
    protected $table = 'vehicle_assignment';
    protected $primaryKey = 'vehicle_id';

    public function getVehicle(){
        return $this->hasOne('App\Models\Vehicle', 'vehicle_id');
    }


    public function getDriver(){
        return $this->hasOne('App\Models\Staff', 'staff_id', 'assignedTo');
    }

    public function getSupervisor(){
        return $this->hasOne('App\Models\Staff', 'staff_id', 'assignedBy');
    }

    public function getDateAssignedAttribute(){
        return date("d-M-Y", $this->attributes['dateAssigned']);
    }

}
