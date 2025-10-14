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
        'assigned_course_id',
        'created_by',
    ];

    public function subAdmin()
    {
        return $this->belongsTo(SubAdmin::class, 'created_by');
    }

    protected $casts = [
        'assigned_course_id' => 'array',
    ];

    protected $attributes = [
        'assigned_course_id' => '[]',
    ];
}
