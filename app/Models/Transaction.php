<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'project_id',
        'contract_type_id',
        'po_number',
        'equipment_number',
        'fulfillment',
        'reference_number',
        'created_by',
        'approver_id',
        'deleted_by',
        'reason_for_delete',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

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
        return $this->belongsTo(User::class, 'created_by');
    }
    public function approver()
    {
        return $this->belongsTo(User::class, 'approver_id');
    }
}
