<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Refresh:0.0001;url=login.php');
    echo "<script> alert('用户非法访问！')</script>";
    exit();
}
include 'DBConn.php';
?>

<html>
<head>
    <meta charset="utf-8">
    <title>添加新商品</title>
</head>
<body>
<h1>新商品信息</h1>
<h3>当前登录用户：<?php echo $_SESSION['user']?></h3>
<div>
    <form method="post" action="shop.php" onSubmit="return check();">
        商品名：<input type="text" id="product_name" name="product_name"/><br/>
        产地：<input type="text" id="country" name="country"/><br/>
        价格：<input type="text" id="price" name="price"/><br/>
        类别：<input type="text" id="category" name="category"/><br/>

        <input type="hidden" id="id"  name="id" value=""/>
        <br>
        <input type="submit" value="提交" />
    </form>
</div>

<?php
if(isset($_GET["id"])&&$_GET["func"]=="update"){
    $id=$_GET["id"];
    $sqlSelectId="select * from moon_shop where id=".$id;
    $result=mysqli_query($conn, $sqlSelectId);
    $row=$result->fetch_assoc();
    $product_name=$row["product_name"];
    $country=$row["country"];
    $price=$row["price"];
    $category=$row["category"];
    //文本框内显示修改值
    echo "
        <script>
             document.getElementById('product_name').value='$product_name';
             document.getElementById('country').value='$country';
             document.getElementById('id').value=$id;
             document.getElementById('price').value=$price;
             document.getElementById('category').value='$category';
        </script>";

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