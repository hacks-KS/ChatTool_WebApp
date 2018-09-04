<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Hash;
use Response;
use Input;
use App\User;

class SignupController extends Controller{
  public function postSave(){
    $nickname_num = User::where('nickname', Input::get('nickname'))->get();
    if(count($nickname_num) == 0){
      $hash_pass = Hash::make(Input::get('password'));
      User::create(array(
        'nickname' => Input::get('nickname'),
        'password' => $hash_pass
      ));
      return Response::json(array('success' => true));
    }else{
      return Response::json(array('success' => false));
    };
  }
}
