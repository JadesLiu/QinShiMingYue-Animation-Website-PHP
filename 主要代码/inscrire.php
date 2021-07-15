<?php
include 'DBConn.php';
?>
<html>
<head>
    <meta charset="utf-8">
    <title>注册新用户</title>
</head>
<body>
<h1>新用户注册</h1>

<div>
    <form method="post" action="inscrire.php" onSubmit="return check();">
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
        <a href="login.php">已注册好，返回登录页面</a>
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
if(isset($_POST["name"])&&isset($_POST["sex"])&&isset($_POST["country"])&&isset($_POST["pass"])&&isset($_POST["secret_1"])&&isset($_POST["secret_2"])&&isset($_POST["secret_3"])) {
    $name = $_POST["name"];
    $sex = $_POST["sex"];
    $country = $_POST["country"];
    $pass = md5($_POST["pass"]);
    $secret_1 = $_POST['secret_1'];
    $secret_2 = $_POST['secret_2'];
    $secret_3 = $_POST['secret_3'];
    //先判断用户名是否已存在
    $presql="select name from user where name='$name'";
    $preresult=mysqli_query($conn, $presql);
    if ($preresult->num_rows==1) {
        echo  "<script>alert('用户名已存在，请重新注册！')</script>";
    }else{
        $sql = "INSERT into user (name,sex,country,password,secret_1,secret_2,secret_3)
    VALUES ('$name','$sex','$country','$pass','$secret_1','$secret_2','$secret_3')";
        if (mysqli_query($conn, $sql)) {
            $presql="select id,name from user where name='$name'";
            $result=mysqli_query($conn, $presql);
            $row=$result->fetch_assoc();
            $id=$row["id"];
            $sql = "INSERT into user_log (id,name,login_count,creat_count,delete_count,update_count)
    VALUES ('$id','$name','0','0','0','0')";
            mysqli_query($conn, $sql);
            echo "<script>alert('新用户注册成功')</script>";
            mysqli_close($conn);
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
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
