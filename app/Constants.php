<?php

namespace App;

class Constants
{
  public static $MAX_LEVEL = 5;

  public static $TRAININGS = [
    'PRE' => 'pre_encounter',
    'ENC'=> 'encounter',
    'POST' => 'post_encounter',
    'SOL1' => 'sol1',
    'SOL2'=> 'sol2',
    'RE'=> 're_encounter',
    'SOL3'=> 'sol3',
  ];

  public static $TRAININGS_TOTAL = [
    'PRE' => 0,
    'ENC'=> 0,
    'POST' => 0,
    'SOL1' => 0,
    'SOL2'=> 0,
    'RE'=> 0,
    'SOL3'=> 0,
  ];


}
