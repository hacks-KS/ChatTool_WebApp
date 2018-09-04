<div class='box'>
  <div class='signup-font'>新規登録</div>
  <div class='input-div'><input class='input-name' type='text' placeholder='ニックネーム' ng-model='UserData.nickname'></div>
  <div class='input-div'><input class='input-pass' type='password' placeholder='パスワード' ng-model='UserData.password'></div>
  <div class='login-div'><input class='login' type='button' value='確定' ng-click='send()'></div>
  <div class='explain-message'>{{message}}</div>
  <div class='signup-div'><input class='signup' type='button' value='戻る' ng-click='back()'></div>
</div>
