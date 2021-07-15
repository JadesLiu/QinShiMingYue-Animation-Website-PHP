<?php
session_start();// 必须在php的最开始部分声明，来开启session

// 使用gd的imagecreatetruecolor();创建一张背景图
$image = imagecreatetruecolor(100,40);

// 生成填充色
$bgcolor = imagecolorallocate($image,255,255,255);
// 将填充色填充到背景图上
imagefill($image,0,0,$bgcolor);

//////// 生成随机4位字母以及数字混合的验证码
$checkcode='';
for($i=0;$i<4;$i++){
    $fontsize = rand(6,8);
    $fontcolor = imagecolorallocate($image,rand(0,255),rand(0,255),rand(0,255));
    // 为了避免用户难于辨认，去掉了某些有歧义的字母和数字
    $rawstr = 'abcdefghjkmnopqrstuvwxyz23456789';
    $fontcontent = substr($rawstr,rand(0,strlen($rawstr)),1);
    // 拼接即将诞生的验证码
    $checkcode.=$fontcontent;
    // 避免生成的图片重叠
    $x += 20;
    $y = rand(10,20);
    imagestring($image,$fontsize,$x,$y,$fontcontent,$fontcolor);
}
// 保存到session变量中
$_SESSION['checkcode']=$checkcode;

// 生成一些干扰的点，这里是200个
for($i=0;$i<200;$i++){
    $pointcolor = imagecolorallocate($image,rand(50,255),rand(50,255),rand(50,255));
    imagesetpixel($image,rand(0,100),rand(0,30),$pointcolor);
}
// 生成一些干扰线 这里是4个
for($i=0;$i<4;$i++){
    // 设置为浅色的线，防止喧宾夺主
    $linecolor = imagecolorallocate($image,rand(50,255),rand(50,255),rand(50,255));
    imageline($image,rand(0,99),rand(0,29),rand(0,99),rand(0,29),$linecolor);

}


header('content-type:image/png');

imagepng($image);

// 释放资源，销毁执行对象
imagedestroy($image);