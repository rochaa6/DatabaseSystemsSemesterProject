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
        // define employeeID for testing
        //define( "employeeID", "staff1");
        define("employeeID",$_SESSION['user']);
        echo "<h6> current employee is: ".$_SESSION['user']."</h6>";
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
        
        button {
          border:5px solid grey;
          padding: 10px 27px;
          text-align: center;
          text-decoration: none;
          display: inline-block;
          font-size: 16px;
          text-align: center;
          border-radius: 50px;
        }
        
        button:hover{
            cursor: pointer;
        }
    </style>
    <body>
        <h1 style = "background-color: #CFCFCF; border: 5px solid grey; text-align:center;"> Employee Page</h1>
        <div class="login-btn">
            <button class = "loginbtn" type="button" onclick="document.location='logout.php'">Logout</button>
        </div>  
        
        
        <h2 style = "padding-top: 30px;"> List of cases assigned to you </h2>
        <p style="border: 5px solid grey; text-align:center; padding: 10px;">
        <?php
        
            
            //query orders currently assigned to the given admin 
            $sql_select_orders = "SELECT * FROM ORDERS WHERE orderID IN ";
            $sql_get_emp_orders = "(SELECT orderID FROM HAS_ORDER WHERE employeeID ="."'".employeeID."')";
            $result_orders = $conn->query($sql_select_orders.$sql_get_emp_orders);
            
            if ($result_orders->num_rows > 0) {

                //output query results by row
                echo "<table>";
                echo '<th> <td>orderID</td> <td>ordered_date</td> <td>status</td> </th>';
                while($row = $result_orders->fetch_assoc()) {
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
    
    
    
    
    
    
    <body>
        <h1 style = "padding-top: 30px;"> Change Case Status </h1>
        
        <form method="post" style="border: 5px solid grey; text-align:center; padding: 10px;">
           <h4> Select a case, and the state you wish to assign:<br></h4>
            
            pick status value: 
                <label for="complete">complete</label>
                <input type="radio" id="complete" name="status" value="1">
                <label for="incomplete">incomplete</label>
                <input type="radio" id="incomplete" name="status" value="0">
            <br>
            <br>
            On orderID:
                <label for="orderID"></label><br>
                <input type="text" id="orderID" name="orderID">
                
            <input type="submit" name="submit" value="submit assignment">
        </form>
        
        <?php
            $orderID=$_POST['orderID'];
            $status=$_POST['status'];
            
            $sql_change_status="UPDATE ORDERS SET status = $status WHERE orderID = '$orderID'";
            $conn->query($sql_change_status);
            
            echo "<br> New order state: <br>";
            
            $sql_get_order = "SELECT * FROM ORDERS WHERE orderID='$orderID'";
            $result_update = $conn->query($sql_get_order);
            
            if ($result_update->num_rows > 0) {
                //output query results by row
                echo "<table>";
                echo '<th> <td>orderID</td> <td>ordered_date</td> <td>status</td> </th>';
                while($row = $result_update->fetch_assoc()) {
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
        
        
    </body>
    
    
    
    
</html>