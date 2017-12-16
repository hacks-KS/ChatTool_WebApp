<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Cookie;
use View;
use App\User;

# チャット画面に入るときの処理
class ChatController extends Controller{
  public function index(Request $request){
    # セッションidがデータベースのデータと一致すればchat画面に移動
    $user_info = User::where('sessionid', $request->cookie('sessionid'))->get();
    if(count($user_info) != 0){
      return View::make('chat', ['user_info' => $user_info]);
    }else{
      return redirect()->to('/');
    }
  }
}