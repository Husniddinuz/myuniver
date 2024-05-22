<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'group_id',
        'full_name',
        'age',
        'gender',
        'high_school_diploma',
        'passport',
        'IELTS',
        'ielts_score',
        'motivation_letter'
    ];

    public function group()
    {
        return $this->belongsTo(Group::class);
    }
}
