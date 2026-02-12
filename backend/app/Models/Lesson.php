<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    use HasFactory;

    protected $fillable = [
        'unit_id',
        'code',
        'title',
        'title_en',
        'duration',
        'type',
    ];

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function content()
    {
        return $this->hasOne(LessonContent::class);
    }

    public function attachments()
    {
        return $this->morphMany(Attachment::class, 'attachable');
    }
}

