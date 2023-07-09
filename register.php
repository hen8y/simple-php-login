<?php
    session_start();
    include('db.php');

    // Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
        header("location: index.php");
        exit;
        
} else{
// Define variables and initialize with empty values
$username = $email = $password = $confirm_password = "";
$username_err = $email_err = $password_err = $confirm_password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate email
    if(empty(trim($_POST["email"]))){
        $email_err = "Please enter an email.";
    }else{
       $email = trim($_POST["email"]);
    }
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter a username.";
    }elseif(!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["username"]))){
        $username_err = "Username can only contain letters, numbers, and underscores.";
    }
    else{
       $username = trim($_POST["username"]);
    }
    
    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Password must have atleast 6 characters.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password.";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }
    
    // Check input errors before inserting in database
    if(empty($email_err) && empty($password_err) && empty($confirm_password_err)){
         $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        $query = $link->prepare("SELECT * FROM users WHERE email=:email");
        $query->bindParam("email", $email, PDO::PARAM_STR);
        $query->execute();
        if ($query->rowCount() > 0) {
            $register_err = 'The email address is already registered!</p>';
        }
        if ($query->rowCount() == 0) {
            $query = $link->prepare("INSERT INTO users(username,password,email) VALUES (:username,:password_hash,:email)");
            $query->bindParam("username", $username, PDO::PARAM_STR);
            $query->bindParam("password_hash", $password_hash, PDO::PARAM_STR);
            $query->bindParam("email", $email, PDO::PARAM_STR);
            $result = $query->execute();
            if ($result) {
                    header('location:registersuccess.php');
            } else {
                $register_err = "Something went wrong";
            }
        }
    }
    
    // Close connection
    mysqli_close($link);
}}
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SharedSub | Register</title>

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
            margin-top: 50px;
        }
    .package-btn{
        width: 94%;
        height:55px;
        background-color: #0150AB;
        color: #fff;
        border: none;
        border-radius: 5px;
        font-size: 17px;
        margin-top: 36px;
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
    .head{
        font-size: 22px;
        font-weight: bold;
        margin:10px;
    }
    .menu{
        bottom: 0;
        padding:5px;
        margin-bottom: 20px;
            
    }
    .cover{
        display:flex;
        justify-content:center;
        align-items:center;
    }
    form img{
        width:50%
    }
    .alert-danger{
        width:88%;
        height:40px;
        background-color:rgba(226, 128, 128, 0.438);;
        padding:8px;
        text-align:center;
        border:2px rgba(110, 19, 19, 0.932) solid;
        border-radius:3px;
        font-size:13px;
    }
    .invalid-feedback{
        color:red;
    }
    </style>
</head>
<body>
    <div class="container">
        <form  method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" autocomplete="off">
                <center>
                    <img src="img/netflix.png">
                    <br><p class="head">Sign Up</p>
                     <?php 
                        if(!empty($register_err)){
                            echo '<div class="alert-danger">' . $register_err . '</div>';
                        }        
                        ?>
                <input type="email" name="email" class="package-sev <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>" placeholder="Enter your  email">
                <span class="invalid-feedback"><?php echo $email_err; ?></span>

                 <input type="text" name="username" class="package-sev <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>" placeholder="Enter your preferred username">
                <span class="invalid-feedback"><?php echo $username_err; ?></span>

                <input type="password" name="password" class="package-sev <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>" placeholder="Password">
                <span class="invalid-feedback" autoComplete="new-password"><?php echo $password_err; ?></span>

                <input type="password" name="confirm_password" class="package-sev <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $confirm_password; ?>" placeholder="Confirm Password">
                <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>


                </center>
                <br>
                <center><button class="package-btn" name="register" value="register" >Sign Up</button></center>
        </form>
        <div class="cover">
            <div class="menu">
                <center> 
                    <span style="font-size: 14px;font-weight: bold;">Already a member? <a href="login.php">Sign In</a></span>
                </center>
            </div>
        </div>
    </div>

</body>
</html>