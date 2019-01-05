<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
  protected $fillable = [
      'member_name','action', 'network_id','approved','seen'
  ];
}
