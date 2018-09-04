<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Hash;
use Response;
use Input;
use Cookie;
use Log;
use App\User;

# /api/loginのコントローラ
class LoginController extends Controller{
  # ログインの処理
  public function postIndex(Request $request){
    # ニックネームがデータと一致するか検索
    $nickname = User::where('nickname', Input::get('nickname'))->get();
    if(count($nickname) != 0){
      if(Hash::check(Input::get('password'), $nickname[0]['password'])){
        # 一致すればセッションidを発行
        $request->session()->regenerate();
        $session = $request->session()->getId();
        User::where('nickname', Input::get('nickname'))->update(['sessionid' => $session]);
        $cookie = Cookie::make('sessionid', $session, 60);
        return Response::json(array('success' => true))->withCookie($cookie);
      }else{
        return Response::json(array('success' => 'pass_false'));
      }
    }else{
      # 一致しないのでログインさせない
      return Response::json(array('success' => 'name_false'));
    }
  }
}
