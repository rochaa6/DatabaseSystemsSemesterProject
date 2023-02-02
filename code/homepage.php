<?php
session_start();
include 'auth.php';
include 'config.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Penny Lane</title>

    <link rel="stylesheet" href="css/index.css">

</head>
<body>
    <!--navigation section that is displayed on every page-->
    <nav class="nav-bar">
        <div class="nav">

            <div class="logo-image">
                <a href="homepage.php"><img src="images/logo.png" class="logo-image" alt=""></a>

            </div>

            <div class="nav-items">
                 <a href="customer-page.php"><img src="images/profile.png" alt=""></a>
                
                <?php $username=$_SESSION['user'];echo "<p> Hello: ".$username."</p>" ?>
                
                 <div class="cart">
                     <ul>
                         <li class="dropdown_header_cart">
                             <div class="shopping-cart">
                                <a style= "padding-right: 30px;" href="cart.php"><img src="images/cart.png" id = "cart_image" alt=""></a>
                             </div>
                         </li>
                     </ul>
                </div>
                <div class="logout">
                    <div class="login-btn">
                        <button class = "loginbtn" type="button" onclick="document.location='logout.php'">Logout</button>
                    </div>
                </div>
            </div>
       </div>
       <ul class="cat-list">
           
        <li class="cat-item"><a href="homepage.php" class="link" id = "home-item" >Home</a></li>
           <li class="cat-item"><a href="allProducts.php" class="link">All Products</a></li>
           <li class="cat-item"><a href="customer-page.php" class="link">My Account</a></li>
           <li class="cat-item"><a href="search_product.php" class="link">Search Products</a></li>
           

       </ul>
    </nav>

    <!-- Header Section with title start -->
    <header class="hero-section">
        <div class="content">
            <div class="image-container">
                <div class="text">Penny Lane </div>
              </div>
        </div>
    </header>  
    <!-- End of header section -->

    <!-- category section: allow customer to shop by specific categories -->
    <div class="cat-section">
        <h2 class="Category-title">Shop By Categories</h2>
        <section class="category-container">
            <a href="vinyl.php" class="collection">
                <img src="images/vinyl.jpg" alt="">
                <p class="collection-title"> Vinyl</p>
            </a>
            <a href="cd.php" class="collection">
                <img src="images/cd.png" alt="">
                <p class="collection-title"> CD</p>
            </a>
            <a href="apparel.php" class="collection">
                <img src="images/apparel.jpg" alt="">
                <p class="collection-title"> Apparel</p>
            </a>    
        </section>
        <section class="category-container-two">
            <a href="poster.php" class="collection ">
                <img src="images/poster.jpg" alt="">
                <p class="collection-title"> Posters</p>
            </a>
            <a href="misc.php" class="collection">
                <img src="images/misc.jpg" alt="">
                <p class="collection-title"> Misc.</p>
            </a>
        </section>
    </div>
    <!-- End category section -->

    <footer>
        <div class="footer-container">
                <a href="#"><img src="images/logo.png" class = "logo" alt="beatles logo"></a>   
        </div>
    </footer>
    <!-- End footer section -->
</body>
</html>