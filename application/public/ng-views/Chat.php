<div class='top'>LIME</div>
<div class='bottom'>
  <div class='back-side'></div><div class='chatbox'>
    <div class='select-box' ng-switch='statusL'>
      <div class='status-all' ng-switch-when='all'>
        <div class='main-view'>
          <div class='title'>トークルーム 一覧</div>
          <div ng-repeat='room in rooms'>
            <input class='name-list' type='button' value={{room.groupname}} ng-click='comment(room)'>
          </div>
        </div>
        <div class='select-status'>
          <div class='all' ng-click='change_all()'><img class='image' src='ng-views/image/all.png'></div><!--
       --><div class='friend' ng-click='change_friend()'><img class='image' src='ng-views/image/friend.png'></div><!--
       --><div class='group' ng-click='change_group()'><img class='group-image' src='ng-views/image/group.png'></div><!--
       --><div class='add' ng-click='change_add()'><img class='image' src='ng-views/image/add.png'></div>
        </div>
      </div>
      <div class='status-friend' ng-switch-when='friend'>
        <div class='main-view'>
          <div class='title'>友達 一覧</div>
          <div ng-repeat='friend in friends'>
            <input class='name-list' type='button' value={{friend.groupname}} ng-click='comment(friend)'>
          </div>
        </div>
        <div class='select-status'>
          <div class='all' ng-click='change_all()'><img class='image' src='ng-views/image/all.png'></div><!--
       --><div class='friend' ng-click='change_friend()'><img class='image' src='ng-views/image/friend.png'></div><!--
       --><div class='group' ng-click='change_group()'><img class='group-image' src='ng-views/image/group.png'></div><!--
       --><div class='add' ng-click='change_add()'><img class='image' src='ng-views/image/add.png'></div>
        </div>
      </div>
      <div class='status-group' ng-switch-when='group'>
        <div class='main-view'>
          <input class='make-group' type='button' value='グループ作成' ng-click='make_group()'>
          <div class='title'>グループ 一覧</div>
          <div ng-repeat='group in groups'>
            <input class='name-list' type='button' value={{group.groupname}} ng-click='comment(group)'>
          </div>
        </div>
        <div class='select-status'>
          <div class='all' ng-click='change_all()'><img class='image' src='ng-views/image/all.png'></div><!--
       --><div class='friend' ng-click='change_friend()'><img class='image' src='ng-views/image/friend.png'></div><!--
       --><div class='group' ng-click='change_group()'><img class='group-image' src='ng-views/image/group.png'></div><!--
       --><div class='add' ng-click='change_add()'><img class='image' src='ng-views/image/add.png'></div>
        </div>
      </div>
      <div class='status-make-groupL' ng-switch-when='make-group'>
        <div ng-repeat='friend in checkFriend'>
          <div class='name-list'>
            <div class='check-friend'>
              {{friend.name}}
            </div><input type="checkbox" ng-model='friend.flug' ng-checked='friend.flug'>
          </div>
        </div>
      </div>
      <div class='status-add' ng-switch-when='add'>
        <div class='main-view'>
          <input class='search-friend' type='text' placeholder='友達の名前を入力してください' ng-model='$parent.Friend.nickname' ng-keydown='search($event)'>
          <div class='list-friend' ng-switch='searchRes'>
            <div class='friend-true-field' ng-switch-when='true'>
              <div class='friend-top-margin'>{{AddFriend.nickname}}</div>
              <div class='friend-find-text'>友達が見つかりました。<br>追加しますか？</div>
              <div class='friend-add-field'>
                <input class='friend-add-button' type='button' value='追加' ng-click='add()'>
              </div>
            </div>
            <div class='friend-false-field' ng-switch-when='false'>友達が見つかりませんでした。</div>
            <div class='friend-false-field' ng-switch-when='normal'>友達を探してみましょう。</div>
            <div class='friend-false-field' ng-switch-when='added'>友達を追加しました。</div>
          </div>
        </div>
        <div class='select-status'>
          <div class='all' ng-click='change_all()'><img class='image' src='ng-views/image/all.png'></div><!--
       --><div class='friend' ng-click='change_friend()'><img class='image' src='ng-views/image/friend.png'></div><!--
       --><div class='group' ng-click='change_group()'><img class='group-image' src='ng-views/image/group.png'></div><!--
       --><div class='add' ng-click='change_add()'><img class='image' src='ng-views/image/add.png'></div>
        </div>
      </div>
    </div><div class='comment-box' ng-switch='statusR'>
      <div class='status-comment' ng-switch-when='display-comment'>
        <div class='chat-name'>{{selected_group.groupname}}</div>
        <div class='chat-comment'>
          <div ng-repeat='comment in comment_list' on-finish-render='ngRepeatFinished'>
            <div class='kaiwa' ng-attr-id="{{$last &amp;&amp; 'last_element'}}" ng-switch='comment.user'>
              <div ng-switch-when=0>
                <div class='kaiwa-text-left'>
                  <p class='kaiwa-text'>{{comment.text}}</p>
                </div>
              </div>
              <div ng-switch-default>
                <p class='right-kaiwa-name'>{{comment.user}}</p>
                <div class='kaiwa-text-right'>
                  <p class='kaiwa-text'>{{comment.text}}</p>
                </div>
              </div>
            </div>
          </div>
        </div>
        <input class='chat-input' type='text' placeholder='メッセージを入力して下さい' ng-model='$parent.Message.text' ng-keydown='send($event)'>
      </div>
      <div class='status-make-groupR' ng-switch-when='make-group'>
        <div class='group-name-field'>
          <input class='group-name-text' type='text' placeholder='グループ名を入力して下さい' ng-model='$parent.groupname'>
        </div>
        <div class='group-member-field'>
          <div ng-repeat='friend in checkFriend'>
            <div ng-switch='friend.flug'>
              <div class='group-member' ng-switch-when='true'>{{friend.name}}</div>
            </div>
          </div>
        </div>
        <div class='group-margin'></div><!--
     --><div class='group-button-field'><input class='group-save-button' type='button' value='保存' ng-click='save_group()'></div><!--
     --><div class='group-button-field'><input class='group-cancel-button' type='button' value='キャンセル' ng-click='cancel_group()'></div><!--
     --><div class='group-margin'></div>
      </div>
      <div class='status-not-selected' ng-switch-when='not-selected'>LIMEでトークしましょう！</div>
    </div>
  </div><div class='back-side'></div>
</div>
