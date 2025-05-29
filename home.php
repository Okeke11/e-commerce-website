<?php
session_start(); // Start the session
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>
    <link rel="stylesheet" href="home.css">
    <link rel="stylesheet" href="assets/icons/css/all.css">
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
                    <button><a href="login.php">Login</a></button>
                    <button><a href="signup.php">Sign Up</a></button>
                <?php endif; ?>
            </ul> 
        </div>
    </nav>
    <div class="middle1">
        <div class="welcome-text">
            <span>W</span>
            <span>e</span>
            <span>l</span>
            <span>c</span>
            <span>o</span>
            <span>m</span>
            <span>e</span>
            <br>
            <span>t</span>
            <span>o</span>
            <br>
            <span>C</span>
            <span>o</span>
            <span>d</span>
            <span>e</span>
            <span>!</span>
        </div>
        <div class="image-container">
            <img src="images/images (3).jpeg" alt="shopping">
        </div>
    </div>
    <h3 style="text-align: center;">The <span style="color: red; font-size:80px; ">No 1</span> Website to shop for quality cheap goods on the web. This is our only and official website, please beware of scams.</h3>

    <div class="socials">
   <ul>
    <li>
        <a href="https://www.twitter.com/okeke">ChiagozieMicha12 &nbsp;
            <i class="fa-brands fa-twitter"></i>
        </a>
    </li>
    <li>
        <a href="https://www.facebook.com/okeke">Okeke &nbsp;
            <i class="fa-brands fa-facebook"></i>
        </a>
    </li>
    <li>
        <a href="https://www.instagram.com/itsagozie_">itsagozie_ &nbsp;
            <i class="fa-brands fa-instagram"></i>
        </a>
    </li>
    <li>
        <a href="https://www.linkedin.com/chiagozie-okeke">Chiagozie Okeke &nbsp;
            <i class="fa-brands fa-linkedin"></i>
        </a>
    </li>
    <li>
        <a href="https://www.youtube.com/okekeandcode">okekeandcode &nbsp;
            <i class="fa-brands fa-youtube"></i>
        </a>
    </li>
    <li>
        <a href="https://www.github.com/Okeke11">Okeke11 &nbsp;
            <i class="fa-brands fa-github"></i>
        </a>
    </li>
   </ul>
   </div>
    <marquee behavior="scroll" direction="left" class="offproducts">All products are 30% off from March 15th till April 9th, Dont miss out on the big sale!!</marquee>
    <h1>TOP PRODUCTS</h1>
    <div class="container">
    <div id="message"></div>
        <div class="row">
            <?php
                include 'database1.php';
                $stmt = $conn->prepare("SELECT * FROM product");
                $stmt->execute();
                $result = $stmt->get_result();
                while($row = $result->fetch_assoc()):
            ?>
                <div  class="products_column1">
                        <img src="<?= $row['product_image'] ?>">
                    <div>
                            <p>&nbsp;&nbsp;<?= $row['product_name']?></p>
                            <div class="price">
                                <h2 style="float: left;" class="real_price"> &nbsp;<i class="fas fa-naira-sign"></i><?= number_format($row['product_price'],2)?></h2>
                                <p style="float: left;" class="discount"> &nbsp;<i class="fas fa-naira-sign"></i><?= number_format($row['fake_price'],2)?></p>
                            </div>
                    </div>
                        <div>
                            <form action="" class="form-submit">
                                <input type="hidden" class="pid" value="<?= $row['id'] ?>">
                                <input type="hidden" class="pname" value="<?= $row['product_name'] ?>">
                                <input type="hidden" class="pprice" value="<?= $row['product_price'] ?>">
                                <input type="hidden" class="pimage" value="<?= $row['product_image'] ?>">
                                <input type="hidden" class="pcode" value="<?= $row['product_code'] ?>">
                                    <div class="add">
                                        <button type="button" class="addItemBtn">Add to cart</button>
                                    </div>
                            </form>
                        </div>
                </div>
            <?php endwhile; ?>
        </div>
</div>
    
        
<hr style="height: 10px; color: black;"><hr style="width: 1000px;">

<h1>Popular Products</h1>
        
    <div class="row">
        <div class="horizontal_scroll">
            <?php
                include 'database1.php';
                $stmt = $conn->prepare("SELECT * FROM product");
                $stmt->execute();
                $result = $stmt->get_result();
                while($row = $result->fetch_assoc()):
            ?>
                <div  class="products_column2">
                        <img src="<?= $row['product_image'] ?>">
                    <div>
                            <p>&nbsp;&nbsp;<?= $row['product_name']?></p>
                            <div class="price">
                                <h2 style="float: left;" class="real_price"> &nbsp;<i class="fas fa-naira-sign"></i><?= number_format($row['product_price'],2)?></h2>
                                <p style="float: left;" class="discount"> &nbsp;<i class="fas fa-naira-sign"></i><?= number_format($row['fake_price'],2)?></p>
                            </div>
                    </div>
                    <div>
                        <form action="" class="form-submit">
                                <input type="hidden" class="pid" value="<?= $row['id'] ?>">
                                <input type="hidden" class="pname" value="<?= $row['product_name'] ?>">
                                <input type="hidden" class="pprice" value="<?= $row['product_price'] ?>">
                                <input type="hidden" class="pimage" value="<?= $row['product_image'] ?>">
                                <input type="hidden" class="pcode" value="<?= $row['product_code'] ?>">
                            <div class="add2">
                                <button type="button" class="addItemBtn">Add to cart</button>
                            </div>
                        </form>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>

    <div class="bottombar">
        <a href="chatwithus.html" class="chatwithus">CHAT WITH US</a>
        <a href="helpcenter.html" class="helpcenter">HELP CENTER</a>
        <a href="termsandconditions.html" class="termsandconditions">TERMS AND CONDITIONS</a>
        <br><br>
        <a href="privacynotice.html" class="privacynotice">PRIVACY NOTICE</a>
        <a href="cookienotice.html" class="cookienotice">COOKIE NOTICE</a>
        <a href="BAS1.html" class="becomeaseller">BECOME A SELLER</a>
        <br><br>
        <a href="" class="reportaproduct">REPORT A PRODUCT</a>
        <a href="blackfriday.html" class="blackfriday">BLACK FRIDAY</a>
        <a href="logout.php" class = logout>LOGOUT</a>
        <hr style="width: 1200px;">
        <div class="allrights">
            <p>All Rights Reserved &reg;</p>
        </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="js/jquery.min.js"></script>

<script>
    $(document).ready(function(){
        $(".addItemBtn").click(function(e){
            e.preventDefault();
            var $form = $(this).closest(".form-submit");
            var pid =$form.find(".pid").val();
            var pname =$form.find(".pname").val();
            var pprice =$form.find(".pprice").val();
            var pimage =$form.find(".pimage").val();
            var pcode =$form.find(".pcode").val();

            $.ajax({
                url: 'action.php',
                method: 'post',
                data: {pid:pid,pname:pname,pprice:pprice,pimage:pimage,pcode:pcode},
                success:function(response){
                $("#message").html(response);
                window.scrollTo(0,0);
                load_cart_item_number();
                }
            });
        });
        load_cart_item_number();
        function load_cart_item_number(){
            $.ajax({
                // url: 'action.php',
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
