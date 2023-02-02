<?php
session_start();
include 'auth.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Owner Page</title>

    <link rel="stylesheet" href="css/index.css">
    
    <style>
    
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
    h1{
    background-color: #CFCFCF; 
    border: 5px solid grey; 
    text-align:center;
    margin: 50px;
    font-size: 50px;
    }
    
    </style>
</head>
<html>
    <?php
        $servername = "localhost";
        $dbUsername = "rochaa6_Admin1";
        $dbPass = "Baseball97!";
        $dbName = "rochaa6_beatlesMerch";

    ?>
    <body>
        <h1>Owner Page</h1>
        <div class="login-btn">
                <button class = "loginbtn" type="button" onclick="document.location='logout.php'">Logout</button>
        </div>
        <br>
        <?php
        // Create/check connection
        $conn = new mysqli($servername, $dbUsername, $dbPass, $dbName);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        ?>
        
        <?php
            echo "<h6> curent user: ".$_SESSION['user']." <h6>";
        ?>





        <!-- form action to call search page -->
        <form method="post" style="border: 5px solid grey; text-align:center; padding: 10px;">
            Select a category to search:<br>
            <select name="searchtype">
                <option value="name">name</option>
                <option value="genre">genre</option>
                <option value="itemID">ID</option>
            </select>
            <br>
            Enter Query:<br />
            <input name="searchterm" type="text" size="40">
            <br />
            <input type="submit" name="submit" value="input search keyword">
        </form>
        
        <!-- define/retrieve search input -->
        <?php
            // create short variable names
            $searchtype = $_POST["searchtype"];
            $searchterm = trim($_POST["searchterm"]);
            // define SQL query, and get result
            
            $sql_search = "SELECT * FROM PRODUCT WHERE ".$searchtype."="."'".$searchterm."'";
            echo "<br><br>";
            $result = $conn->query($sql_search);


            if ($result->num_rows > 0) {
                $count=0;
                //output query results by row
                echo '<div style="height: 150px; overflow: auto">';
                echo '<table style="height: 400px">';
                echo '<th> <td>itemID</td> <td>name</td> <td> genre </td> <td>stock</td> <td>cost</td> <td>desc</td> </th>';
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    foreach ($row as $key => $value){
                        echo "<td>".$value."</td>";
                    }
                    echo "</tr>";
                    $count+=1;
                }
                echo "</table>";
                echo "</div>";
            } 
            else {
                //displays "0 results" if nothing matched
                echo "<br><br> 0 results";
            }
        ?>
        
        <br><br><br>
        
         <!-- form action to change product info -->
        <form method="post" style="border: 5px solid grey; text-align:center; padding: 10px;">
            
            Enter product ID:<br>
            <input name="product_ID" type="text" size="40">
            <br>
            
            Change a products attribute :<br>
            <select name="product_attribute">
                <option value="stock">stock</option>
                <option value="cost">cost</option>
            </select>
            <br>
            
            Enter new attribute value:<br>
            <input name="new_value" type="text" size="40">
            <br>
            
            <input type="submit" name="submit" value="query update">
            
        </form>
        
        
        <!-- print old version of product to screen --!>
        <?php
            $product_ID = $_POST["product_ID"];
            $product_attribute = trim($_POST["product_attribute"]);
            $new_value = $_POST["new_value"];
            
            if ( ($product_ID != null) and ($product_attribute != null) and ($new_value != null) ){
                echo "<br><br>old version:";
            
                $sql_find_original = "SELECT * FROM PRODUCT WHERE itemID"."=".$product_ID;
                echo "<br>";
                $result_original = $conn->query($sql_find_original);
            
                if ($result_original->num_rows > 0) {
                    $count=0;
                    //output query results by row
                    echo "<table>";
                    echo '<th><td>itemID</td> <td>name</td> <td> genre </td> <td>stock</td> <td>cost</td> <td>desc</td> </th>';
                    while($row = $result_original->fetch_assoc()) {
                        echo "<tr>";
                        foreach ($row as $key => $value){
                            echo "<td>".$value."</td>";
                        }
                        echo "</tr>";
                        $count+=1;
                    }
                    echo "</table>";
                } 
                else {
                   //displays "0 results" if nothing matched
                  echo "<br><br> 0 results";
                }
            
            
            
            
                echo "<br><br><br>New Version:<br>";

                $sql_product_update="UPDATE PRODUCT SET ".$product_attribute."=".$new_value." WHERE itemID = ".$product_ID;
                echo $sql_product_update;
                $conn->query($sql_product_update);
            
                $sql_find_updated= "SELECT * FROM PRODUCT WHERE itemID =".$product_ID;
                echo "<br><br>";
                $result_updated = $conn->query($sql_find_updated);
            
            
                if ($result_updated->num_rows > 0) {
                    $count=0;
                    //output query results by row
                    echo "<table>";
                    echo '<th> <td>itemID</td> <td>name</td> <td> genre </td> <td>stock</td> <td>cost</td> <td>desc</td> </th>';
                    while($row = $result_updated->fetch_assoc()) {
                        echo "<tr>";
                    
                        foreach ($row as $key => $value){
                            echo "<td>".$value."</td>";
                        }
                        echo "</tr>";
                        $count+=1;
                    }
                    echo "</table>";
                } 
                else {
                    //displays "0 results" if nothing matched
                    echo "<br><br> 0 results";
                }
            }
            else {
                echo "invalid input; try again";
            }
            
        ?>    
            
       
        <!-- input a new product-->
        <form method="post" style="border: 5px solid grey; text-align:center; padding: 10px;">
            <br>Input a new product:<br><br>
            <label for="name">name:</label>
            <input type="text" id="name" name="name">
            <br>
        
            genre: 
            <input type="radio" id="vinyl" name="genre" value="vinyl">
            <label for="vinyl">vinyl</label>
            <input type="radio" id="cd" name="genre" value="cd">
            <label for="cd">cd</label>
            <input type="radio" id="apparel" name="genre" value="apparel">
            <label for="apparel">apparel</label>
            <input type="radio" id="poster" name="genre" value="poster">
            <label for="poster">poster</label>
            <input type="radio" id="misc" name="genre" value="misc">
            <label for="misc">misc</label>
            <br>
         
            <label for="stock">stock:</label>
            <input type="number" id="stock" name="stock" min="0">
            <br>
        
            <label for="cost">cost:</label>
            <input type="number" id="cost" name="cost" min="0">
            <br>
        
            <label for="desc_path" align = "right">description:</label>
            <textarea type="text" id="desc_path" name="desc_path" cols = "25" rows = "10"></textarea>
            <br>
        
            
            <input type="submit" name="submit" value="query update">
            
        </form>
        
        <?php
            //its bad to allow the user to assign an ID, so we
            //use an algorithm to assign it on the back end
            
            //1. query all of the IDs
            //2. input those IDs into a regular php array
            //3. sort that array so the largest element is at the 0th place
            //4. set the ID to the 0th place + 1
            
            //query to find new ID
            $sql_find_itemID = "SELECT itemID FROM PRODUCT";
            $result_itemIDs = $conn->query($sql_find_itemID);
            
            //get/build itemID array
            $itemID_array=array();
            while($row = $result_itemIDs->fetch_assoc()) {
                foreach ($row as $key => $value){
                    $itemID_array[count($itemID)]=$value;
                }
            }
            
            //sort array
            rsort($itemID_array);
            
            $itemID = ($itemID_array[0]+1);
            $name = $_POST["name"];
            $genre=$_POST["genre"];
            $stock=$_POST["stock"];
            $cost=$_POST["cost"];
            $desc_path=$_POST["desc_path"];


            // //input product
            $sql_input_prodcut= "INSERT INTO PRODUCT VALUES( ".$itemID.", '".$name."', '".$genre."', ".$stock.", ".$cost.", '".$desc_path."', '".$phot_path."');";
            $conn->query($sql_input_prodcut);
            
           
            
            //search and print query, to show things worked:
            $sql_find_new_input= "SELECT * FROM PRODUCT WHERE itemID =".$itemID;
            echo "<br><br>";
            $result_input = $conn->query($sql_find_new_input);
            
            if ($result_input->num_rows > 0) {
                //output query results by row
                echo "<table>";
                echo '<th> <td>itemID</td> <td>name</td> <td> genre </td> <td>stock</td> <td>cost</td> <td>desc</td> </th>';
                while($row = $result_input->fetch_assoc()) {
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
        
        
        
        <?php
            $conn->close();
        ?>
        
    </body>
</html>