<?php

include 'functions.php';

?>
<?php
session_start();
$_SESSION["us"] = "Khach";
if(isset($_SESSION["username"])){
    $_SESSION["us"] =  $_SESSION["username"];   
}
?> 

<?=template_header('Home',$_SESSION["us"])?>


    <div class = " content home">
        <h2>Trang chủ</h2><br>
        <h3>Chào mừng bạn đến với trang web của chúng tôi.</h3>
        <p>-Bạn có thể sử dụng các chức năng:</p> 
        <pre style = "font-family: Arial, Verdana, sans-serif; font-size: 16px">                  +Tham gia
                  +Tạo bình chọn
                  +Xem kết quả
                  +Xóa danh mục bình chọn</p><hr>
        
    </div>
    

<?=template_footer()?>
