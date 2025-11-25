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
        'father_name',
        'dob',
        'admission_date',
        'enrollment_no',
        'image',
        'org_name',
        'assigned_course_id',
        'created_by',
    ];

    public function subAdmin()
    {
        return $this->belongsTo(SubAdmin::class, 'created_by');
    }

    public function marks()
    {
        return $this->hasMany(Mark::class);
    }

    protected $casts = [
        'assigned_course_id' => 'array',
    ];

    protected $attributes = [
        'assigned_course_id' => '[]',
    ];

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
