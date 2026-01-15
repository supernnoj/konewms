<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Inventory extends Model
{
    use SoftDeletes;

    protected $table = 'inventories';

    protected $fillable = [
        'part_no',
        'description',
        'category',
        'quantity',
        'unit_of_measurement',
        'created_by',
        'deleted_by',
        'reason_for_delete',
    ];
}
