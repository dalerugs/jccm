<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
  protected $fillable = [
      'first_name','last_name', 'sex','birth_date','address', 'level',
      'network_id', 'leader_id', 'dp_filename',
  ];

  public static function leaders(){
    $members = Member::all();
    $leaders = array();
    foreach ($members as $member) {
      if (Member::where('leader_id',$member->id)->first() != null) {
        $leaders []= $member;
      }
    }
    return $leaders;
  }
}
