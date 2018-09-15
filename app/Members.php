<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Members extends Model
{
  protected $fillable = [
      'first_name','last_name', 'sex','birth_date','address', 'level',
      'network_id', 'leader_id', 'dp_filename',
  ];
}
