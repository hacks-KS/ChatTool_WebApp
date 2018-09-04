var app = angular.module('LoginController', ['ngRoute'])

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
      }else if(data.success == 'name_false'){
        $scope.message = 'ニックネームが一致しません．';
      }else{
        $scope.message = 'パスワードが一致しません．';
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
    SignUp.save($scope.UserData).success(function(data){
      if(data.success == true){
        $location.path('/');
      }else{
        $scope.message = 'ニックネームが他のユーザと重複しています．';
      };
    });
  };
  $scope.back = function(){
    $location.path('/');
  };
});
