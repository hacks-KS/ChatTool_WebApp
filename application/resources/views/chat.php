<!DOCTYPE html>
<html ng-app = 'ChatApp'>
<head>
  <script src="//ajax.googleapis.com/ajax/libs/angularjs/1.4.6/angular.min.js"></script>
  <script src="//ajax.googleapis.com/ajax/libs/angularjs/1.4.6/angular-route.min.js"></script>
  <script src="//ajax.googleapis.com/ajax/libs/angularjs/1.4.6/angular-cookies.min.js"></script>

  <script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
  <link rel="stylesheet" type="text/css" href="css/chat.css">

  <script src="js/Controller/ChatController.js"></script>
  <script src="js/Service/ChatService.js"></script>
  <script src="js/ChatApp.js"></script>
</head>
<body>
  <div class='init' ng-view></div>
</body>
</html>
