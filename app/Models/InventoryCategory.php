<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InventoryCategory extends Model
{
    use SoftDeletes;

    protected $table = 'inventories_category';

    protected $fillable = [
        'name',
        'created_by',
        'deleted_by',
    ];

    public function inventories()
    {
        return $this->hasMany(Inventory::class, 'category_id');
    }
}
