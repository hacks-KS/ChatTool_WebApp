<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Friend extends Model {
  protected $fillable = array('user_id', 'friend_id');
  public $timestamps = false;
}
