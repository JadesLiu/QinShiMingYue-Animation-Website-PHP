<?php
session_start();
if(($_SESSION['user'])!='admin'){
    header('Refresh:0.0001;url=login.php');
    echo "<script> alert('属于非法访问，你不是管理员admin！')</script>";
    exit();
}
include 'DBConn.php'; ?>
<html>
<head>
    <meta charset="utf-8">
    <title>添加新用户</title>
</head>
<body>
<h1>新用户信息</h1>
<h3>当前登录用户：<?php echo $_SESSION['user']?></h3>
<div>
    <form method="post" action="userController.php" onSubmit="return check();">
        姓名：<input type="text" id="name" name="name"/><br/>
        性别：
        男<input type="radio" id="male" name="sex" value="male"/>
        女<input type="radio" id="female" name="sex" value="female"/>
        <br/>
        国家：<input type="text" id="country" name="country"/><br/>
        登录密码：<input type="password" id="pass" name="pass"/><br/>
        确认密码：<input type="password" id="pass2" name="pass2"/><br/>
        （密保问题1）你的手机号是：<input type="text" id="secret" name="secret_1"/><br/>
        （密保问题2）你最好的朋友是：<input type="text" id="secret" name="secret_2"/><br/>
        （密保问题3）若你进入秦时明月并成为其中的一员，你想为自己取的名字是：
        <input type="text" id="secret" name="secret_3"/><br/>

        <input type="hidden" id="id"  name="id" value=""/>
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
<?php
if(isset($_GET["id"])&&$_GET["func"]=="update"){
    $id=$_GET["id"];
    $sqlSelectId="select * from user where id=".$id;
    $result=mysqli_query($conn, $sqlSelectId);
    $row=$result->fetch_assoc();
    $name=$row["name"];
    $sex=$row["sex"];
    $country=$row["country"];
    $pass=$row["password"];
    $secret_1 = $row['secret_1'];
    $secret_2 = $row['secret_2'];
    $secret_3 = $row['secret_3'];
    echo "
        <script>
             document.getElementById('name').value='$name';
             document.getElementById('country').value='$country';
             document.getElementById('id').value=$id;
             document.getElementById('secret_1').value=$secret_1;
             document.getElementById('secret_2').value=$secret_2;
             document.getElementById('secret_3').value=$secret_3;
             document.getElementById('pass').value=$pass;
             document.getElementById('pass2').value=$pass;
        </script>";

    if($sex=='male'){
        echo "
        <script>
             document.getElementById('male').checked=true;
        </script>";
    }else{
        echo "
        <script>
             document.getElementById('female').checked=true;
        </script>";
    }

}
?>
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