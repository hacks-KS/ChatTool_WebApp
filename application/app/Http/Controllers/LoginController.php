<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
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
    $nickname_num = count(User::where('nickname', Input::get('nickname'))->get());
    if($nickname_num != 0){
      # 一致すればセッションidを発行
      $request->session()->regenerate();
      $id = $request->session()->getId();
      User::where('nickname', Input::get('nickname'))->update(['sessionid' => $id]);
      $cookie = Cookie::make('sessionid', $id, 60);
      return Response::json(array('success' => true))->withCookie($cookie);
    }else{
      # 一致しないのでログインさせない
      return Response::json(array('success' => false));
    }
  }
}
