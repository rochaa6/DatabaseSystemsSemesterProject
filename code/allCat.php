<?php 
    include 'config.php';  
    include 'auth.php';
    $sql = "SELECT * FROM PRODUCT WHERE genre='".$_POST['genre']."'";
    $result = $conn->query($sql);
    echo "<h6> query: $sql";
?>
 

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Owl Supplies</title>

    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/allproducts.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

</head>
<body>
    <nav class="nav-bar">
        <div class="nav">
            <div class="logo-image">
                <a href="homepage.php"><img src="images/logo.png" class="logo-image" alt=""></a>

            </div>

            <div class="nav-items">
                 

                 <a href="#"><img src="images/profile.png" alt=""></a>

                 <div class="cart">
                     <ul>
                         <li class="dropdown_header_cart">
                             <div class="shopping-cart">
                                <a href="cart.php"><img src="images/cart.png" id = "cart_image" alt=""></a>
                             </div>
                         </li>
                     </ul>
                </div>
                <div class="logout">
                    <div class="login-btn">
                        <button class = "logoutbtn" type="button" onclick="document.location='logout.php'">Logout</button>
                    </div>
                </div>
            </div>
       </div>
       <ul class="cat-list">
           
        <li class="cat-item"><a href="homepage.php" class="link" id = "home-item" >Home</a></li>
        <li class="cat-item"><a href="allProducts.php" class="link">All Products</a></li>
        <li class="cat-item"><a href="#" class="link">My Account</a></li>

       </ul>
    </nav>







    <!-- all product section -->
    <div class="product-section">
        <section class="product">
            <h2 class="product-category">All Products</h2>
            <?php
                while($row = $result->fetch_assoc()){
            ?>
                    <div class="product-container">
                        <div class="product-card">
                            <div class="product-image">
                                <img src="images/<?php echo $row['phot_path']; ?>" class= "product-thumb"alt="">
                                <form method="post" action="product.php">
                                    <input type="hidden" name="productID" value="<?php echo $row['itemID']; ?>">
                                    <input type="hidden" name="name" value="<?php echo $row['name']; ?>">
                                    <input type="hidden" name="genre" value="<?php echo $row['genre']; ?>">
                                    <input type="hidden" name="stock" value="<?php echo $row['stock']; ?>">
                                    <input type="hidden" name="cost" value="<?php echo $row['cost'] ;?>">
                                    <input type="hidden" name="desc_path" value="<?php echo $row['desc_path']; ?>">
                                    <input type="hidden" name="phot_path" value="<?php echo $row['phot_path']; ?>">
                                    <!-- <button class="card-btn">open</button> -->
                                    <input type="submit" class="card-btn" name="submit" value="submit assignment">
                                    <!-- "window.location.href='product.php'" -->
                                </form>
                            </div> 
                            <div class="product-info">
                                <h2 class="product-cat"><?php echo $row['name']; ?></h2>
                                <p class="product-des"><?php echo $row['desc_path'] ?></p>
                                <?php echo "<h6> hello ".$row['cost']." </h6>" ; ?>
                                <span class="price"><?php echo $row['cost'] ?></span>
                            </div>
                        </div>
                    </div>
            <?php }
            ?>
        </section>
    </div>
    <!-- end of product section -->









    <footer>
        <div class="footer-container">
                <a href="#"><img src="images/logo.png" class = "logo" alt="beatles logo"></a>   
    </div>
    <!-- End footer section -->
</body>
</html>