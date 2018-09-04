<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class GroupMember extends Model {
  protected $fillable = array('group_id', 'user_id');
  public $timestamps = false;
}
