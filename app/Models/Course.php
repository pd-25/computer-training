<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $table = 'courses';

    protected $fillable = [
        'category_id',
        'course_name',
        'subjects',
        'slug',
        'description',
        'image',
        'duration',
    ];

    protected $casts = [
        'subjects' => 'array',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function marks()
    {
        return $this->hasMany(Mark::class);
    }
}
