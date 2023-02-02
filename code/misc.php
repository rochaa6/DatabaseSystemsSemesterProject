<?php 
    include 'auth.php';
    include 'config.php';    
    $sql = "SELECT * FROM PRODUCT WHERE genre = 'misc'";
    $result = $conn->query($sql);
?>
 

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Misc.</title>

    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/allproducts.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">


<style>
    #main-site{
    padding-bottom: 5rem;
    }
    .footer{
    position: absolute;
    bottom: 0;
    width: 100%;
    height: 2.5rem;
    }
</style>
</head>
<body>
<main id= "main-site">
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
    <h2 class="product-category">Misc</h2>

    <!-- all product section -->
    <section class="product">
        <div class="product-section">
            <?php
                while($row = $result->fetch_assoc()){
            ?>
                    <div class="product-container">
                        <div class="product-card">
                            <div class="product-image">
                                <img src="images/misc.jpg" " alt="product" class= "product-thumb" alt="">
                                <form method="post" action="product.php">
                                    <input type="hidden" name="productID" value="<?php echo $row['itemID']; ?>">
                                    <input type="hidden" name="name" value="<?php echo $row['name']; ?>">
                                    <input type="hidden" name="genre" value="<?php echo $row['genre']; ?>">
                                    <input type="hidden" name="stock" value="<?php echo $row['stock']; ?>">
                                    <input type="hidden" name="cost" value="<?php echo $row['cost'] ;?>">
                                    <input type="hidden" name="desc_path" value="<?php echo $row['desc_path']; ?>">
                                    <input type="submit" class="card-btn" name="submit" value="Go To Product">
                                </form>
                            </div> 
                            <div class="product-info">
                                <h2 class="product-cat"><?php echo $row['name']; ?></h2>
                                <p class="product-des"><?php echo $row['desc_path'] ?></p>
                                <span class="price"><?php echo '$', $row['cost'] ?></span>
                            </div>
                        </div>
                    </div>
            <?php }
            ?>
        </div>
    </section>
    
    <!-- end of product section -->
</body>
</html>