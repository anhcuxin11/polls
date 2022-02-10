<?php

function pdo_connect_mysql() {
    // Update the details below with your MySQL details
    $DATABASE_HOST = 'localhost';
    $DATABASE_USER = 'root';
    $DATABASE_PASS = '';
    $DATABASE_NAME = 'phppoll';
    try {
    	return new PDO('mysql:host=' . $DATABASE_HOST . ';dbname=' . $DATABASE_NAME . ';charset=utf8', $DATABASE_USER, $DATABASE_PASS);
        echo "Connected successfully";
    } catch (PDOException $exception) {
    	// If there is an error with the connection, stop the script and display the error.
    	exit('Failed to connect to database!');
    }
}

function template_header($title,$us) {
$dn = '';
if($us=='Khach'){
    $dn = 'Login';
}else{
    $dn = 'Logout';
}
    
echo <<< EOT
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="utf-8">
        <title>$title</title>
        <link href="style1.css" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
           
    </head>
    <body>       
        <div class="head1 row" >
            <div class="column side">
                <h1>Hệ thống bình chọn sinh viên</h1>
            </div>
            <div class="column side2" style = " text-align: right">
                <h2>$us</h2>
            </div>
            <div class="column side2" style = " text-align: left">
                <h2><a href = "login.php" > $dn </a></h2>
            </div>
        </div>

        <ul>
            <li><a class="active" href="index.php"><i class="fas fa-home fa-xs"></i></a></li>
    EOT;
    if($us != 'Khach'){
        echo <<< EOT
        <li><a href="polls.php">Bình chọn</a></li>
        <li><a href="create.php">Tạo mới</a></li>
        EOT;
    }
    echo <<< EOT
        </ul>   
        <div class="row " >
            <div class="column sideb1" style = "border-right: 1px groove;border-bottom: 1px groove;">
                <div class="pleft"></div>
            </div>
            <div class="column sideb2">
    EOT;
}
// Template footer
function template_footer() {
    // DO NOT INDENT THE PHP CODE
echo <<<EOT
            </div>
            <div class="column sideb1" style = "border-left: 1px groove;border-bottom: 1px groove;">
                <div class="pright"></div>
            </div>
        </div>
    </body>
    </html>
    EOT;
    }
  
?>