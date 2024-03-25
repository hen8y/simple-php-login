<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$email = $_SESSION['email'];
$subject = "Reset Your Password";
$_SESSION['code'] = $code = substr(str_shuffle("1234567890"), 0, 5);
require 'PHPMailer-master/src/Exception.php';
require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';



//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;


//Load Composer's autoloader


//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings                     //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'xx.xxx.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'info@xx.xxx';                     //SMTP username
    $mail->Password   = 'xxxxx';                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('mail@xxx.org','xxxx');
    $mail->addAddress($email); 

  
    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = $subject;
    $mail->Body    =  "
                        <!DOCTYPE html>
                        <html lang='en'>
                        <head>
                            <meta charset='UTF-8'>
                            <meta http-equiv='X-UA-Compatible' content='IE=edge'>
                            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                        </head>
                        <body style='margin: 0px;padding: 0px;font-family:sans-serif; background-color: #f2f2f2;color: #212B36;  font-style: italic;font-weight: 300;height:auto'><br><br>
                            <div style='width: 260px;height: auto;  background-color: #fff; padding: 30px; margin: auto;padding: 30px;''>
                                <br><br>
                                <div style='margin-bottom: 20px;'>
                                    <p style='font-size:14px;'>Your Password reset code is </p>
                                    <p style='font-size:27px;'>$code</p>
                                </div>
                                <br><br>
                            </div><br><br>
                        </body>
                        </html>
        ";
    $mail->AltBody = '';
    


    $mail->send();
   header("Location:reset.php");
    

} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
?>
