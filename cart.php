<?php
session_start(); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
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
table{
    width: 70%;
  margin-top: 20px;
  margin-left: 200px;
}
table, th{
    padding: 10px;
}
table, th, td{
    text-align: center;
border: 1px solid black;
border-collapse: collapse;
}
.badge-danger{
    background-color: red;
    text-decoration: none;
    color: black;
    padding: 8px;
    border-radius: 6px;
}
.continue{
    padding: 13px;
}
.continue a{
    text-decoration: none;
    background-color: green;
    border-radius: 3px;
    padding: 8px;
    color: black;
}
.checkout{
    padding: 13px;
}
.checkout a{
    text-decoration: none;
    background-color: blue;
    border-radius: 3px;
    padding: 8px;
    color: black;
}
.disabled {
    pointer-events: none;
    opacity: 0.5;
    cursor: not-allowed;
}
    </style>
</head>
<body>

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
            <div class="">
            <div style="display:<?php if(isset($_SESSION['showAlert'])){
                echo $_SESSION['showAlert'];}else {echo 'none'; } unset($_SESSION['showAlert']); ?>;" 
                class="alert alert-success alert dismissible">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong><?php if(isset($_SESSION['message'])){
                echo $_SESSION['message'];} unset($_SESSION['showAlert']);  ?></strong>
            </div>
                <div>
                    <table>
                        <thead>
                            <tr>
                                <td colspan="7">
                                    <h4>Products in your cart</h4>
                                </td>
                            </tr>
                            <tr>
                                <th>ID</th>
                                <th>Image</th>
                                <th>Product</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Total Price</th>
                                <th>
                                    <a href="action.php?clear=all" onclick="return confirm('Are you sure you want to clear your cart?');" class="badge-danger">
                                        <i class="fas fa-trash"></i>&nbsp;&nbsp;Clear Cart
                                    </a>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                require 'database1.php';
                                if (!isset($_SESSION['user_id'])) {
                                echo "<p style='text-align: center; margin-top: 20px; font-size: 18px;'>Please <a href='login.php'>log in</a> to view your cart.</p>";
                                exit();
                                    }
                                $user_id = $_SESSION['user_id']; // Get the current user ID
                                $stmt = $conn->prepare("SELECT * FROM cart WHERE user_id = ?");
                                $stmt->bind_param("i", $user_id);
                                $stmt->execute();
                                $result = $stmt->get_result();
                                $grand_total = 0;
                                while($row = $result->fetch_assoc()):
                            ?>
                            <tr>
                                <td><?= $row['id'] ?></td>
                                <input type="hidden" class="pid" value="<?= $row['id'] ?>">
                                <td><img src="<?= $row['product_image'] ?>" width="70"></td>
                                <td><?= $row['product_name']  ?></td>
                                <td><i class="fas fa-naira-sign"></i><?= number_format( $row['product_price'] ,2)?></td>
                                <input type="hidden" class="pprice" value="<?= $row['product_price'] ?>">
                                <td><input type="number" class="itemQty" value="<?= $row['qty'] ?>" style = "width: 75px;"></td>
                                <td><i class="fas fa-naira-sign"></i><?= number_format( $row['total_price'] ,2)?></td>
                                <td>
                                <a href="action.php?remove=<?= $row['id'] ?>" onclick="return confirm ('Are you sure you want to remove this item?')"><i class="fas fa-trash-alt"></i></a>
                                </td>
                            </tr>
                            <?php $grand_total += $row['total_price'] ?>
                            <?php endwhile; ?>
                            
                            <tr>
                                <td colspan="3" class="continue">
                                    <a href="products.php"><i class="fas fa-cart-plus"></i>&nbsp;Continue Shopping</a>
                                </td>
                                <td colspan="2"><b>Grand Total</b></td>
                                <td><b><i class="fas fa-naira-sign"></i><?= number_format( $grand_total,2)?></b></td>
                                <td class="checkout">
                                    <a 
                                        href="<?= ($grand_total > 1) ? 'checkout.php' : '#'; ?>" 
                                        class="btn <?= ($grand_total > 1) ? '' : 'disabled'; ?>" 
                                        <?= ($grand_total > 1) ? '' : 'onclick="return false;"'; ?>>
                                        <i class="far fa-credit-card"></i>&nbsp;Checkout
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="js/jquery.min.js"></script>

<script>
$(document).ready(function(){
    $(document).on('change', '.itemQty', function(){
        const $el = $(this).closest('tr');
        const pid = $el.find(".pid").val();
        const pprice = $el.find(".pprice").val();
        const qty = $el.find(".itemQty").val();

        console.log("Sending: ", qty, pid, pprice);

        $.ajax({
            url: 'action.php',
            method: 'post',
            cache: false,
            data: {qty: qty, pid: pid, pprice: pprice},
            success: function(response){
                console.log("Server response:", response);
                // Update total price cell dynamically
                const total = (qty * pprice).toFixed(2);
                $el.find("td").eq(5).html('<i class="fas fa-naira-sign"></i>' + total);
                updateGrandTotal();
            }
        });
    });

    function updateGrandTotal(){
        let grandTotal = 0;
        $(".itemQty").each(function(){
            const $el = $(this).closest('tr');
            const qty = parseFloat($(this).val());
            const price = parseFloat($el.find(".pprice").val());
            grandTotal += qty * price;
        });
        $(".checkout").prev().find("b").html('<i class="fas fa-naira-sign"></i>' + grandTotal.toFixed(2));
        if(grandTotal > 1){
            $(".checkout a").removeClass("disabled").attr("href", "checkout.php");
        } else {
            $(".checkout a").addClass("disabled").attr("href", "#");
        }
    }
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

    $(document).on('click', '.close', function() {
        $(this).closest('.alert').fadeOut();
    });
});
</script>
</body>
</html>