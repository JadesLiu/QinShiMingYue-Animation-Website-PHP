
<?php

    //分页的函数
    function news($pageNum = 1, $pageSize = 3)
    {
        include 'DBConn.php';
        $array = array();
        // limit为约束显示多少条信息，后面有两个参数，第一个为从第几个开始，第二个为长度

        $rs = "select * from user limit " . (($pageNum - 1) * $pageSize) . "," . $pageSize;
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
        $rs = "select count(*) num from user"; //可以显示出总页数

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
if(($_SESSION['user'])!='admin'){
    header('Refresh:0.0001;url=login.php');
    echo "<script> alert('属于非法访问，你不是管理员admin！')</script>";
    exit();
}

include 'DBConn.php';
//根据所传参数有无id来判断是修改请求还是添加请求
if(isset($_POST["name"])&&isset($_POST["sex"])&&isset($_POST["country"])&&isset($_POST["pass"])&&isset($_POST["secret_1"])&&isset($_POST["secret_2"])&&isset($_POST["secret_3"])) {
    $name = $_POST["name"];
    $sex = $_POST["sex"];
    $country = $_POST["country"];
    $pass = md5($_POST["pass"]);
    $secret_1 = $_POST['secret_1'];
    $secret_2 = $_POST['secret_2'];
    $secret_3 = $_POST['secret_3'];
//有id则为修改
    if($_POST["id"]!=null){
        $id=$_POST["id"];
        $presql="select name from user where name='$name'";
        $preresult=mysqli_query($conn, $presql);
        if ($preresult->num_rows==1){
            echo  "<script>alert('用户名已存在，修改用户信息失败！')</script>";
        }else{
            $sqlupdate = "UPDATE user SET NAME='$name',sex='$sex',country='$country',password='$pass',secret_1='$secret_1',secret_1='$secret_2',secret_1='$secret_3' WHERE id=$id";
            if (mysqli_query($conn, $sqlupdate)) {
                echo "<script>alert('修改用户信息成功')</script>";
                header("Location: userController.php");    //刷新当前页面
                mysqli_close($conn);
            } else {
                echo "Error: " . $sqlupdate . "<br>" . mysqli_error($conn);
            }
        }
    }else{//添加
//先判断用户名是否已存在
        $presql="select name from user where name='$name'";
        $preresult=mysqli_query($conn, $presql);
        if ($preresult->num_rows==1){
            echo  "<script>alert('用户名已存在，请重新添加用户！')</script>";
        }else{//先在user中加入信息，再在表user_log中加入一条记录。
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
                echo  "<script>alert('添加新用户成功')</script>"; //这里不能关闭数据库
            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            }
        }


    }
}
//查询，返回全部结果
$sqlselect="SELECT id,name,sex,country from user";
$result=mysqli_query($conn, $sqlselect);

if($result->num_rows>0){

    echo "<h1>用户管理界面</h1>";

    echo "<div><h3>当前登录用户：".$_SESSION['user']."&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp";

    echo "<a class='btn' href='admin_journal.php'>查看日志</a>";

    echo "<a class='btn' href='login.php'>退出登录</a><h3></div>";

    echo "<div><a href='user_add.php'>添加用户</a></div><br>";

    echo "<table><tr><th>姓名</th><th>性别</th><th>国家</th><th>操作</th></tr>";


    foreach($array as $key=>$row){
        echo
            '<tr><td>'.$row->name.'</td>

            <td>'.$row->sex.'</td>
            
             <td>'.$row->country.'</td>
             <td>
             <a href="userController.php?id='.$row->id.'&func=delete">删除</a>'.' '.
            '<a href="user_add.php?id='.$row->id.'&func=update">修改</a>
             </td></tr>';
    }
    echo "</table>";
}else{
    echo "0个结果";
}

//删除业务，接受本页面传来的id参数，利用此参数删除对应记录，先删除三张表内的有关信息。
if(isset($_GET["id"])&&$_GET["func"]==delete){
    $id=$_GET["id"];
    $sqldelete='delete from time_ip where id='.$id;
    mysqli_query($conn, $sqldelete);
    $sqldelete='delete from user_log where id='.$id;
    mysqli_query($conn, $sqldelete);
    $sqldelete='delete from user where id='.$id;
    if (mysqli_query($conn, $sqldelete)) {
        echo "<script>alert('删除成功')</script>";
        mysqli_close($conn);
        header("Location: userController.php");    //刷新当前页面
    } else {
        echo "Error: " . $sqldelete . "<br>" . mysqli_error($conn);
    }
}


mysqli_close($conn);
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
	background: url(bg03.jpg);
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
