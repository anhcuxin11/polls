<?php
session_start();
// Update the details below with your MySQL details
$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = '';
$DATABASE_NAME = 'phppoll';
$message = "";
try {
    $connect =  new PDO('mysql:host=' . $DATABASE_HOST . ';dbname=' . $DATABASE_NAME . ';charset=utf8', $DATABASE_USER, $DATABASE_PASS);
    $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    if(isset($_POST["login"])){
        if(empty($_POST["Username"]) || empty($_POST["Password"])){
            $message = '<label>Gía trị không được để trống</label>';
        }
        else{
            
            $query = "SELECT * FROM admin WHERE username = :username AND password = :password";
            $statement = $connect->prepare($query);
            $statement->execute(
                array(
                    'username' => $_POST["Username"],
                    'password' => $_POST["Password"]
                )
            );
            $count = $statement->rowCount();
            
            if($count > 0){
                $_SESSION["username"] = $_POST["Username"];
               
                $query1 = "SELECT * FROM admin WHERE username = ?";
                $stmt = $connect->prepare($query1);
                $stmt->execute([ $_POST["Username"] ]);
                $lv = $stmt->fetchAll(PDO::FETCH_ASSOC);              
                $_SESSION["permision"]=(string)$lv[0]['level'];

                header("location: index.php");
            }
            else{
                $message = '<label>Không có trong database</label>';
            }
        }
    }
} catch (PDOException $exception) {

    // If there is an error with the connection, stop the script and display the error.
    echo $exception;
    exit('Failed to connect to database!');
}

?>

<!DOCTYPE html>
<html lang = "en">
    
<head>
    <meta charset = "UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="style1.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
    <title>Đăng nhập</title>
    
</head>

<body style = "background-color: #38b673;">
    <div style = "text-align: center; font-size: x-large;">
    <?php
        if(isset($message)){
            echo $message;
        }
    ?>
    </div>
	<div class="login">
        <form method = "post"> 
            <h2>Login</h2>
            <div class="enter">
                <img src="user.PNG">
                <input type="text" name='Username' placeholder="username">
            </div>
            <div class="enter">
                <img src="pass.PNG">
                <input type="password" name='Password' placeholder="password">
            </div>
                    
            <input type="submit" name = "login" value='Đăng nhập' class = "submit" />
        </form>
	</div>
</body>

</html>