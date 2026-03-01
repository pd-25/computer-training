<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mark extends Model
{
    protected $fillable = [
        'student_id',
        'course_id',
        'year',
        'marks',
        'session_from',
        'session_to',
        'issue_date',
        'issue_date_certificate'
    ];

    protected $casts = [
        'marks' => 'array',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
