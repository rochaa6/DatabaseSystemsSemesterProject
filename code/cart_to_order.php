<?php 
session_start();
include 'config.php';
include 'auth.php';
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
    
    <!-- Header code -->
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
    
    <main id="main-site">
    <!-- query code -->
    <div>
        <h1>Purchasing Product Region</h1>
        <br>
        <br>
        
        <?php 

            //gets cartID of current sessions user
            $sql_get_cartID= "SELECT cartID FROM CART WHERE customerID= '".$_SESSION['user']."'";
            $result_cartID = $conn->query($sql_get_cartID);
            $user_cartID = $result_cartID->fetch_assoc();
            $cur_cartID = $user_cartID['cartID'];
            
            
            //check if there are products in the cart; otherwise ignore order placement request.
            $sql_size_check = "SELECT COUNT(*) as count FROM IN_CART WHERE orderID = ".$cur_cartID;
            $result_sizecheck = $conn->query($sql_size_check);
            $sizecheck = $result_sizecheck->fetch_assoc();
            
            //if statement to check if the cart is empty or not
            if ($sizecheck['count']==0){
                print("the cart is empty, there's nothing to purchase...<br>");
            }
            else{
                //copy users cart to 'orders' table
                $sql_insert = "INSERT INTO ORDERS (orderID) ";
                $sql_subselect = "SELECT cartID FROM CART WHERE cartID = ".$cur_cartID;
                $conn -> query($sql_insert.$sql_subselect);
                
                
                //copy corresponding IN_CART data to IN_ORDER
                $sql_ino_i = "INSERT INTO IN_ORDER (orderID, itemID, amount ) ";
                $sql_ino_ss = "SELECT orderID, itemID, amount  FROM IN_CART ";
                $sql_ino_w = "WHERE orderID =".$cur_cartID;
                $conn -> query($sql_ino_i.$sql_ino_ss.$sql_ino_w);
                
                
                //Select an admin to manage the case at random
                $sql_admin = "SELECT username FROM STAFF WHERE staff_group = 'admin'";
                $sql_random = " ORDER BY RAND() LIMIT 1";
                $result_admin = $conn -> query($sql_admin.$sql_random);
                $var_admin = $result_admin -> fetch_assoc();
                $admin = $var_admin['username'];
                
                
                
                //create a has_order element:
                $sql_has_order="INSERT INTO HAS_ORDER VALUES( ".$cur_cartID.", '".$_SESSION['user']."', '".$admin."')";
                $conn -> query($sql_has_order);
                
                
                //remove users old IN_CART entries
                $sql_delete_incart = "DELETE FROM IN_CART WHERE orderID= ".$cur_cartID;
                $conn->query($sql_delete_incart);
                
                
                //remove users old CART entry
                $sql_delete_cart = "DELETE FROM CART WHERE cartID= ".$cur_cartID;
                $conn->query($sql_delete_cart);
    
                
                //set up union subqueries to get new cartID
                $sql_maxID = "SELECT max(ID) FROM ";
                $sql_UID_1 = "SELECT cartID as ID FROM CART";
                $sql_UID_2 = "SELECT orderID as ID FROM ORDERS";
                $alias = "as orderIDs";
                $sql_total = $sql_maxID."(".$sql_UID_1." UNION ".$sql_UID_2.")".$alias;
                
                
                //get new ID
                $result_max = $conn -> query($sql_total);
                $max = $result_max -> fetch_assoc();
                $new_cartID=($max['max(ID)']+1);
                
                
                //set up new cart
                $sql_new_cart = "INSERT INTO CART VALUES( ".$new_cartID.", '".$_SESSION['user']."')";
                $conn->query($sql_new_cart);
                
                
                echo "      Order placed by ".$_SESSION['user'].", with chosen case manager: ".$admin."<br>";
                echo "      previous cart-ID: ".$cur_cartID."    new cart-ID: ".($new_cartID)."<br>";
                
                print("<h1>Transfer Succesful! Your purchase has been completed</h1>");
            }
            
        ?>
        
    </div>
    


    <!-- Footer code -->
    <div class="footer">
        <footer>
            <div class="footer-container">
                    <a href="#"><img src="images/logo.png" class = "logo" alt="beatles logo"></a>   
            </div>
        </footer>
        <!-- End footer section -->
    </div>
    
</body>
</html>