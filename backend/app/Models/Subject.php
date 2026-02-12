<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = [
        'grade_id',
        'code',
        'name',
        'name_en',
        'icon',
        'color',
    ];

    public function grade()
    {
        return $this->belongsTo(Grade::class);
    }

    public function units()
    {
        return $this->hasMany(Unit::class);
    }

    public function attachments()
    {
        return $this->morphMany(Attachment::class, 'attachable');
    }
}

