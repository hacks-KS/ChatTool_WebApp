<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Cookie;
use View;
use App\User;

# ログイン,サインアップ画面に入るときの処理
class LoginIndexController extends Controller{
  public function index(Request $request){
    # セッションidがデータベースのデータと一致すればchat画面に移動
    $sessionid_num = count(User::where('sessionid', $request->cookie('sessionid'))->get());
    if($sessionid_num != 0){
      return redirect()->to('/chat');
    }else{
      return View::make('index');
    }
  }
}
