<?php
session_start();
include 'auth.php';
?>

<html>
    
    <?php
        $servername = "localhost";
        $dbUsername = "rochaa6_Admin1";
        $dbPass = "Baseball97!";
        $dbName = "rochaa6_beatlesMerch";

        // Create/check connection
        $conn = new mysqli($servername, $dbUsername, $dbPass, $dbName);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
    ?>
    
    <?php
        // define admin ID
        define( "adminID", $_SESSION['user']);
        echo "<h6> current user: ".adminID." </h6>";
    ?>
    
    
    
    <style>
        
        a{
        text-decoration: none;
        Color: black;
        Padding: 0.5em;
        background-color: lightgrey;
        border: 5px solid grey;
        border-radius: 50px;
        }
        a:hover{
        background-color: grey;
         color: white;
        }
        
        h1, h2{
            text-align: center;
        }
    </style>
    
    <body>
        
        <h1 style= "background-color: #CFCFCF; border: 5px solid grey; text-align:center;"> Assign an order to an employee you manage </h1>
         <a href="admin_page.html">Admin Homepage</a>
        <br>
        <br>
        
        <!-- form action to call search page -->
        <?php
            $orderID_assign = $_POST['orderID_assign'];
            $username_assign = $_POST['username_assign'];
            
            if ( ($orderID_assign != null) and ($username_assign != null) ){
                $sql_update_order_handler = "UPDATE HAS_ORDER SET employeeID='".$username_assign."' WHERE orderID='".$orderID_assign."'";
                echo "<br>";
                $conn->query($sql_update_order_handler);
            }
            else {
                echo "no input";
            }
            
            
        ?>
        
        <form method="post" style="border: 5px solid grey; text-align:center; padding: 10px;">
            Select a category to search by:<br>
            <h4>Assign case: </h4>
            <label for="orderID_assign">input orderID:</label>
            <input type="text" id="orderID_assign" name="orderID_assign"><br>
            <h4>To Employee: </h4>
            <label for="username_assign">input username:</label>
            <input type="text" id="username_assign" name="username_assign">
            <br />
            <br>
            <input type="submit" name="submit" value="submit assignment">
        </form>
        
    </body>
    
    
    
    
    <body >
        <h2> Orders currently assigned to admin</h2>
        <p style="border: 5px solid grey; text-align:center; padding: 10px;">
        <?php
            
            //query orders currently assigned to the given admin 
            $sql_list_admin_orders = "SELECT * FROM HAS_ORDER WHERE employeeID"." = '".adminID."'";
            echo "<br>";
            $result_admin_orders = $conn->query($sql_list_admin_orders);
            
            if ($result_admin_orders->num_rows > 0) {
                //output query results by row
                echo "<table>";
                echo '<th> <td>itemID</td> <td>customerID</td> <td>employeeID</td> </th>';
                while($row = $result_admin_orders->fetch_assoc()) {
                    echo "<tr>";
                    foreach ($row as $key => $value){
                        echo "<td>".$value."</td>";
                    }
                    echo "</tr>";
                }
                echo "</table>";
            } 
            else {
              //displays "0 results" if nothing matched
              echo "<br><br> 0 results";
            }
        ?>
        </p>
        
    </body>



    <body >
        <h2> List of employees you manage</h2>
        <p style="border: 5px solid grey; text-align:center; padding: 10px;">
        <?php
        
            // define admin ID
            define( "adminID", "admin1");
            
            //query orders currently assigned to the given admin 
            $sql_list_managed_employees = "SELECT userID FROM MANAGES WHERE managerID"." = '".adminID."'";
            echo "<br>";
            $result_managed = $conn->query($sql_list_managed_employees);
            
            if ($result_managed->num_rows > 0) {

                //output query results by row
                echo "<table>";
                echo '<th> <td>userID</td> </th>';
                while($row = $result_managed->fetch_assoc()) {
                    echo "<tr>";
                    foreach ($row as $key => $value){
                        echo "<td>".$value."</td>";
                    }
                    echo "</tr>";
                }
                echo "</table>";
            } 
            else {
              //displays "0 results" if nothing matched
              echo "<br><br> 0 results";
            }
        ?>
        </p>
        
    </body>
    
    
    
    
</html>