<?php
//连接数据库
$servername = "localhost";
$username = "root";
$password = "123456";
$conn = mysqli_connect($servername, $username, $password);
//判断数据库连接是否成功
if(!$conn){
    echo "fail";
}
//设置字符集
$charset="utf8";
mysqli_set_charset($conn,$charset);
//选择数据库
$dbname = "studb";
mysqli_select_db($conn,$dbname);



