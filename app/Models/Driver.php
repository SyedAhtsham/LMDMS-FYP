<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use PhpParser\Node\Expr\Cast\String_;

class Driver extends Model
{
    use HasFactory;
    protected $table = 'driver';
    protected $primaryKey = 'staff_id';

    public function staff(){
        return $this->belongsTo(Staff::class);
    }



}
