<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Refresh:0.0001;url=login.php');
    echo "<script> alert('用户非法访问！')</script>";
    exit();
}
include 'DBConn.php';

$name=$_SESSION['user'];
$sqlselect="SELECT login_count,creat_count,delete_count,update_count from user_log where name='$name'";
$result=mysqli_query($conn, $sqlselect);

if($result->num_rows>0){

    echo "<h1>登录及增删改操作次数记录</h1>";

    echo "<div><h3>当前登录用户：".$_SESSION['user']."&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp";

    echo "<a class='btn' href='login.php'>退出登录</a><h3></div>";

    echo "<div><a href='shop.php'>返回秦时小铺</a></div><br>";
    echo "<div><a href='journal.php'>返回历史登录时间及IP记录页面</a></div><br>";

    echo "<table><tr><th>登录次数</th><th>添加次数</th><th>删除次数</th><th>更改次数</th></tr>";

    while($row=$result->fetch_assoc()){
        echo '<tr><td>'.(int)$row["login_count"].'</td>
            <td>'.(int)$row["creat_count"].'</td>
             <td>'.(int)$row["delete_count"].'</td>
                <td>'.(int)$row["update_count"].'</td>
                </tr>';
    }
    echo "</table>";
}else{
    echo "0个结果";
}
?>
<style type="text/css">
    body{text-align: center;}
    table{
        width:600px;height:300px;
        border:1px solid black;/*设置边框粗细，实线，颜色*/
        text-align:center;/*文本居中*/
        background: url(bg02.jpg);
        border-collapse: collapse;/*边框重叠，否则你会看到双实线*/
        margin: auto;
    }
    th{
        border:1px solid black;
        color:black;
        font-weight:bold;/*因为是标题栏，加粗显示*/
    }
    td{
        border:1px solid black;
        color:#FF5722;
    }
    a{
        font-family: Arial;
        margin: 3px;
    }

    a:LINK,a:VISITED {
        color:#A62020;
        padding:4px 10px 4px 10px;
        background-color:#DDD;
        text-decoration: none;
        border-top: 1px solid #EEEEEE;
        border-left: 1px solid #EEEEEE;
        border-bottom: 1px solid #717171;
        border-right: 1px solid #717171;
    }

    a:HOVER {
        color: #821818;
        padding: 5px 8px 3px 12px;
        background-color: #CCC;
        border-top: 1px solid #717171;
        border-left: 1px solid #717171;
        border-bottom: 1px solid #EEEEEE;
        border-right: 1px solid #EEEEEE;
    }
    h1{
        background-color:#678;
        color:white;
        text-align:center;
    }
    div{
        text-align:center
    }
    .btn {
        border: none;
        color: red;
        font-family:Arial;
        padding: 10px 24px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 10px;
        margin: 4px 2px;
        cursor: pointer;
    }
</style>
