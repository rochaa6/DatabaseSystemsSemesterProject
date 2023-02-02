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
        
        h1{
            text-align: center;
        }
    </style>
    
    <body>
        <div tyle= "text-align: center;">
            <h1 style= "background-color: #CFCFCF; border: 5px solid grey; text-align:center;"> Employee Status Page</h1>
            <a href="admin_page.html" style= "border:5px solid grey; text-align: center;" >Admin Homepage</a>
        </div>
    </body>
    
    
    
    
    <body>
        <h1> Turn Customer Into User </h1>
        
        <form method="post" style="border: 5px solid grey; text-align:center; padding: 10px;">
            Select Category to Search by:<br>
            <br>
            
            Pick Staff Category:
                <label for="employee">Employee</label>
                <input type="radio" id="employee" name="cus_2_staf" value="employee">
                <label for="admin">Admin</label>
                <input type="radio" id="admin" name="cus_2_staf" value="admin">
            <br>
            <br>
            On Customer:
                <label for="username_customer"></label>
                <input type="text" id="username_customer" name="username_customer">
            
                
            <input type="submit" name="submit" value="submit assignment">
        </form>
        
        <br>

        <?php
            $username_customer=$_POST['username_customer'];
            $cus_2_staf=$_POST['cus_2_staf'];
            echo $username_customer."  ".$cus_2_staf;


            //query customer data + gets array of all the customers data        
            $sql_get_cus_vals="SELECT * FROM CUSTOMER WHERE username = '".$username_customer."'";
            $result_customer = $conn->query($sql_get_cus_vals);
            
            $uservals_array=array();
            while($row = $result_customer->fetch_assoc()) {
                foreach ($row as $key => $value){
                    $uservals_array[$key]=$value;
                }
            }


            echo "<br><br>";
            echo "old customer data:";
            if ($result_customer->num_rows > 0) {
                //output query results by row
                echo "<table>";
                echo '<th> <td>uname</td> <td>code</td> <td>email</td> <td>f_name</td> <td>l_name</td></th>';
                while($row = $result_customer->fetch_assoc()) {
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


            $v1="'".$uservals_array['username']."'";
            $v2="'".$uservals_array['password']."'";
            $v3="'".$uservals_array['email']."'";
            $v4="'".$uservals_array['f_name']."'";
            $v5="'".$uservals_array['l_name']."'";

            $sql_create_staff="INSERT INTO STAFF VALUES( ".$v1.", ".$v2.", ".$v3.", ".$v4.", ".$v5.", '".$cus_2_staf."' )";
            $conn->query($sql_create_staff);
            echo "<br>".$sql_create_staff;
            //$conn->query($sql_get_cus_vals);

            $sql_delete_customer="DELETE FROM CUSTOMER WHERE username = ".$v1;
            $conn->query($sql_delete_customer);
            echo "<br>".$sql_delete_customer;
            //$conn->query($sql_get_cus_vals);
            
            $sql_manage_staff="INSERT INTO MANAGES VALUES( '".adminID."', ".$v1." )";
            $conn->query($sql_manage_staff);
            echo "<br>".$sql_manage_staff;
            //$conn->query($sql_manage_staff);
        ?>
    </body>
    
    
    
    
    <body >
        <h2> List of employees you manage:</h2>
        <p style="border: 5px solid grey; text-align:center; style= padding: 10px;">
        <?php
            
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
    
    
    
    
    <body>
        <h1>Switch Staff-Type</h1>
        
        <form method="post" style="border: 5px solid grey; text-align:center; padding: 10px;">
            Change a staff Memebers level :<br>
            <br>
            
            Pick Staff Category: 
                <label for="owner">owner</label>
                <input type="radio" id="owner" name="staff_change" value="owner">
                <label for="admin">admin</label>
                <input type="radio" id="admin" name="staff_change" value="admin">
            <br>
            <br>
            
            On Staff Member:
                <label for="staff_username"></label>
                <input type="text" id="staff_username" name="staff_username">
                
            <input type="submit" name="submit" value="submit assignment">
        </form>
        
        
        
        
        
        <?php
            $staff_change="'".$_POST['staff_change']."'";
            $staff_username="'".$_POST['staff_username']."'";
            
            $sql_class_change = "UPDATE STAFF SET staff_group = ".$staff_change." WHERE username = ".$staff_username;
            $conn->query($sql_class_change);
            echo "<br>".$sql_class_change;
            
            switch( $staff_change ){
                case "'owner'":
                    $sql_manage_update = "UPDATE MANAGES SET managerID = ".$staff_username." WHERE userID = ".$staff_username;
                    break;
                case "'admin'":
                    $sql_manage_update = "UPDATE MANAGES SET managerID = "."'owner'"." WHERE userID = ".$staff_username;
                    break;
                default:
                    echo "something went wrong";
            }
            
            echo "<br>".$sql_manage_update;
            
            $conn->query($sql_manage_update);
        ?>
        
        
        
        
        
        
        </p>
    </body>
    
    <?php
        $conn->close();
    ?>
    
    
</html>