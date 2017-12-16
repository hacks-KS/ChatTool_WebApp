<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Response;
use Input;
use App\User;

class SignupController extends Controller{
  public function postSearch(){
    $nickname_num = count(User::where('nickname', Input::get('nickname'))->get());
    $uniqueidid_num = count(User::where('uniqueid', Input::get('id'))->get());
    return Response::json(array(
      'success' => true,
      'nickname' => $nickname_num,
      'uniqueid' => $uniqueidid_num
    ));
  }

  public function postSave(){
    User::create(array(
      'nickname' => Input::get('nickname'),
      'uniqueid' => Input::get('id')
    ));
    return Response::json(array('success' => true));
  }
}
