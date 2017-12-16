var app = angular.module('controller', ['ngRoute'])

// ルーティング
app.config(function($routeProvider){
    $routeProvider.
    when('/', {
        controller: 'LoginController',
        templateUrl: 'ng-views/Login.php',
    }).
    when('/signup',{
        controller: 'SignupController',
        templateUrl: 'ng-views/Signup.php',
    }).
    when('/main',{
        controller: 'MainController',
        templateUrl: 'ng-views/Main.php',
    }).
    otherwise({
        redirectTo: '/'
    });
});

// Login.phpのコントローラ
app.controller('LoginController', function($scope, $window, $location, Login){
  $scope.message = 'ニックネームを入力してください．';

  $scope.login = function(){
    Login.search($scope.UserData).success(function(data){
      if(data.success == true){
        $window.location.href = '/chat';
      }else{
        $scope.message = 'ニックネームが一致しません．';
      };
    });
  };
  $scope.signup = function(){
    $location.path('/signup');
  };
});

// Signup.phpのコントローラ
app.controller('SignupController', function($scope, $location, SignUp){
  $scope.message = 'ユーザ情報を入力してください．';

  $scope.send = function(){
    SignUp.search($scope.UserData).success(function(data){
      console.log(data)
      if(data.nickname != 0 && data.uniqueid != 0){
        $scope.message = '他のユーザとニックネーム,IDが重複しています．';
      }else if(data.nickname != 0){
        $scope.message = '他のユーザとニックネームが重複しています．';
      }else if(data.uniqueid != 0){
        $scope.message = '他のユーザとIDが重複しています．';
      }else{
        SignUp.save($scope.UserData).success(function(data){
          $location.path('/');
        });
      };
    });
  };
  $scope.back = function(){
    $location.path('/');
  };
});