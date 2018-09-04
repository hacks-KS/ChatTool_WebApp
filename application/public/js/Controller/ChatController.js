var app = angular.module('ChatController', ['ngRoute'])

// ルーティング
app.config(function($routeProvider){
    $routeProvider.
    when('/', {
        controller: 'ChatController',
        templateUrl: 'ng-views/Chat.php',
    }).
    otherwise({
        redirectTo: '/'
    });
});

// ng-repeatの終了検知
app.directive('onFinishRender', function ($timeout) {
  return {
    restrict: 'A',
    link: function (scope, element, attr) {
      if (scope.$last === true) {
        $timeout(function () {
          scope.$emit(attr.onFinishRender);
        });
      }
    }
  }
});

// Login.phpのコントローラ
app.controller('ChatController', function($scope, $location, $anchorScroll, $interval, Chat){
  $interval(function(){
    Chat.comments().success(function(data){
      all_comments = data['chat_info'];
      if($scope.selected_group != ''){
        for (let comment_info of all_comments){
          if (comment_info['id'] == $scope.selected_group['id']){
            $scope.comment_list = comment_info['comment'];
          }
        }
      }
    });
    Chat.room().success(function(data){
      $scope.rooms = data['group_info'];
    });
    Chat.group().success(function(data){
      $scope.groups = data['group_info'];
    });
    Chat.friend().success(function(data){
      $scope.friends = data['group_info'];
    });
  }, 3000);

  Chat.comments().success(function(data){
    all_comments = data['chat_info'];
  });

  Chat.room().success(function(data){
    $scope.rooms = data['group_info'];
  });
  Chat.group().success(function(data){
    $scope.groups = data['group_info'];
  });
  Chat.friend().success(function(data){
    $scope.friends = data['group_info'];
  });

  $scope.comment_list = [];
  $scope.statusL = 'all';
  $scope.statusR = 'not-selected'
  $scope.searchRes = 'normal';
  $scope.selected_group = '';
  $scope.user_id = '';
  $scope.groupname = '';
  $scope.rooms = [];
  $scope.friends = [];
  $scope.groups = [];
  $scope.Friend = {};
  $scope.AddFriend = {};
  $scope.checkFriend = [];

  // status-group
  $scope.make_group = function(){
    $scope.statusL = 'make-group';
    $scope.statusR = 'make-group';
    Chat.friend().success(function(data){
      for(let friend of data['group_info']){
        $scope.checkFriend.push({'name': friend['groupname'], 'flug': false});
      }
    });
  }

  // status-make-group
  $scope.save_group = function(){
    if($scope.groupname != ''){
      group_member = []
      for(let friend of $scope.checkFriend){
        if(friend.flug == true){
          group_member.push(friend.name);
        }
      }
      Chat.make_group({'group_name': $scope.groupname, 'group_member': group_member}).success(function(data){
        $scope.statusL = 'all';
        $scope.statusR = 'display-comment';
      });
    }
  }

  // status-add
  $scope.search = function(e){
    if (e.which == 13) {
      Chat.search($scope.Friend).success(function(data){
        if (data.success == true){
          $scope.searchRes = 'true';
          $scope.AddFriend.nickname = $scope.Friend.nickname;
          $scope.Friend.nickname = '';
        }else{
          $scope.searchRes = 'false';
          $scope.Friend.nickname = '';
        }
      });
    }
  }

  $scope.add = function(){
    Chat.add($scope.AddFriend).success(function(data){
      $scope.searchRes = 'added';
    });
  }

  //status-display-comment
  $scope.comment = function(all_info){
    $scope.selected_group = all_info;
    $scope.statusR = 'display-comment';
    for(let comment_info of all_comments){
      if(comment_info['id'] == all_info['id']){
        $scope.comment_list = comment_info['comment'];
      }
    }
  }

  $scope.send = function(e){
    if (e.which == 13) {
      $scope.comment_list.push({'user': 0, 'text': $scope.Message.text});
      Chat.send({'group_id': $scope.selected_group['id'], 'text': $scope.Message.text}).success(function(data){
        Chat.comments({nickname: $scope.selected_group}).success(function(data){
        });
      });
      $scope.Message.text = '';
    }
  }

  // select mode
  $scope.change_all = function(){
    $scope.statusL = 'all';
  }

  $scope.change_friend = function(){
    $scope.statusL = 'friend';
  }

  $scope.change_group = function(){
    $scope.statusL = 'group';
  }

  $scope.change_add = function(){
    $scope.statusL = 'add';
    $scope.searchRes = 'normal';
    $scope.AddFriend.nickname = '';
  }

  //link last_element
  $scope.$on('ngRepeatFinished', function(ngRepeatFinishedEvent) {
    $location.hash('last_element');
    $anchorScroll();
  });

});
