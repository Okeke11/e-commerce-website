<?php
session_start(); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link rel="stylesheet" href="assets/icons/css/all.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        .navbar {
    background: rgb(53, 56, 50);
    padding-right: 15px;
    padding-left: 15px;
}
.navdiv {
    display: flex;
    justify-content: space-between;
}
.logo {
    margin-top: 2px;
    font-size: 35px;
    font-weight: 700;
}
.logo a {
    color: aliceblue;
    text-decoration: none;
    font-size: 55px;
}
li {
    list-style: none;
    display: inline;
    margin-right: 30px;
    transition: 2s;
}
li:hover {
    background-color: black;
    transition: 0.3s;
    padding-top: 10px;
    padding-bottom: 10px;
    padding-left: 10px;
    padding-right: 10px;
    border-radius: 7px;
}
li a {
    color: aliceblue;
    text-decoration: none;
}
button {
    background-color: black;
    border-width: 0px;
    border-radius: 5px;
    width: 90px;
    height: 35px;
    margin-right: 10px;
    color: white;
}
.nav_email{
margin-left: 2px;
margin-right: 10px;
color: antiquewhite;
}
button:hover {
    background-color: rgb(80, 80, 80);
    color: rgb(201, 191, 191);
    transition: 0.4s;
}
button a {
    color: aliceblue;
    text-decoration: none;
}
.badge {
    background-color: red;
    color: white;
    padding: 3px 5px;
    padding-left: 3px; 
    padding-right: 4px;
    border-radius: 50%;
    font-weight: bold;  
}
.inputs{
    padding: 2px;
}
.form-group{
    padding: 2px;
    margin: 2px;
}
.form-control{
    padding: 5px;
    margin-top: 2px;
    border-radius: 5px;
    width: 300px;
}
#order{
    text-align: center;
}
    </style>
</head>
<body>
<?php

require 'database1.php';

$grand_total = 0;
$allItems = '';
$items = array();

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "<p>You must be logged in to proceed to checkout. <a href='login.php'>Login here</a>.</p>";
    exit();
}

$user_id = $_SESSION['user_id']; // Get logged-in user ID

$sql = "SELECT CONCAT(product_name, '(',qty,')') AS ItemQty, total_price FROM cart WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $grand_total += $row['total_price'];
    $items[] = $row['ItemQty'];
}

$allItems = implode(', ', $items);


?>
<nav class="navbar">
        <div class="navdiv">
            <div class="logo"><a href="#">Code</a></div>
            <ul>
                <li><a href="home.php"><i class="fas fa-home"></i> Home</a></li>
                <li><a href="products.php"><i class="fas fa-box-open"></i> Products</a></li>
                <li><a href="cart.php"> <i class="fas fa-shopping-cart"></i> Cart &nbsp;<span id="cart-item" class="badge"></span></a></li>
                <!-- <li><a href="checkout.php"><i class="fas fa-credit-card"></i> Checkout</a></li> -->

                <?php if (isset($_SESSION['email'])): ?>
                    <!-- If user is logged in, show email and logout -->
                    <P style="display: inline;" class="nav_email"><strong><?php echo htmlspecialchars($_SESSION['email']); ?></strong></P>&nbsp;&nbsp;&nbsp;
                    <button><a href="logout.php">Logout</a></button>
                <?php else: ?>
                    <!-- If user is NOT logged in, show login & signup buttons -->
                    <button><a href="login.php">SignIn</a></button>
                    <button><a href="signup.php">SignUp</a></button>
                <?php endif; ?>
            </ul> 
        </div>
    </nav>
<div class="container">
    <div class="row">
        <div id="order">
            <h2 style="background-color:rgb(154, 128, 128);">Complete your order!</h2>
            <div class="jumbotron">
                <h4><b>Products(s) : </b><?= $allItems; ?></h4>
                <h4><b>Delivery Charge : </b>Free</h4>
                <h4><b>Amount Payable : </b><?= number_format($grand_total,2) ?></h4>
            </div>
            <form action="" method="post" id="placeOrder">
                <input type="hidden" name="products" value="<?= $allItems; ?>">
                <input type="hidden" name="grand_total" value="<?= $grand_total; ?>">
                <div class="inputs"> 
                    <div class="form-group">
                        <input type="text" name="name" class="form-control" placeholder="Enter Name" required>
                    </div>
                    <div class="form-group">
                        <input type="email" name="email" class="form-control" placeholder="Enter Email" required>
                    </div>
                    <div class="form-group">
                        <input type="tel" name="phone" class="form-control" placeholder="Enter Phone" required>
                    </div>
                    <div class="form-group">
                        <textarea name="address" id="" class="form-control" rows="3" cols="10" placeholder="Enter Delivery Address Here..." style="width: 320px;"></textarea>
                    </div>
                </div>       
                <H2 style="background-color:rgb(154, 128, 128);">Select Payment Mode</H2>
                    <div class="form-group">
                    <select name="pmode" id="" class="form-control">
                        <option value="" selected disabled>-Select Payment Mode-</option>
                        <option value="cod">Cash On Delivery</option>
                        <option value="netbanking">Net Banking</option>
                        <option value="cards">Debit/Credit Card</option>
                    </select>
   
                <div class="form-group">
                    <input type="submit" name="submit" value="Place Order">
                 </div>
            </form>
        </div>
    </div>
</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="js/jquery.min.js"></script>
<script>
$(document).ready(function(){

$("#placeOrder").submit(function(e){
e.preventDefault();
$.ajax({
    url: 'action.php',
    method: 'post',
    // data: $('form').serialize()*"&action=order",
    data: $('form').serialize() + "&action=order",

    success: function(response){
        $("#order").html(response);
        window.scrollTo(0,0);
        load_cart_item_number();
    }
});
});
    load_cart_item_number();
    function load_cart_item_number(){
        $.ajax({
            url: 'action.php?cartCount=1',
            method: 'get',
            success:function(response){
                $("#cart-item").html(response);
            }
        });
    }
});
</script>
<script>
    $(document).on('click', '.close', function() {
        $(this).closest('.alert').fadeOut();
    });

</script>

</body>
</html>
