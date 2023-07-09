<?php
session_start();
include 'config.php';

if($_SERVER["REQUEST_METHOD"] == "POST"){
    
    
    if(empty(trim($_POST["newcode"]))){
        $newcode_err = "Please enter Code";
    } else{
        $newcode = trim($_POST["newcode"]);
    }
    
    if(empty(trim($_POST["new_password"]))){
        $new_password_err = "Please enter New Password";
    } elseif(strlen(trim($_POST["new_password"])) < 6){
        $new_password_err = "Password must have atleast 6 characters.";
    }else{
        $password = trim($_POST["new_password"]);
    }
    
    if(empty(trim($_POST["confirm_password"]))){
        $confirmpass_err = "Please enter Confirm Password";
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($new_password_err) && ($password  != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }
    
$newcode=$_POST['newcode'];
$code=$_SESSION['code'];
$email=$_SESSION['email'];
$password_hash = password_hash($password, PASSWORD_DEFAULT);
    

    if($code==$newcode&&empty($confirm_password_err)&&empty($new_password_err)){
           
            $ssql= "SELECT * FROM users WHERE email = '$email'";
            
            $result = mysqli_query($link,$ssql);
        if (mysqli_num_rows($result) > 0)
        while($row = mysqli_fetch_array($result))
        {
            
            
        $sql = "UPDATE users SET password='$password_hash' WHERE email='$email'";
                
                if(mysqli_query($link, $sql)){
                header('location:updated.php');
                } else{
                    echo "ERROR: Could not able to execute $sql";
                }
        }   
    }elseif($code!=$newcode){
        $login_err = "Code doesn't match";
    }else{
        $login_err =  "Ensure everything is correct";
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
        * {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
        }

        body {
            background-color: #fff;
            color: #001737;
            font-family: "Karla", sans-serif;
            padding-top: 30px;


        }

        a {
            text-decoration: none;
            color: #0150AB;
        }

        .container {
            width: 400px;
            background-color: #F4F7FA;
            margin: auto;
            border-radius: 20px;
            border: 1px #E4E6F6 solid;
            padding: 30px;
            box-shadow: 0 2.8px 2.2px rgba(0, 0, 0, 0.034), 0 6.7px 5.3px rgba(0, 0, 0, 0.048), 0 12.5px 10px rgba(0, 0, 0, 0.06), 0 22.3px 17.9px rgba(0, 0, 0, 0.072), 0 41.8px 33.4px rgba(0, 0, 0, 0.086), 0 100px 80px rgba(0, 0, 0, 0.12);
        }

        @media only screen and (max-width:450px) {
            .container {
                width: 90%;
                background-color: #F4F7FA;
                margin: auto;
                padding: 30px 10px 30px 10px;
            }
        }

        form {
            width: 100%;
            color: #2f2f30;
            margin-top: 50px;
            
        }

        .package-btn {
            width: 94%;
            height: 55px;
            background-color: #0150AB;
            color: #fff;
            border: none;
            border-radius: 5px;
            font-size: 17px;
            margin-top: 45px;
            padding: 10px;
            font-weight: bold;
            margin-bottom: 30px;
            box-shadow: 2px 5px 9px rgba(0, 0, 0, 0.12);

        }

        .package-sev:focus {
            outline: none;
        }

        .package-sev {
            width: 94%;
            height: 58px;
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

        .head1 {
            font-size: 27px;
            font-weight: bold;
            margin: 14px;
        }

        .reset {
            width: 20%;
            margin: auto;
        }
        .invalid-feedback{
        color:red;
        }
        .alert-danger{
        width:88%;
        height:40px;
        background-color:rgba(226, 128, 128, 0.438);;
        padding:8px;
        text-align:center;
        border:2px rgba(110, 19, 19, 0.932) solid;
        border-radius:3px;
    }
    </style>
</head>

<body>
    <div class="container">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" autocomplete="off">
            <center>
                <img src="reset.png" alt="reset password" class="reset">
                <br>
                <p class="head1">Reset Password</p>
                <p style="font-size: 14px;float: center;margin-right: 11px;"> Enter details of the account you the
                    password changed</p><br>
                    
                     <?php 
                        if(!empty($login_err)){
                            echo '<div class="alert-danger">' . $login_err . '</div>';
                        }        
                        ?>
                
                <input name="newcode" type="number" class="package-sev <?php echo (!empty($newcode_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $newcode; ?>"
                    placeholder="Enter the code sent to your email" maxlength="5" autocomplete="off">
                     <span class="invalid-feedback"><?php echo $newcode_err; ?></span>
                     
                     
                <input name="new_password" id="" class="package-sev <?php echo (!empty($new_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $new_password; ?>"  type="password" placeholder="Enter New Password" autoComplete="new-password">
                
                 <span class="invalid-feedback"><?php echo $new_password_err; ?></span>
                 
                <input name="confirm_password" id="" class="package-sev <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $confirm_password; ?>"  type="password" placeholder="Confirm Password" autocomplete="off">
            
                 <span class="invalid-feedback"><?php echo $confirmpass_err; ?></span>
            </center>
            <br>
            <center><button class="package-btn">Next</button></center>
        </form>

    </div>
    <br><br> <br>
</body>

</html>