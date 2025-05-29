<?php
session_start();
include 'database1.php'; // Make sure this connects to your signup_register DB

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "You must be logged in to become a seller.";
    exit();
}

// If the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $shop_name = trim($_POST['shop_name']);
    $user_id = $_SESSION['user_id'];

    // Check if this user is already a seller
    $check = $conn->prepare("SELECT * FROM seller WHERE user_id = ?");
    $check->bind_param("i", $user_id);
    $check->execute();
    $result = $check->get_result();

    if ($result->num_rows > 0) {
        echo "You are already registered as a seller.";
    } else {
        // Insert into seller table
        $stmt = $conn->prepare("INSERT INTO seller (user_id, shop_name) VALUES (?, ?)");
        $stmt->bind_param("is", $user_id, $shop_name);
        if ($stmt->execute()) {
            echo "Welcome, noble merchant! Your shop has been created successfully.";
        } else {
            echo "There was a problem. Please try again.";
        }
    }
}
?>

<!-- <h2>Register as a Seller</h2>
<form method="POST" action="">
    <label for="shop_name">Shop Name:</label>
    <input type="text" name="shop_name" required>
    <br><br>
    <button type="submit">Become a Seller</button>
</form> -->
<h2>Still being developed...</h2>

