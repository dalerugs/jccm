<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MemberRequest extends Model
{

  public static $ACTTION_CREATE = "CREATE";
  public static $ACTTION_UPDATE = "UPDATE";
  public static $ACTTION_DELETE = "DELETE";

  protected $fillable = [
      'first_name','last_name', 'sex','birth_date','address', 'level',
      'network_id', 'leader_id', 'dp_filename', 'action', 'member'
  ];
}
