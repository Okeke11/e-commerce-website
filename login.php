<?php 
session_start(); // Start the session

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <div class="login">
    <h2>LOGIN</h2>
    <form action="login.php" method="POST">
        <div>
            Email: <input class="email" type="email" name="email" required>
        </div><br>
        <div>
            Password: <input class="password" type="password" name="password" required>
        </div>  
        <div>
            <button class="submit" type="submit" name="submit">Login</button>
        </div>
    </form>

    <?php
    if (isset($_POST["submit"])) {
        $email = $_POST["email"];
        $password = $_POST["password"];
        include "database1.php";

        $sql = "SELECT * FROM users WHERE email = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $user = mysqli_fetch_assoc($result);

        if ($user) {
            if (password_verify($password, $user["password"])) {
                $_SESSION['email'] = $user['email']; // ✅ Store email in session
                $_SESSION['user_id'] = $user['id']; // ✅ Store user_id in session
                header("Location: home.php"); // Redirect to home
                exit();
            } else {
                echo "<div class='alert alert-danger'>Password does not match</div>";
            }
        } else {
            echo "<div class='alert alert-danger'>Email does not exist</div>";
        }
    }
    ?>
    <p>Do not have an account? <a href="signup.php">Sign up</a></p>
    </div>
</body>
</html>
