<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContVehicle extends Model
{
    use HasFactory;
    protected $table = 'cont_vehicle';
    protected $primaryKey = 'vehicle_id';

    public function vehicle(){
        return $this->belongsTo(Vehicle::class);
    }

    public function getDateOfContract($value){
        return date("d-M-Y", strtotime($value));
    }
}
