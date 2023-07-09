<?php
session_start();
 
// Unset all of the session variables
$_SESSION = array();
 
// Destroy the session.
session_destroy();
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SharedSub | Password Updated</title>

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
    .form{
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
        width: 50%;
        margin: auto;
    }
    </style>
</head>
<body>
    <div class="container">
        <div class="form">
                <center>
                    <p class="head1">Password Updated</p><br>
                    <img src="update.png" alt="reset password" class="reset">
                    <br>
                    <br>
                    <p style="font-size: 14px;float: center;margin-right: 11px;font-style: italic;">Your account password was changed succeessfully</p><br>
                   <a href="login.php"> <button class="package-btn" >PROCEED TO LOGIN</button></a>
                </center>
            </div>

    </div>

</body>
</html>