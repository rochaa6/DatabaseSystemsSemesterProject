<?php 
session_start();

include("config.php");

if($_SERVER['REQUEST_METHOD'] == "POST"){
  $fname = $_POST['fname'];
  $lname = $_POST['lname'];
  $email = $_POST['email'];
  $username = $_POST['username'];
  $password = $_POST['password'];
  $confirmpassword = $_POST['confirmpassword'];

    $hashedpwd = password_hash($password, PASSWORD_DEFAULT);

  if (!empty($username) && !empty($password) && !is_numeric($username)){
    
    $query_head= "INSERT INTO CUSTOMER VALUES";
    $query_tail="('$username', '$hashedpwd', '$email', '$fname', '$lname')";
    $conn->query($query_head.$query_tail);
    
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
    $sql_new_cart = "INSERT INTO CART VALUES( ".$new_cartID.", '".$username."')";
    $conn->query($sql_new_cart);
    
    header("Location: login.php");
    die;
  }
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Registration</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">


	
</head>
<body>
	<div class='container'>
		<div class='row'>
			<div class='col-md-12'>
				<h2></h2>
			</div>

			<div class='col-md-6' >
					
				<form method='post' action=''>

					<h1>SignUp</h1>
					<?php 
					// Display Error message
					if(!empty($error_message)){
					?>
						<div class="alert alert-danger">
						  	<strong>Error!</strong> <?= $error_message ?>
						</div>

					<?php
					}
					?>

					<?php 
					// Display Success message
					if(!empty($success_message)){
					?>
						<div class="alert alert-success">
						  	<strong>Success!</strong> <?= $success_message ?>
						</div>

					<?php
					}
					?>
				
					<div class="form-group">
					    <label for="fname">First Name:</label>
					    <input type="text" class="form-control" name="fname" id="fname" required="required" maxlength="80">
					</div>
					<div class="form-group">
					    <label for="lname">Last Name:</label>
					    <input type="text" class="form-control" name="lname" id="lname" required="required" maxlength="80">
					</div>
					<div class="form-group">
					    <label for="email">Email address:</label>
					    <input type="email" class="form-control" name="email" id="email" required="required" maxlength="80">
                    </div>
                    <div class="form-group">
					    <label for="lname">Username</label>
					    <input type="text" class="form-control" name="username" id="username" required="required" maxlength="80">
					</div>
					<div class="form-group">
					    <label for="password">Password:</label>
					    <input type="password" class="form-control" name="password" id="password" required="required" maxlength="80">
					</div>
					<div class="form-group">
					    <label for="pwd">Confirm Password:</label>
					    <input type="password" class="form-control" name="confirmpassword" id="confirmpassword" required="required" maxlength="80">
					</div>
					
                    <button type="submit" name="btnsignup" class="btn btn-default">Submit</button>
                    
                    <p>Already have an account? <a href="login.php">Login Here</a>.</p>

				</form>
			</div>
			
			
		</div>
	</div>
</body>
</html>