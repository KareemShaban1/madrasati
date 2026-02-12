<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LessonContent extends Model
{
    use HasFactory;

    protected $fillable = [
        'lesson_id',
        'title',
        'title_en',
        'objectives',
        'key_points',
        'sections',
        'quick_quiz',
        'prev_lesson_id',
        'next_lesson_id',
    ];

    protected $casts = [
        'objectives' => 'array',
        'key_points' => 'array',
        'sections' => 'array',
        'quick_quiz' => 'array',
    ];

    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }
}

