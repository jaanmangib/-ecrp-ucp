<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RpTestAttempt extends Model
{
    protected $fillable = ['user_id','submitted_at','passed','score','failed_question_ids'];

    protected $casts = [
        'submitted_at' => 'datetime',
        'failed_question_ids' => 'array',
        'passed' => 'boolean',
    ];
}
