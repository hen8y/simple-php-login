<?php
include 'config.php';

if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Check if email is empty
    if(empty(trim($_POST["email"]))){
        $email_err = "Please enter email.";
    } else{
        $email = trim($_POST["email"]);
    }
    
    
    if(empty($email_err) ){
        // Prepare a select statement
        $sql = "SELECT email FROM users WHERE email = ?";
        
        
        if($stmt = mysqli_prepare($link, $sql)){
                // Bind variables to the prepared statement as parameters
                mysqli_stmt_bind_param($stmt, "s", $param_email);
                
                // Set parameters
                $param_email = $email;  
                
             if(mysqli_stmt_execute($stmt)){
                    // Store result
                    mysqli_stmt_store_result($stmt);
                    
                    // Check if email exists, if yes then verify password
                    if(mysqli_stmt_num_rows($stmt) == 1){      
                         session_start();
                         // Store data in session variables
                        $_SESSION["email"] = $email;  
                          
                      header("location:send.php");;
                    }elseif (mysqli_stmt_num_rows($stmt) == 0){
                        $email_err = "Email doesn't Exist";
    
                } else{
                    echo "Oops! Something went wrong. Please try again later.";
                }
            
    
                // Close statement
                mysqli_stmt_close($stmt);
            }
        }
    
    // Close connection
    mysqli_close($link);
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SharedSub | Reset Password</title>

    <style>
    *{
        padding: 0;
        margin: 0;
        box-sizing: border-box;
    }
    body{
        background-color: #fff;
        color: #001737;
        font-family: "Karla", sans-serif;
        padding-top: 30px;


    }
    a{
        text-decoration: none;
        color: #0150AB;
    }

    .container{
        width: 400px;
        height: 95vh;
        background-color: #F4F7FA;
        margin: auto;
        border-radius: 20px;
        border: 1px #E4E6F6 solid;
        padding: 30px;
        box-shadow:   0 2.8px 2.2px rgba(0, 0, 0, 0.034), 0 6.7px 5.3px rgba(0, 0, 0, 0.048), 0 12.5px 10px rgba(0, 0, 0, 0.06), 0 22.3px 17.9px rgba(0, 0, 0, 0.072),  0 41.8px 33.4px rgba(0, 0, 0, 0.086), 0 100px 80px rgba(0, 0, 0, 0.12);
    }
    @media only screen and (max-width:450px) {
     .container{
        width: 90%;
        background-color: #F4F7FA;
        margin: auto;
        padding: 30px 10px 30px 10px;
    }
}
    form{
            width: 100%;
            color: #2f2f30;
            margin-top: 100px;
        }
    .package-btn{
        width: 94%;
        height:55px;
        background-color: #0150AB;
        color: #fff;
        border: none;
        border-radius: 5px;
        font-size: 17px;
        margin-top: 45px;
        padding: 10px;
        font-weight: bold;
        margin-bottom: 10px;
        box-shadow: 2px 5px 9px rgba(0, 0, 0, 0.12);

    }
    .package-sev:focus{
        outline: none;
    }
    .package-sev{
        width: 94%;
        height:58px;
        background-color: #fff;
        color: #0150AB;
        border: none;
        border-radius: 5px;
        font-size: 15px;
        margin-top: 10px;
        padding: 20px;
        border: #E4E6F6 1px solid;
        margin-bottom: 10px;
        box-shadow: 2px 5px 9px rgba(0, 0, 0, 0.12);

    }
    .package-btn:hover {
        background-color: #38383b;
        color: #fff;
    }
    .head1{
        font-size: 27px;
        font-weight: bold;
        margin:14px;
    }

    .reset{
        width: 20%;
        margin: auto;
    }
    
    
    .invalid-feedback{
        color:red;
    }
    </style>
</head>
<body>
    <div class="container">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <center>
                    <img src="reset.png" alt="reset password" class="reset">
                    <br><p class="head1">Reset Password</p>
                    <p style="font-size: 14px;float: center;margin-right: 11px;"> Enter details of the account you the password changed</p><br>
                    
                    <input name="email" id="" class="package-sev <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>" type="text" placeholder="Enter email address">
                    <span class="invalid-feedback"><?php echo $email_err; ?></span>

                </center>
                <br>
                <center><button class="package-btn" >Next</button></center>
        </form>

    </div>

</body>
</html>