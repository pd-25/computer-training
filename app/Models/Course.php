<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $table = 'courses';

    protected $fillable = [
        'category_id',
        'course_name',
        'slug',
        'description',
        'image',
        'duration',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
