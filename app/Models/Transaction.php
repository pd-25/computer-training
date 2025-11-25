<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'subadmin_id',
        'student_id',
        'debit_balance',
        'avl_balance',
    ];

    public function subadmin()
    {
        return $this->belongsTo(SubAdmin::class, 'subadmin_id');
    }

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }
}
