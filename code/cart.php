<?php
session_start();
include 'auth.php';
include 'config.php';

    //get cart ID query
    $username=$_SESSION['user'];
    $sql = "SELECT * FROM CART WHERE customerID = '".$username."'";
    $result_cartID = $conn->query($sql);
    $values = $result_cartID->fetch_assoc();
    $cartID = $values['cartID'];
    // echo "<h6> cartID: ".$cartID."</h6>";
    
    if (isset($_POST['productID']) and ($_POST['quantity']!=0)){
        $sql_insert_product = "INSERT INTO IN_CART VALUES( ".$cartID.", ".$_POST['productID'].", ".$_POST['quantity'].")";
        $conn->query($sql_insert_product);
        
        $sql_get_stock = "SELECT stock FROM PRODUCT where itemID = ".$_POST['productID'];
        $result_stock = $conn -> query($sql_get_stock);
        $var_stock = $result_stock -> fetch_assoc();
        $stock = $var_stock['stock'];
        
        $sql_lower_stock = "UPDATE PRODUCT SET stock = ".($stock - $_POST['quantity'])." WHERE itemID = ".$_POST['productID'];
        $conn->query($sql_lower_stock);
        $_POST['productID']=NULL;
    }
    

    if (isset($_POST['to_delete_ID'])){
        
        //query current remaining product stock
        $sql_del_stock = "SELECT stock FROM PRODUCT where itemID = ".$_POST['to_delete_ID'];
        $result_del_stock = $conn -> query($sql_del_stock);
        $var_del_stock = $result_del_stock -> fetch_assoc();
        $del_stock = $var_del_stock['stock'];
        
        //query to get the amount of product your order requested
        $sql_get_amount = "SELECT amount FROM IN_CART WHERE ( (orderID = ".$cartID.") AND (itemID =".$_POST['to_delete_ID'].") )";
        $result_sql_getamount = $conn->query($sql_get_amount);
        $var_amount = $result_sql_getamount -> fetch_assoc();
        $amount_for_increase = $var_amount['amount'];

        
        $sql_increase_stock = "UPDATE PRODUCT SET stock = ".($del_stock + $amount_for_increase)." WHERE itemID = ".$_POST['to_delete_ID'];
        $conn->query($sql_increase_stock);
        
        $sql_delete_product = "DELETE FROM IN_CART WHERE ( (orderID = ".$cartID.") AND (itemID =".$_POST['to_delete_ID'].") );";
        $conn->query($sql_delete_product);
        
        $_POST['to_delete_ID']=NULL;
    }
    
    
    if (isset($_POST['quantity_update_ID'])){
        
        //change quantity in cart
        $sql_change_quantity = "UPDATE IN_CART SET amount = ".($_POST['quantity_update'])." WHERE ( (itemID = ".$_POST['quantity_update_ID'].") AND ( orderID = ".$cartID."))";
        $conn->query($sql_change_quantity);
        
        //change stock in products table
        $sql_change_stock = "UPDATE PRODUCT SET stock = ".($_POST['inital_stock']-$_POST['quantity_update'])." WHERE ( (itemID = ".$_POST['quantity_update_ID']."))";
        $conn->query($sql_change_stock);
        
        //set condition so that update wont occur again by accident
        $_POST['quntity_update_ID']=NULL;
        
        if ($_POST['quantity_update']==0){
            $sql_delete_product = "DELETE FROM IN_CART WHERE ( (orderID = ".$cartID.") AND (itemID =".$_POST['quantity_update_ID'].") );";
            $conn->query($sql_delete_product);
        }

    }
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product</title>

    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="index.js">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">


