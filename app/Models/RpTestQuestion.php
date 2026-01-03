<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RpTestQuestion extends Model
{
    protected $fillable = ['text','sort_order','active'];

    public function answers()
    {
        return $this->hasMany(RpTestAnswer::class, 'question_id');
    }
}
