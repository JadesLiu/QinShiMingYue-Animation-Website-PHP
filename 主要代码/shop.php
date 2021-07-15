<?php

//分页的函数
function news($pageNum = 1, $pageSize = 3)
{
    include 'DBConn.php';
    $array = array();
    // limit为约束显示多少条信息，后面有两个参数，第一个为从第几个开始，第二个为长度

    $rs = "select * from moon_shop limit " . (($pageNum - 1) * $pageSize) . "," . $pageSize;
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
    $rs = "select count(*) num from moon_shop"; //可以显示出总页数

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

//根据所传参数有无id来判断是修改请求还是添加请求
if (isset($_POST["product_name"]) && isset($_POST["country"]) && isset($_POST["price"]) && isset($_POST["category"])) {
    $product_name = $_POST["product_name"];
    $country = $_POST["country"];
    $price = $_POST["price"];
    $category = $_POST["category"];
    if ($_POST["id"] != null) {//有id则为修改
        $id = $_POST["id"];
        $sqlupdate = "UPDATE moon_shop SET product_name='$product_name',country='$country',price ='$price ',category ='$category ' WHERE id=$id";
        if (mysqli_query($conn, $sqlupdate)) {
            $name=$_SESSION['user'];//记录用户修改操作
            $sql ="update user_log set update_count=update_count+1 where name ='$name'";
            mysqli_query($conn, $sql);
            echo "<script>alert('修改商品成功')</script>";
            header("Location: shop.php");    //刷新当前页面
            mysqli_close($conn);
        } else {
            echo "Error: " . $sqlupdate . "<br>" . mysqli_error($conn);
        }
    } else {//添加
        //先判断商品名是否已存在
        $presql="select name from user where name='$name'";
        $preresult=mysqli_query($conn, $presql);
        if ($preresult->num_rows==1){
            echo  "<script>alert('商品名已存在，请重新添加商品！')</script>";
        }else{
            $sql = "INSERT into moon_shop (product_name,country,price,category)
    VALUES ('$product_name','$country','$price','$category')";
            if (mysqli_query($conn, $sql)) {
                $name=$_SESSION['user'];//记录用户添加操作
                $sql ="update user_log set creat_count=creat_count+1 where name ='$name'";
                mysqli_query($conn, $sql);
                echo "<script>alert('添加新商品成功')</script>"; //这里不能关闭数据库
            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            }
        }

    }
}
//查询，返回全部结果
$sqlselect = "SELECT id,product_name,country,price,category from moon_shop";
$result = mysqli_query($conn, $sqlselect);

if ($result->num_rows > 0) {
    echo "<h1>欢迎来到秦时小铺！</h1>";
    echo "<div><h3>当前登录用户：" . $_SESSION['user'] . "&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp";
    echo "<a class='btn' href='journal.php'>查看日志</a>";
    echo "<a class='btn' href='login.php'>退出登录</a><h3></div>";
    echo "<div><a href='shop_add.php'>添加商品</a></div><br>";
    echo "<table><tr><th>商品名</th><th>产地</th><th>价格</th><th>类别</th><th>操作</th></tr>";
    foreach($array as $key=>$row) {
        echo '<tr><td>'.$row->product_name. '</td>
            <td>' . $row->country . '</td>
             <td>' . $row->price . '</td>
             <td>' . $row->category . '</td>
             <td>
             <a href="shop.php?id=' . $row->id . '&func=delete">删除</a>' . ' ' .
            '<a href="shop_add.php?id=' . $row->id . '&func=update">修改</a></td></tr>';
    }
    echo "</table>";
} else {
    echo "0个结果";
}
//删除业务，接受本页面传来的id参数，利用此参数删除对应记录
if (isset($_GET["id"]) && $_GET["func"] == delete) {
    $id = $_GET["id"];
    $sqldelete = 'delete from moon_shop where id=' . $id;
    if (mysqli_query($conn, $sqldelete)) {
        $name=$_SESSION['user'];//记录用户删除操作
        $sql ="update user_log set delete_count=delete_count+1 where name ='$name'";
        mysqli_query($conn, $sql);
        echo "<script>alert('删除成功')</script>";
        mysqli_close($conn);
        header("Location: shop.php");    //刷新当前页面
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
    body {
        text-align: center;
    }

    table {
        width: 600px;
        height: 300px;
        border: 1px solid black; /*设置边框粗细，实线，颜色*/
        text-align: center; /*文本居中*/
        background: url(bg04.png);
        border-collapse: collapse; /*边框重叠，否则你会看到双实线*/
        margin: auto;
    }

    th {
        border: 1px solid black;
        color: black;
        font-weight: bold; /*因为是标题栏，加粗显示*/
    }

    td {
        border: 1px solid black;
        color: #FF5722;
    }

    a {
        font-family: Arial;
        margin: 3px;
    }

    a:LINK, a:VISITED {
        color: #A62020;
        padding: 4px 10px 4px 10px;
        background-color: #DDD;
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

    h1 {
        background-color: #678;
        color: white;
        text-align: center;
    }

    div {
        text-align: center
    }

    .btn {
        border: none;
        color: red;
        font-family: Arial;
        padding: 10px 24px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 10px;
        margin: 4px 2px;
        cursor: pointer;
    }
</style>
