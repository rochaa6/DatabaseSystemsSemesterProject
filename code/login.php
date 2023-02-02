<?php     
session_start;
   require("config.php");
   
   $username = $_POST['user'];
   $password = $_POST['pass'];
   $_SESSION['user'] = $username;
   $_SESSION['pass'] = $password;
   
    // customer query
   $sql_customer = "SELECT password FROM CUSTOMER WHERE username='$username'";
   $result_customer = $conn->query($sql_customer);
   $table_customer = mysqli_fetch_array($result_customer, MYSQLI_ASSOC);
   //echo "<h6> $sql_customer <br> customer try: ".$table_customer['password']."</h6><br><br>";
   
    if ($table_customer && password_verify($password, $table_customer['password'])){
        header("Location: homepage.php");
        exit();
    }
    
    // // // Mysql_num_row is counting the table rows
    // // $count=mysql_num_rows($table_customer);
    
    // // If the result matched $username and $password, the table row must be one row
    // if($table_customer == 1){
    //     session_start();
    //     $_SESSION['loggedin'] = true;
    //     $_SESSION['user'] = $username;
    // }

   
   
   // staff data
   $sql_staff = "SELECT passcode, staff_group FROM STAFF WHERE username='$username'";
   $result_staff = $conn->query($sql_staff);
   $table_staff = mysqli_fetch_array($result_staff, MYSQLI_ASSOC);
   //echo "<h6> $sql_staff <br> staff try: ".$table_staff['passcode']." ".$table_staff['staff_group']."</h6><br><br>";
   
    if ($table_staff && password_verify($password, $table_staff['passcode'])){
        
        $staff_group=$table_staff['staff_group'];
        switch ($staff_group){
            case "owner":
                header("Location: owner_page.php");
                exit();
                break;
            case "admin":
                header("Location: admin_page.html");
                exit();
                break;
            case "employee":
                header("Location: employee_page.php");
                exit();
                break;
        }
        exit();
    }
    

    

?>  

<html>  
<head>  
    <title>Login</title>  
    <!--// insert style.css file inside index.html  -->
    <link rel = "stylesheet" type = "text/css" href = "style.css">   

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">

</head>  
<body>  
    <div class = "container" id = "frm">  
        <div class="row">
            <div class='col-md-12'>
                    <h2>Login</h2>
            </div>  
            <div class="col-md-6">
                <form name="f1" action = "" onsubmit = "return validation()" method = "POST">  
                    <div class="form-group">
                        <label> UserName: </label>  
                        <input type = "text" class="form-control" id ="user" name  = "user" />  
                    </div>    
                    <div class="form-group"> 
                        <label> Password: </label>  
                        <input type = "password" class="form-control" id ="pass" name  = "pass" />  
                    </div>   
                    <div class="form-group">   
                        <input type =  "submit" id = "btn" value = "Login" />  
                    </div>  

                    <p>Dont have an Account? <a href="register.php">SignUp Here</a>.</p>

                </form>  
            </div>
        </div>
    </div>  
    <!-- validation for empty field -->
    
    

    <script>  
            function validation()  
            {  
                var id=document.f1.user.value;  
                var ps=document.f1.pass.value;  
                if(id.length=="" && ps.length=="") {  
                    alert("User Name and Password fields are empty");  
                    return false;  
                }  
                else  
                {  
                    if(id.length=="") {  
                        alert("User Name is empty");  
                        return false;  
                    }   
                    if (ps.length=="") {  
                    alert("Password field is empty");  
                    return false;  
                    }  
                }                             
            }  
    </script>  
</body>     
</html>  