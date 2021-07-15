<?php
include 'DBConn.php';
// 接收表单提交的用户名和密保
$name = $_POST['name'];
$secret_1 = $_POST['secret_1'];
$secret_2 = $_POST['secret_2'];
$secret_3 = $_POST['secret_3'];
$pwd=md5($_POST['pass']);

//从数据库查询用户名和密保
$sqlsel="select name,secret_1,secret_2,secret_3 from user where name='$name' and secret_1 ='$secret_1' and secret_2='$secret_2' and secret_3='$secret_3'";
$result=mysqli_query($conn, $sqlsel);
if($result->num_rows==1){
    if($name=="admin"){
        echo "<script> alert('不可以找回admin的密码！')</script>";
        header("Refresh:0.0001;url=login.php");
    }else{
        $sql="update user set password='$pwd' where name='$name'";
        if (mysqli_query($conn, $sql)) {

            echo "<script> alert('修改成功，请登录。')</script>";
            header("Refresh:0.0001;url=login.php");
            exit();
        }
    }
}else{
    header("Refresh:0.0001;url=login.php");
    echo "<script> alert('用户名不存在或密保错误！')</script>";
    exit();
}

