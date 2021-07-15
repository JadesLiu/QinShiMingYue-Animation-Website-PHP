<?php
session_start();

if(isset($_SESSION)){
    session_start();
//  这种方法是将原来注册的某个变量销毁
    unset($_SESSION['admin']);
//  这种方法是销毁整个 Session 文件
    session_destroy();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>登录</title>
    <link rel="stylesheet" href="SignUpStyle.css">
    <link href="https://fonts.googleapis.com/css?familymPermanent+Marker" >
    <script>
        function change(){
            document.getElementById("image_checkcode").src='captcha_login.php?r='+Math.random();
        }
    </script>
    <style type="text/css">
        body{
            background-image: url("bg02.jpg");
        }
    </style>

</head>
<body>
<div class="sign-div">
    <form class="" action="check.php" method="post">
        <h1>秦迷登录</h1>
        <input type="text" name="checkcode" placeholder="请输入验证码"/><br />
        <img id="image_checkcode" src="captcha_login.php?r=<?php echo rand();?>"  />
        <a href="javascript:void(0)" onclick="change()">换一张</a><br/>
        <input class="sign-text" type="text" name="user" placeholder="用户名" >
        <input class="sign-text" type="password" name="pass" placeholder="密码">
        <a href="find_pwd_login.php">忘记密码</a>
        <h3>欢迎来到 秦时明月粉丝之家</h3>
        <input type="submit" value="登录"/>

    </form>
        <a href="inscrire.php">新用户注册</a>

</div>
</body>
</html>
