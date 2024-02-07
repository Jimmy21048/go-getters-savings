<?php
 
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
 
//required files
require 'mailer/src/Exception.php';
require 'mailer/src/PHPMailer.php';
require 'mailer/src/SMTP.php';
 
//Create an instance; passing `true` enables exceptions
if (isset($sent)) {
 
  $mail = new PHPMailer(true);
 
    //Server settings
    $mail->isSMTP();                              //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';       //Set the SMTP server to send through
    $mail->SMTPAuth   = true;             //Enable SMTP authentication
    $mail->Username   = 'gogetters716@gmail.com';   //SMTP write your email
    $mail->Password   = 'wuvrepvtgeatkhpg';      //SMTP password
    $mail->SMTPSecure = 'ssl';            //Enable implicit SSL encryption
    $mail->Port       = 465;                                    
 
    //Recipients
    $mail->setFrom( 'gogetters716@gmail.com', "GO GETTERS"); // Sender Email and name
    $mail->addAddress($email);     //Add a recipient email  
    $mail->addReplyTo("gogetters716@gmail.com", "GO GETTERS"); // reply to sender email
 
    //Content
    $mail->isHTML(true);               //Set email format to HTML
    $mail->Subject ="GO GETTERS CHAMA GROUP";   // email subject headings
    $mail->Body    = "Congratulation, you have been approved as a member of the go getters chama group. Please Login into your account"; //email message
      
    // Success sent message alert
    $mail->send();
    echo
    " 
    <script> 
     alert('Message was sent successfully!');
     document.location.href = 'index.php';
    </script>
    ";
}