 <?php
$hostName = "localhost";
$dbUser = "root";
$dbPassword = "";
$dbName = "signup_register";

// Create connection
$conn = mysqli_connect($hostName, $dbUser, $dbPassword, $dbName);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
} else {
    // Connection successful, uncomment for debugging:
    // echo "Connected successfully to the database";
}
?>