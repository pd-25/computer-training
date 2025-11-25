<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    protected $table = 'wallets';

    protected $fillable = [
        'subadmin_id',
        'amount',
    ];

    public function subadmin()
    {
        return $this->belongsTo(Subadmin::class);
    }
}