<style>
    body{
    position: relative;
    min-height: 100vh;
    }
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
    <nav class="nav-bar">
        <div class="nav">

            <div class="logo-image">
                <a href="homepage.php"><img src="images/logo.png" class="logo-image" alt=""></a>

            </div>

            <div class="nav-items">
                
                <a href="customer-page.php"><img src="images/profile.png" alt=""></a>
                <?php $username=$_SESSION['user'];
                    echo "<p> Hello: ".$username."</p>"; 
                ?>
                

                 <div class="cart">
                     <ul>
                         <li class="dropdown_header_cart">
                             <div class="shopping-cart">
                                <a href="cart.php" ><img src="images/cart.png" id = "cart_image" alt=""></a>
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
           <li class="cat-item"><a href="customer-page.php" class="link">My Account</a></li>
           <li class="cat-item"><a href="search_product.php" class="link">Search Products</a></li>

           

       </ul>
    </nav>

    <!-- start #main-site -->
    <main id="main-site">
    
        <!-- Shopping cart section  -->
            <section id="cart" class="py-3">
                <div class="container-fluid w-75">
                    <h5 class="font-baloo font-size-20">Shopping Cart</h5>
                    
                    <!--  shopping cart items   -->
                        <div class="row">
                            <div class="col-sm-9">
                

                                <?php
                                    $sql_itemID="SELECT itemID FROM IN_CART WHERE orderID = ".$cartID;
                                    $sql_prodcuts="SELECT * FROM PRODUCT WHERE itemID IN ( ".$sql_itemID.")";
                                    $result_products = $conn->query($sql_prodcuts);

                                    while($row = $result_products->fetch_assoc()){
                                ?>
                                
                                
                                    <!-- cart item -->
                                    <div class="row border-top py-3 mt-3">
                                        <div class="col-sm-2">
                                        </div>
                                        <div class="col-sm-8">
                                            
                                            
                                            <!-- product name -->
                                            <h5 class="font-baloo font-size-20"><?php echo $row['name']; ?></h5>
                                            <!-- product name -->



                                            <!-- product qty -->
                                                <div class="qty d-flex pt-2">
                                                    
                                                    <div class="d-flex font-rale w-25">
                                                        
                                                        
                                                        
                                                        <!-- query to get the amount of product your order requested -->
                                                       <?php
                                                            $sql_getamount = "SELECT amount FROM IN_CART WHERE ( (orderID = ".$cartID.") AND (itemID =".$row['itemID'].") )";
                                                            $result_getamount = $conn->query($sql_getamount);
                                                            $var_getamount = $result_getamount -> fetch_assoc();
                                                            $getamount = $var_getamount['amount'];
                                                        ?>
                                                        
                                                        <!-- query to get remaining stock -->
                                                       <?php
                                                            $sql_getstock = "SELECT stock FROM PRODUCT where itemID = ".$row['itemID'];;
                                                            $result_getstock  = $conn->query($sql_getstock );
                                                            $var_getstock  = $result_getstock  -> fetch_assoc();
                                                            $getstock  = $var_getstock ['stock'];
                                                        ?>
                                                        
                                                        
                                                        
                                                        
                                                        <!-- button to update the quantity -->
                                                        <form action="cart.php" method="post">
                                                            <input type="hidden" name="quantity_update_ID" value="<?php echo $row['itemID']; ?>">
                                                            <label for="quantity_update">quantity: <?php echo $getamount; ?> </label>
                                                            <br>
                                                            <input type="number" id="cost" name="quantity_update" min="0" max= <?php echo ($getamount + $getstock) ?>>
                                                            <input type="hidden" name="inital_stock" value="<?php echo ($getamount + $getstock) ?>">
                                                            <input type="submit" class="btn btn-warning form-control" value="change quantity" >
                                                        </form>
                                                        
                                                        
                                                    </div>
                                                    
                                                    <form method="post">
                                                        <input type="hidden" name="to_delete_ID" value="<?php echo $row['itemID']; ?>">
                                                        <input type="submit" class="btn font-baloo text-danger px-3" value="delete" >
                                                    </form>
                                                </div>
                                            <!-- !product qty -->
                                            
                                            
                                        </div>
                                        
                                        <!-- PRICE -->
                                        <div class="col-sm-2 text-right">
                                            <div class="font-size-20 text-danger font-baloo">
                                                $<span class="product_price"><?php echo $row['cost'] ; ?></span>
                                            </div>
                                        </div>
                                        <!-- PRICE -->
                                        
                                    </div>
                                <?php
                                    }
                                ?>
                            </div>
                            
                            
                            <!-- subtotal section-->
                            
                            <?php 
                                //calculate product total:
                                $sql_a_c="SELECT sum(amount*cost) as cost FROM ";
                                $sql_join="(IN_CART INNER JOIN PRODUCT ON IN_CART.itemID=PRODUCT.itemID)";
                                $sql_where=" WHERE IN_CART.orderID= ".$cartID;
                                $result_cart_total= $conn->query($sql_a_c.$sql_join.$sql_where);
                                $var_total = $result_cart_total -> fetch_assoc();
                                $cart_total = $var_total['cost'];
                                
                                
                                //calculate number of products
                                $sql_num_of_produt="SELECT sum(amount) as count FROM (IN_CART INNER JOIN PRODUCT ON IN_CART.itemID=PRODUCT.itemID)";
                                $sq_where_addon="WHERE IN_CART.orderID = ".$cartID;
                                $result_count= $conn->query($sql_num_of_produt.$sq_where_addon);
                                $var_count = $result_count -> fetch_assoc();
                                $count = $var_count['count'];
                                

                            ?>
                            <div class="col-sm-3">
                                <div class="sub-total border text-center mt-2">
                                    <div class=" py-4">
                                        <h5 class="font-baloo font-size-20">Subtotal ( <?php echo $count; ?> items):&nbsp; <span class="text-danger">$<span class="text-danger" id="deal-price"><?php echo $cart_total; ?> </span> </span> </h5>
                                        <form action="cart_to_order.php">
                                            <input type="submit" class="btn btn-warning mt-3" name="Proceed to Buy">
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!-- !subtotal section-->
                        </div>
                    <!--  !shopping cart items   -->
                </div>
            </section>
        <!-- !Shopping cart section  -->

   
    


    <div class="footer">
        <footer>
            <div class="footer-container">
                    <a href="#"><img src="images/logo.png" class = "logo" alt="beatles logo"></a>   
            </div>
        </footer>
    </div>
</body>
</html>