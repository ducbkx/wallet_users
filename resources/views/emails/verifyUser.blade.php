<!DOCTYPE html>
<html>
<head>
    <title>Welcome Email</title>
</head>
 
<body>
<h2>Chào mừng {{$user['name']}} đến với trang web </h2>
<br/>
Email đăng ký của bạn là {{$user['email']}} , Vui lòng nhấp vào liên kết bên dưới để xác minh email của bạn
<br/>
<a href="{{url('user/verify', $user->token)}}">Xác nhận Email</a>
</body>
 
</html>