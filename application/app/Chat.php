<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model {
  protected $fillable = array('group_id', 'user_id', 'content');
  public $timestamps = false;
}
