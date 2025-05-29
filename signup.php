<?php
session_start(); // Start the session
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign-up</title>
    <link rel="stylesheet" href="signup.css">
  
</head>
<body>


    <div class = "signup">
    <h1>Sign up</h1>

    <form action="signup.php" method ="POST">
    <div>
        Firstname:<input class="fname" type="text" name= "fname" required>
        </div><br>
        <div>
        Lastname:<input class="lname" type="text" name= "lname" required>
        </div><br>
        <div>
    Email:<input class="email" type="email" name ="email" required>
    </div><br>
        <div>
        Password:<input class="password" type = "password" name = "password" required>
        </div><br>
        <div>
        Confirm Password:<input class="confirm_password" type = "password" name = "confirm_password" required> <br>
        </div>
        <div>
         <button class="submit" type="submit" name="submit">Sign up</button>
</div>
</form>
<?php
  if (isset($_POST["submit"])) {
$fname = $_POST["fname"];
$lname = $_POST["lname"];
$email = $_POST["email"];
$password = $_POST["password"];
$confirm_password = $_POST["confirm_password"];
$password_hash = password_hash($password, PASSWORD_DEFAULT);
$errors = array();
if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
    array_push($errors,"Email is not valid");
}
if(strlen($password) < 8){
array_push($errors, "Password must be at least 8 characters long");
  }
  if($password != $confirm_password){
    array_push($errors,"Passwords do not match");
  }
  require_once "database1.php";
  $sql = "SELECT * FROM users WHERE email = '$email'";
  $result = mysqli_query($conn,$sql);
  $rowcount = mysqli_num_rows($result);
  if($rowcount > 0){
    array_push($errors,"Email already exists!");
  }
  if(count($errors) > 0){
    foreach($errors as $error){
        echo "<div class='alert alert-danger'>$error</div>";
  }
}else{

$sql = "INSERT INTO users (fname, lname, email , password)VALUES (?, ?, ?, ?)";
$stmt = mysqli_stmt_init($conn);
$preparestmt = mysqli_stmt_prepare($stmt,$sql);
if ($preparestmt){
    mysqli_stmt_bind_param($stmt,"ssss",$fname,$lname,$email,$password_hash);
    mysqli_stmt_execute($stmt);
    echo"<div class = 'alert alert-success'>You are registered successfully  </div>";
}else{
    die("Something went wrong!");
}
}
  }
    ?>
    <p>Already have an account? <a href="login.php">Login here</a></p>
    </div>
</body>
</html>