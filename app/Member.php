<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
  protected $fillable = [
      'first_name','last_name', 'sex','birth_date','address', 'level',
      'network_id', 'leader_id', 'dp_filename',
  ];

  public static function leaders($network = null){
    if (isset($network)) {
      $members = Member::where('network_id',$network)->orderBy('first_name')->get();
    }else {
      $members = Member::orderBy('first_name')->get();
    }
    $leaders = array();
    foreach ($members as $member) {
      if (Member::where('leader_id',$member->id)->first() != null) {
        $leaders []= $member;
      }
    }
    return $leaders;
  }
}
