app = angular.module('service', [])

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
		search : function(UserData) {
			console.log($.param(UserData))
			return $http({
				method: 'POST',
				url: '/api/signup/search',
				headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
				data: $.param(UserData)
			});
		},
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
