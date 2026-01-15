<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'project_name',
        'contract_type_id',
        'po_number',
        'reference_number',
        'created_by',
        'deleted_by',
        'reason_for_delete',
    ];

    public function contractType()
    {
        return $this->belongsTo(ContractType::class);
    }

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');  // foreign key column
    }
}
