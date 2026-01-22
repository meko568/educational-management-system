<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'code',
        'academicYear',
    ];
    
    /**
     * Scope a query to only include courses for a specific academic year.
     */
    public function scopeForAcademicYear($query, $academicYear)
    {
        return $query->where('academicYear', $academicYear);
    }

    /**
     * Get the lessons for this course.
     */
    public function lessons(): HasMany
    {
        return $this->hasMany(Lesson::class)->orderBy('order');
    }
}
