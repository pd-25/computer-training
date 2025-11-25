<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TopupRequest extends Model
{
    protected $fillable = [
        'subadmin_id',
        'amount',
        'payment_reciept',
        'status',
    ];

    public function subadmin()
    {
        return $this->belongsTo(SubAdmin::class, 'subadmin_id');
    }
}
