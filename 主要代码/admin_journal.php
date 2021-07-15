<?php
session_start();
if(($_SESSION['user'])!='admin'){
    header('Refresh:0.0001;url=login.php');
    echo "<script> alert('属于非法访问，你不是管理员admin！')</script>";
    exit();
}
include 'DBConn.php';

$sqlselect="SELECT name from user_log ORDER BY login_count DESC";
$result=mysqli_query($conn, $sqlselect);
$row=$result->fetch_assoc();
$max1=$row["name"];

$sqlselect="SELECT name from user_log ORDER BY creat_count DESC";
$result=mysqli_query($conn, $sqlselect);
$row=$result->fetch_assoc();
$max2=$row["name"];

$sqlselect="SELECT name from user_log ORDER BY delete_count DESC";
$result=mysqli_query($conn, $sqlselect);
$row=$result->fetch_assoc();
$max3=$row["name"];

$sqlselect="SELECT name from user_log ORDER BY update_count DESC";
$result=mysqli_query($conn, $sqlselect);
$row=$result->fetch_assoc();
$max4=$row["name"];

if($result->num_rows>0){

    echo "<h1>统计与分析</h1>";

    echo "<div><h3>当前登录用户：".$_SESSION['user']."&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp";

    echo "<a class='btn' href='login.php'>退出登录</a><h3></div>";

    echo "<div><a href='journal.php'>历史登录时间及IP记录页面</a></div><br>";

    echo "<table><tr><th>登录次数最多用户</th><th>添加次数最多用户</th><th>删除次数最多用户</th><th>更改次数最多用户</th></tr>";

    while($row=$result->fetch_assoc()){
        echo '<tr><td>'.$max1.'</td>
            <td>'.$max2.'</td>
             <td>'.$max3.'</td>
                <td>'.$max4.'</td>
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
