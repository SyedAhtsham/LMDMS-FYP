<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consignment extends Model
{
    use HasFactory;
    protected $table = 'consignment';
    protected $primaryKey = 'cons_id';

    public function getConsWeightAttribute(){
        return $this->attributes['consWeight']." kg";
    }

    public function getConsVolumeAttribute(){
        return $this->attributes['consVolume']." m3";
    }
}
