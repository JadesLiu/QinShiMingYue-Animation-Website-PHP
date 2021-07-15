<?php
include 'DBConn.php';

//判断验证码是否正确
if(isset($_REQUEST['checkcode'])){
    session_start();
    if(strtolower($_REQUEST['checkcode'])==$_SESSION['checkcode']){
    // 接收表单提交的用户名密码
        $user = $_POST['user'];
        $pass = md5($_POST['pass']);
    //从数据库查询用户名和密码
        $sqlsel="select id,name,password from user where name='$user' and password='$pass'";
        $result=mysqli_query($conn, $sqlsel);
        $row=$result->fetch_assoc();
        $id=$row["id"];
    // 先判断登录的用户与数据库是否匹配，若是，再判断是否为admin管理用户
        if($result->num_rows==1){
            if($user=="admin"){
                session_start();
                $_SESSION['user'] = $user;
                $ip_pre=$_SERVER['REMOTE_ADDR'];
                date_default_timezone_set('PRC');
                $t = date('Y-m-d H:i:s');
                $sql = "INSERT into time_ip(id,name,time,ip)VALUES ('$id','$user','$t','$ip_pre')";
                mysqli_query($conn, $sql);
                $sql ="update user_log set login_count=login_count+1 where name ='$user'";
                mysqli_query($conn, $sql);
                header("Refresh:0.0001;url=userController.php");
                echo "<script> alert('管理员admin，你好！')</script>";

                exit();
            }else {
                session_start();
                $_SESSION['user'] = $user;
                $ip_pre=$_SERVER['REMOTE_ADDR'];
                date_default_timezone_set('PRC');
                $t = date('Y-m-d H:i:s');
                $sql = "INSERT into time_ip(id,name,time,ip)VALUES ('$id','$user','$t','$ip_pre')";
                mysqli_query($conn, $sql);
                $sql ="update user_log set login_count=login_count+1 where name ='$user'";
                mysqli_query($conn, $sql);
                header("Refresh:0.0001;url=shop.php");
                echo "<script> alert('登录成功')</script>";
                exit();
            }
        }else{
            header("Refresh:0.0001;url=login.php");
            echo "<script> alert('登录失败')</script>";
            exit();
        }
    }else{
        header("Refresh:0.0001;url=login.php");
        echo "<script> alert('验证码错误，请重试！')</script>";
    }
    exit();
}


