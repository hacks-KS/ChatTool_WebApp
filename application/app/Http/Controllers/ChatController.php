<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Response;
use Input;
use Log;
use DB;
use App\User;
use App\Friend;
use App\Group;
use App\GroupMember;
use App\Chat;


class ChatController extends Controller{

  public function postIndex(Request $request){
    $user_info = User::where('sessionid', $request->cookie('sessionid'))->get();
    $friend_info = User::where('nickname', Input::get('nickname'))->get();
    $friend_id_list = Friend::where('user_id', $user_info[0]['id'])->get();
    $unique = true;
    foreach ($friend_id_list as $friend_id) {
      if(count($friend_info) != 0){
        if($friend_id->friend_id == $friend_info[0]['id']){
          $unique = false;
          break;
        }
      }
    }
    if(count($friend_info) != 0){
      if($friend_info[0]['id'] != $user_info[0]['id'] && $unique == true){
        return Response::json(array('success' => true));
      }else{
        return Response::json(array('success' => false));
      }
    }else{
      return Response::json(array('success' => false));
    }
  }

  public function postAdd(Request $request){
    $user_info = User::where('sessionid', $request->cookie('sessionid'))->get();
    $friend_info = User::where('nickname', Input::get('nickname'))->get();
    Friend::create(array('user_id' => $user_info[0]['id'], 'friend_id' => $friend_info[0]['id']));
    $chat_exit_bool = false;
    $user_group = GroupMember::join('groups','group_members.group_id','=','groups.id')->select('groups.id')->where('user_id', $user_info[0]['id'])->where('boolgroup', 0)->get();
    foreach ($user_group as $group) {
      $group_info = GroupMember::where('group_id', $group->id)->get();
      foreach ($group_info as $info){
        if ($info->user_id == $friend_info[0]['id']){
          $chat_exit_bool = true;
        }
      }
    }
    $success = true;
    if ($chat_exit_bool == false){
      DB::beginTransaction();
      try {
        $groupid = Group::insertGetId(array('groupname' => 'NoGroup','boolgroup' => false));
        GroupMember::create(array('group_id' => $groupid, 'user_id' => $user_info[0]['id']));
        GroupMember::create(array('group_id' => $groupid, 'user_id' => $friend_info[0]['id']));
        DB::commit();
      } catch (Exception $e) {
        $success = false;
        DB::rollback();
      }
    }
    return Response::json(array('success' => $success));
  }

  public function postSend(Request $request){
    $user_info = User::where('sessionid', $request->cookie('sessionid'))->get();
    Chat::create(array('group_id' => Input::get('group_id'), 'user_id' => $user_info[0]['id'], 'content' => Input::get('text')));
    return Response::json(array('success' => true));
  }

  public function postGroup(Request $request){
    $user_info = User::where('sessionid', $request->cookie('sessionid'))->get();
    $success = true;
    DB::beginTransaction();
    try {
      $groupid = Group::insertGetId(array('groupname' => Input::get('group_name'),'boolgroup' => true));
      GroupMember::create(array('group_id' => $groupid, 'user_id' => $user_info[0]['id']));
      if(count(Input::get('group_member')) != 0){
        foreach (Input::get('group_member') as $group_member) {
          $friend_info = User::where('nickname', $group_member)->get();
          GroupMember::create(array('group_id' => $groupid, 'user_id' => $friend_info[0]['id']));
        }
      }
      DB::commit();
    } catch (Exception $e) {
      $success = false;
      DB::rollback();
    }
    return Response::json(array('success' => $success));
  }

  function make_comment($array, $user_id){
    $comment_list = array();
    foreach ($array as $data) {
      if ($data['user_id'] == $user_id){
        $comment = array('user'=> 0, 'text'=>$data['content']);
      }else{
        $comment = array('user'=> $data['nickname'], 'text'=>$data['content']);
      }
      array_push($comment_list, $comment);
    }
    return $comment_list;
  }

  public function getComment(Request $request){
    $user_info = User::where('sessionid', $request->cookie('sessionid'))->get();
    Log::debug($user_info);
    $user_group = GroupMember::where('user_id', $user_info[0]['id'])->get();
    $chat_info_list = array();
    foreach ($user_group as $group) {
      $chat_info = Chat::join('users','chats.user_id','=','users.id')->where('group_id', $group['group_id'])->get();
      $comment_list = $this->make_comment($chat_info, $user_info[0]['id']);
      $chat_info_array = array('id' => $group['group_id'], 'comment' => $comment_list);
      array_push($chat_info_list, $chat_info_array);
    }
    return Response::json(array('chat_info' => $chat_info_list));
  }

  public function getRoom(Request $request){
    $user_info = User::where('sessionid', $request->cookie('sessionid'))->get();
    $user_group = GroupMember::join('groups','group_members.group_id','=','groups.id')->where('user_id', $user_info[0]['id'])->get();
    $room_list = array();
    foreach ($user_group as $group) {
      if ($group['boolgroup'] == 0) {
        $group_info = GroupMember::where('group_id', $group->id)->get();
        foreach ($group_info as $info){
          if ($info->user_id != $user_info[0]['id']){
            $friend_info = User::where('id', $info->user_id)->get();
            $friend_array = array('groupname' => $friend_info[0]['nickname'], 'id' => $info['group_id']);
            array_push($room_list, $friend_array);
          }
        }
      }else{
        array_push($room_list, $group);
      }
    }
    return Response::json(array('group_info' => $room_list));
  }

  public function getFriend(Request $request){
    $user_info = User::where('sessionid', $request->cookie('sessionid'))->get();
    $user_group = GroupMember::join('groups','group_members.group_id','=','groups.id')->where('user_id', $user_info[0]['id'])->where('boolgroup', 0)->get();
    $friend_list = array();
    foreach ($user_group as $group) {
      $group_info = GroupMember::where('group_id', $group->id)->get();
      foreach ($group_info as $info){
        if ($info->user_id != $user_info[0]['id']){
          $friend_info = User::where('id', $info->user_id)->get();
          $friend_array = array('groupname' => $friend_info[0]['nickname'], 'id' => $info['group_id']);
          array_push($friend_list, $friend_array);
        }
      }
    }
    return Response::json(array('group_info' => $friend_list));
  }

  public function getGroup(Request $request){
    $user_info = User::where('sessionid', $request->cookie('sessionid'))->get();
    $user_group = GroupMember::join('groups','group_members.group_id','=','groups.id')->where('user_id', $user_info[0]['id'])->where('boolgroup', 1)->select('groups.groupname', 'groups.id')->get();
    return Response::json(array('group_info' => $user_group));
  }
}
