<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    use HasFactory;

    protected $fillable = [
        'stage_id',
        'code',
        'name',
        'name_en',
    ];

    public function stage()
    {
        return $this->belongsTo(Stage::class);
    }

    public function subjects()
    {
        return $this->hasMany(Subject::class);
    }

    public function attachments()
    {
        return $this->morphMany(Attachment::class, 'attachable');
    }
}

