<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliverySheet extends Model
{
    use HasFactory;
    protected $table = 'delivery_sheet';
    protected $primaryKey = 'deliverySheet_id';


}
