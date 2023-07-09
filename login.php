<?php
    session_start();

    // Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
        header("location: index.php");
        exit;
    }

    include('db.php');
    
$username = $password = "";
$username_err = $password_err = $login_err = "";


if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Check if username is empty
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter username.";
    } else{
        $username = trim($_POST["username"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }
     
         if(empty($username_err) && empty($password_err)){
            $username = $_POST['username'];
            $password = $_POST['password'];
            $query = $link->prepare("SELECT * FROM users WHERE username=:username");
            $query->bindParam("username", $username, PDO::PARAM_STR);
            $query->execute();
            $result = $query->fetch(PDO::FETCH_ASSOC);
            if (!$result) {
                $login_err = "Invalid username or password.";
            } else {
                if (password_verify($password, $result['password'])) {
                    $_SESSION['user_id'] = $result['id'];
                    $_SESSION["loggedin"] = true;
                    header('location:index.php');
                } else {
                    $login_err = "Invalid username or password.";
                }
            }
    }
    
    // Close connection
    mysqli_close($link);
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SharedSub | Login</title>

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
    .head{
        font-size: 27px;
        font-weight: bold;
        margin:10px;
    }
    .menu{
        bottom: 0;
        padding:5px;
        margin-bottom: 30px;
            
    }
    .cover{
        display:flex;
        justify-content:center;
        align-items:center;
    }
        form img {
        width:50%;
        margin-bottom:20px;
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
    .invalid-feedback{
        color:red;
    }
    </style>
</head>
<body>
    <div class="container">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <center>
                    <img src="img/netflix.png">
                    <br><p class="head">Hello There!</p>
                    <p style="font-size: 16px;float: center;margin-right: 11px;"> <i>Enter details to login</i></p><br>
                        <?php 
                        if(!empty($login_err)){
                            echo '<div class="alert-danger">' . $login_err . '</div>';
                        }        
                        ?>
                        <br>
                     <input type="text" name="username" class="package-sev <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>" placeholder="Enter username">
                    <span class="invalid-feedback"><?php echo $username_err; ?></span>

                    <input type="password" name="password" class="package-sev <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" placeholder="Password">
                <span class="invalid-feedback" ><?php echo $password_err; ?></span>
                </center>
                <br>
                <span style="font-size: 14px;font-weight: bold;float: right;margin-right: 11px;"><a href="password.php">Forgot password?</a></span>
                <center><button class="package-btn" name-"login" value="login" >Sign In</button></center>
        </form>
        <div class="cover">
            <div class="menu">
                <center> 
                    <span style="font-size: 14px;font-weight: bold;">Not a member? <a href="register.php">Sign Up</a></span>
                </center>
            </div>
        </div>
    </div><br><br>

</body>
</html>