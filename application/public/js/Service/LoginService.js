app = angular.module('LoginService', [])

// Login.phpのhttp処理
app.factory('Login', function($http) {
	return {
		search : function(UserData) {
			return $http({
				method: 'POST',
				url: '/api/login',
				headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
				data: $.param(UserData)
			});
		}
	};
});

// Signup.phpのhttp処理
app.factory('SignUp', function($http) {
	return {
		save : function(UserData) {
			return $http({
				method: 'POST',
				url: '/api/signup/save',
				headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
				data: $.param(UserData)
			});
		}
	};
});
