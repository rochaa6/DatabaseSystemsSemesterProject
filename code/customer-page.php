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

<style>
        table {
            margin: 0 auto;
            font-size: large;
            border: 1px solid black;
        }
  
        td {
            background-color: #E4F5D4;
            border: 1px solid black;
        }
  
        th,
        td {
            font-weight: bold;
            border: 1px solid black;
            padding: 10px;
            text-align: center;
        }
  
        td {
            font-weight: lighter;
        }
        
        h1, h2{
        background-color: #CFCFCF; 
        border: 5px solid grey; 
        text-align:center;
        margin: 50px;
        font-size: 50px;
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

<div style = "overflow-x:auto;" class="customer-info" >
    <div style="text-align:center;">
        
        <?php
        
            $mysqli = new mysqli($host, $user, $password, $dbname);

            $sql_account = "SELECT username, email, f_name, l_name FROM CUSTOMER WHERE username = '".$_SESSION['user']."'";
            $result = $mysqli->query($sql_account);
            $mysqli->close();
            
            // print those products in a table
            
            
            $username=$_SESSION['user'];
        ?>
        
        <h1>Account Details</h1>
        <!-- TABLE CONSTRUCTION-->
        <table>
            <tr>
                <th>Username</th>
                <th>Email</th>
                <th>First name</th>
                <th>Last name</th>
            </tr>
            <!-- PHP CODE TO FETCH DATA FROM ROWS-->
            <?php   // LOOP TILL END OF DATA 
                while($rows=$result->fetch_assoc())
                {
             ?>
            <tr>
                <!--FETCHING DATA FROM EACH 
                    ROW OF EVERY COLUMN-->
                <td><?php echo $rows['username'];?></td>
                <td><?php echo $rows['email'];?></td>
                <td><?php echo $rows['f_name'];?></td>
                <td><?php echo $rows['l_name'];?></td>
            </tr>
            <?php
                }
             ?>
        </table>
    </div>
</div>
   
    <h2>View Purchase History</h2>
    

<div>
    <!--<table class="table">-->
    <!--    <thead>-->
    <!--        <tr>-->
    <!--            <th class="text-center">ID</th>-->
    <!--            <th class="text-center">PRODUCT</th>-->
    <!--            <th class="text-center">STATUS</th>-->
    <!--            <th class="text-center">DATE</th>-->
    <!--            <th class="text-center">PAYMENT</th>-->
    <!--            <th class="text-center">TRANSACTION ID</th>-->
    <!--        </tr>-->
    <!--    </thead>-->
    <!--</table>-->



        <!-- code to generate a table for each previous order -->
        <?php
            //below query gets each previous order associated with a customer from 'orders' table
            $sql_get_orderIDs = "SELECT orderID FROM HAS_ORDER WHERE customerID = '".$username."'";
            $sql_get_orders = "SELECT * FROM ORDERS WHERE orderID IN (".$sql_get_orderIDs.")";
            $sql_orderby = " ORDER BY ordered_date desc";
            $result_orders = $conn->query($sql_get_orders.$sql_orderby);
            
            
            //while loop through previous orders
            while($cur_order = $result_orders->fetch_assoc()){
        ?>  
            
        <div class ="table-responsive">   
                <!-- set up individual table headers --> 
        
                    <table class="table">
                        <tr>
                            <th>orderID</th>
                            <th>Status</th>
                            <th>Date of Purchase</th>
                            <th>Total Cost</th>
                        </tr>
                        <tr> 
                             <td> <?php echo $cur_order['orderID'] ?> </td>
                             <td> <?php echo $cur_order['status'] ?> </td>
                             <td> <?php echo $cur_order['ordered_date'] ?> </td> 
                             
                             <?php
                                //calculate product total:
                                $sql_a_c="SELECT sum(amount*cost) as cost FROM ";
                                $sql_join="(IN_ORDER INNER JOIN PRODUCT ON IN_ORDER.itemID=PRODUCT.itemID)";
                                $sql_where=" WHERE IN_ORDER.orderID= ".$cur_order['orderID'];
                                $result_cart_total= $conn->query($sql_a_c.$sql_join.$sql_where);
                                $var_total = $result_cart_total -> fetch_assoc();
                                $cart_total = $var_total['cost'];
                             ?>
                             
                             <td> <?php print($cart_total); ?> </td>  <!-- NOTE: 1000 is a placeholder value until we add prodcut costs -->
                        </tr>
                    </table>
            
            <?php   
                // get all the products in the current order being examined 
                $sql_get_product_ID="SELECT itemID FROM IN_ORDER WHERE orderID = ".$cur_order['orderID'];
                $sql_get_products = "SELECT itemID, name, genre, stock, cost FROM PRODUCT WHERE itemID IN (".$sql_get_product_ID.")";
                $result_products = $conn->query($sql_get_products);
                
                // print those products in a table
                if ($result_products->num_rows > 0) {
                    $count=0;
                    //output query results by row
                    echo '<div style="height: 150px; overflow: auto">';
                    echo '<table style= "border: solid black 1px; height: 10px">';
                    echo '<tr> <th>itemID</th> <th>name</th> <th>genre</th> <th>quantity</th> <th>cost</th></tr>';
                    
                    while($row = $result_products->fetch_assoc()) {
                        
                        echo "<tr>";
                        $loop_itemID="";
                        foreach ($row as $key => $value){
                            
                            if ($key=='itemID'){
                                $loop_itemID=$value;
                            }
                            
                            if ($key!='stock'){
                                echo "<td>".$value."</td>";
                            }
                            else{
                                $sql_loopamount="SELECT amount FROM IN_ORDER where ( (itemID= ".$loop_itemID.") AND ( orderID= ".$cur_order['orderID']."))";
                                $result_loopamount=$conn -> query($sql_loopamount);
                                $var_loopamount= $result_loopamount -> fetch_assoc();
                                $loopamount = $var_loopamount['amount'];
                                echo "<td>".$loopamount."</td>";
                            }
                        }
                        echo "</tr>";
                        $count+=1;
                    }
                    echo "</table>";
                    echo "</div><br><br><br>";
                } 
                //displays "0 results" if no products
                else {
                    echo "<br><br> 0 results";
                }
            }
            ?>
        </div> 
</div>



<footer>
        <div class="footer-container">
                <a href="#"><img src="images/logo.png" class = "logo" alt="beatles logo"></a>   
        </div>
    </footer>
</body>
</html>
