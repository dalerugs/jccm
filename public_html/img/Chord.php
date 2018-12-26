<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Chord extends Model
{
    public $incrementing = false;
    protected $fillable = ['id', 'user_id','title','chords','chords_key'];
}
