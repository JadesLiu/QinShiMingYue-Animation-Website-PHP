<?php
include 'DBConn.php';
?>

<html>
<head>
    <meta charset="utf-8">
    <title>找回密码</title>
</head>
<body>
<h1>找回密码</h1>

<div>
    <form method="post" action="find_pwd_check.php" onSubmit="return check();">
        请输入需要找回密码的用户名：<input type="text" id="name" name="name"/><br/>
        （密保问题1）你的手机号是：<input type="text" id="secret" name="secret_1"/><br/>
        （密保问题2）你最好的朋友是：<input type="text" id="secret" name="secret_2"/><br/>
        （密保问题3）若你进入秦时明月并成为其中的一员，你想为自己取的名字是：
        <input type="text" id="secret" name="secret_3"/><br/>
        修改登录密码：<input type="password" id="pass" name="pass"/><br/>
        确认修改密码：<input type="password" id="pass2" name="pass2"/><br/>
        <br>
        <input type="submit" value="提交" />
    </form>
</div>

<script type="text/javascript">
    function check(){
        var pass=document.getElementById('pass').value;
        var pass2=document.getElementById('pass2').value;
        if(pass==pass2){
            return true;
        }else{
            alert("两次密码不一致");
            document.getElementById('pass').value="";
            document.getElementById('pass2').value="";
            return false;
        }
    }
</script>


<style type="text/css">
    h1{
        background-color:#678;
        color:white;
        text-align:center;
    }
    body {
        height: 100%;
        width: 100%;
        border: none;
        overflow-x: hidden;
    }
    div{
        width:100%;
        text-align:center;
    }

</style>
</body>
</html>