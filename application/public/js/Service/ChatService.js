app = angular.module('ChatService', [])

// Chat.phpのhttp処理
app.factory('Chat', function($http) {
	return {
		send : function(SendData) {
			return $http({
				method: 'POST',
				url: '/api/chat/send',
				headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
				data: $.param(SendData)
			});
		},
		search : function(FriendData) {
			return $http({
				method: 'POST',
				url: '/api/chat',
				headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
				data: $.param(FriendData)
			});
		},
		add : function(FriendData) {
			return $http({
				method: 'POST',
				url: '/api/chat/add',
				headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
				data: $.param(FriendData)
			});
		},
		make_group : function(GroupData) {
			return $http({
				method: 'POST',
				url: '/api/chat/group',
				headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
				data: $.param(GroupData)
			});
		},
		room : function() {
			return $http({
				method: 'GET',
				url: '/api/chat/room',
				params: {}
			});
		},
		friend : function() {
			return $http({
				method: 'GET',
				url: '/api/chat/friend',
				params: {}
			});
		},
		group : function() {
			return $http({
				method: 'GET',
				url: '/api/chat/group',
				params: {}
			});
		},
		comments : function() {
			return $http({
				method: 'GET',
				url: '/api/chat/comment',
				params: {}
			});
		}
	};
});
