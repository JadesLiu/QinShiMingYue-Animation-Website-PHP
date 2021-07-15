<?php

//分页的函数
function news($pageNum = 1, $pageSize = 3)
{
    include 'DBConn.php';
    $array = array();
    // limit为约束显示多少条信息，后面有两个参数，第一个为从第几个开始，第二个为长度

    session_start();
    $name=$_SESSION['user'];
    $rs = "select * from time_ip where name='$name'limit " . (($pageNum - 1) * $pageSize) . "," . $pageSize;
    $r = mysqli_query($conn, $rs);

    while ($obj = mysqli_fetch_object($r)) {
        $array[] = $obj;
    }
    mysqli_close($conn);

    return $array;

}

//显示总页数的函数

function allNews()
{

    include 'DBConn.php';
    session_start();
    $name=$_SESSION['user'];
    $rs = "select count(*) num from time_ip where name='$name'"; //可以显示出总页数

    $r = mysqli_query($conn, $rs);

    $obj = mysqli_fetch_object($r);

    mysqli_close($conn);

    return $obj->num;

}

@$allNum = allNews();

@$pageSize = 3; //约定每页显示几条信息

@$pageNum = empty($_GET["pageNum"])?1:$_GET["pageNum"];

@$endPage = ceil($allNum/$pageSize); //总页数

@$array = news($pageNum,$pageSize);

?>
<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Refresh:0.0001;url=login.php');
    echo "<script> alert('用户非法访问！')</script>";
    exit();
}
include 'DBConn.php';

$name=$_SESSION['user'];
$sqlselect="SELECT id,name,time,ip from time_ip where name='$name'";
$result=mysqli_query($conn, $sqlselect);

if($result->num_rows>0){

    echo "<h1>历史登录时间及IP记录</h1>";

    echo "<div><h3>当前登录用户：".$_SESSION['user']."&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp";

    echo "<a class='btn' href='login.php'>退出登录</a><h3></div>";

    echo "<div><a href='shop.php'>返回秦时小铺</a></div><br>";
    echo "<div><a href='journal_count.php'>查看登录及增删改操作记录次数界面</a></div><br>";

    echo "<table><tr><th>时间</th><th>IP</th></tr>";

    foreach($array as $key=>$row){
        echo
            '<tr><td>'.$row->time.'</td>

            <td>'.$row->IP.'</td>
            
             </td></tr>';
    }
    echo "</table>";
}else{
    echo "0个结果";
}
?>

<p>

    <a href="?pageNum=1">首页</a>

    <a href="?pageNum=<?php echo $pageNum==1?1:($pageNum-1)?>">上一页</a>

    <a href="?pageNum=<?php echo $pageNum==$endPage?$endPage:($pageNum+1)?>">下一页</a>

    <a href="?pageNum=<?php echo $endPage?>">尾页</a>
</p>


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
