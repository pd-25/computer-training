<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $table = 'students';

    protected $fillable = [
        'name',
        'email',
        'phone',
        'created_by',
    ];

    public function subAdmin()
    {
        return $this->belongsTo(SubAdmin::class, 'created_by');
    }
}
