<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        *{
background-color: antiquewhite;
        }
        button {
    background-color: black;
    border-width: 0px;
    border-radius: 5px;
    width: 90px;
    height: 35px;
    margin-left: 24px;
}
button a{
    color: aliceblue;
    text-decoration: none;
    background-color: black;
}
.logout_only{
margin-top: 200px;
margin-left: 540px;
}
    </style>
</head>
<body>
    
</body>
</html>
<div class="logout_only">
<h1>You are logged out</h1>
<button><a href="login.php">Login</a></button>
<button><a href="home.php">Home Page</a></button>
</div>
<?php
session_start();
// session_unset();
session_destroy(); // Destroy all session data
// header("Location: home.php"); 
exit();
?>
