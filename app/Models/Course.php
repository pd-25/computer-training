<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $table = 'courses';

    protected $fillable = [
        'course_unique_id',
        'category_id',
        'course_name',
        'price',
        'subjects',
        'slug',
        'description',
        'image',
        'duration',
        'duration_type',
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
