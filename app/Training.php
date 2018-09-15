<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Training extends Model
{
  protected $fillable = [
      'member','batch', 'pre_encounter','encounter','post_encounter', 'sol1',
      'sol2','re_encounter', 'sol3','baptism',
  ];
}
