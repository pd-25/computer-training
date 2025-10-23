<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FranchiseRequest extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'city',
        'state',
        'investment',
        'experience',
        'message',
        'terms',
        'status',
        'reject_reason'
    ];

    protected $casts = [
        'investment' => 'decimal:2',
        'terms' => 'boolean',
    ];


    // Status badge colors
    public function getStatusBadgeAttribute()
    {
        return [
            'pending' => 'warning',
            'contacted' => 'info',
            'approved' => 'success',
            'rejected' => 'danger'
        ][$this->status] ?? 'secondary';
    }
}
