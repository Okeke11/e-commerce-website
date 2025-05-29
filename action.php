<?php
session_start();
require 'database1.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if(isset($_POST['qty'])){
    $qty = $_POST['qty'];
    $pid = $_POST['pid'];
    $pprice = $_POST['pprice'];
    $tprice = $qty * $pprice;

    $stmt = $conn->prepare("UPDATE cart SET qty = ?, total_price = ? WHERE id = ?");
    $stmt->bind_param("idi", $qty, $tprice, $pid);
    $stmt->execute();

    echo "Cart updated successfully";
    exit(); // very important to stop further execution
}


if (!isset($_SESSION['email'])) {
    echo "<script>alert('You need to be logged in');</script>";
    exit();
}
if (isset($_GET['clear']) && $_GET['clear'] === 'all') {
    // Check if user_id exists in session
    if (!isset($_SESSION['user_id'])) {
        die("No user ID in session.");
    }
    $stmt = $conn->prepare("DELETE FROM cart WHERE user_id = ?");
    $stmt->bind_param("i", $_SESSION['user_id']);
    if ($stmt->execute()) {
        $_SESSION['showAlert'] = 'block';
        $_SESSION['message'] = 'All items removed from cart!';
        header('Location: cart.php');
        exit();
    } else {
        die("Query failed: " . $stmt->error);
    }
}
if (isset($_GET['remove'])) {
    $id = $_GET['remove'];
    $stmt = $conn->prepare("DELETE FROM cart WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    $_SESSION['showAlert'] = 'block';
    $_SESSION['message'] = 'Item removed from cart!';
    header('Location: cart.php');
    exit();
}
if (isset($_POST['pid'])) {
    $pid = $_POST['pid'];
    $pname = $_POST['pname'];
    $pprice = $_POST['pprice'];
    $pimage = $_POST['pimage'];
    $pcode = $_POST['pcode'];
    $pqty = 1;

    $user_id = $_SESSION['user_id'];
    $stmt = $conn->prepare("SELECT product_code FROM cart WHERE product_code = ? AND user_id = ?");
    $stmt->bind_param("si", $pcode, $user_id);
    $stmt->execute();
    $res = $stmt->get_result();
    $code = $res->fetch_assoc()['product_code'] ?? null;

    if (!$code) {
        $query = $conn->prepare("INSERT INTO cart (user_id, product_name, product_price, product_image, qty, total_price, product_code) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $query->bind_param("isssiss", $user_id, $pname, $pprice, $pimage, $pqty, $pprice, $pcode);

        if (!$query->execute()) {
            echo "<script>alert('Error: " . $query->error . "');</script>";
        } else {
            echo "<script>alert('Item Added To Your Cart');</script>";
        }
    } else {
        echo "<script>alert('Item Already Added To Your Cart');</script>";
    }
    exit(); // important to stop further execution
}
if (isset($_GET['cartCount'])) {
    $stmt = $conn->prepare("SELECT COUNT(*) AS count FROM cart WHERE user_id = ?");
    $stmt->bind_param("i", $_SESSION['user_id']);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    echo $count;
    exit();
}

if(isset($_POST['action']) && isset($_POST['action']) == 'order'){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $products = $_POST['products'];
    $grand_total = $_POST['grand_total'];
    $address = $_POST['address'];
    $pmode = $_POST['pmode'];

    $data = '';

    $stmt = $conn->prepare("INSERT INTO orders (name, email, phone, address,pmode, products,amount_paid)VALUES(?,?,?,?,?,?,?)");
    $stmt->bind_param("sssssss",$name,$email,$phone, $address, $pmode,$products,$grand_total);
    $stmt->execute();
    $data .= '<div>
                <h1> Thank You!</h1>
                <h2> Your Order Placed Successfully</h2>
                <h4>Items Purchased : '.$products.' </h4>
                <h4>Your Name : '.$name.'</h4>
                <h4>Your Email : '.$email.'</h4>
                <h4>Your Phone : '.$phone.'</h4>
                <h4>Total Amount Paid : '.number_format($grand_total,2).'</h4>
                <h4>Payment Mode : '.$pmode.'</h4>
                <br>
    <a href="products.php" style="display:inline-block; margin-top:20px; padding:10px 20px; background-color:black; color:white; text-decoration:none; border-radius:5px;">
        <i class="fas fa-arrow-left"></i> Back to Products
    </a>
            </div>';
            echo $data;
              // Check if user_id exists in session
    if (!isset($_SESSION['user_id'])) {
        die("No user ID in session.");
    }
    $stmt = $conn->prepare("DELETE FROM cart WHERE user_id = ?");
    $stmt->bind_param("i", $_SESSION['user_id']);
    if ($stmt->execute()) {
        exit();
    } else {
        die("Query failed: " . $stmt->error);
    }
            exit();
}


http_response_code(404);
echo "Invalid request.";
exit();
?>