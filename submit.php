<?php

require 'assets/php/.config.php';

$name = $_POST['name'];
$email = $_POST['email'];
$subject = $_POST['subject'];
$message = $_POST['message'];

$ip = $_SERVER['REMOTE_ADDR'];
$browser = $_SERVER['HTTP_USER_AGENT'];


// if the name, email or message is empty, redirect to index.php
if ($name == "" || $email == "" || $message == "") {
    header("refresh:0; url=./#contact");
    die();
}


// Check if any fields contain <script> tags
if (preg_match('/<script>/', $name) || preg_match('/<script>/', $email) || preg_match('/<script>/', $subject) || preg_match('/<script>/', $message)) {
  
    // If it does contain <script> tags, alert that it's not allowed
    echo "<script>alert('Het is niet toegestaan om <script> tags te gebruiken!')</script>";
    header("refresh:0; url=./#contact");
    die();
}
?>

<!DOCTYPE html>
<html lang="en">
<head
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tijn Rodrigo</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
    <noscript>
      <meta http-equiv="refresh" content="0; url=nojs.html">
    </noscript>
</head>
<body>
  <nav class="navbar">
    <div class="content">
      <div class="logo">
        <a href="./">Tijn <span class="crimson">Rodrigo</span></a>
      </div>
      <ul class="menu-list">
        <div class="icon cancel-btn">
          <i class="fas fa-times"></i>
        </div>
        <li><a href="./">Home</a></li>
        <li><a href="./#about">Over Mij</a></li>
        <li><a href="./#contact">Contact</a></li>
      </ul>
      <div class="icon menu-btn">
        <i class="fas fa-bars"></i>
      </div>
    </div>
  </nav>
  <div class="banner">
    <div class="content">
      <?php

    require 'PHPMailer/src/PHPMailer.php';
    require 'PHPMailer/src/SMTP.php';
    require 'PHPMailer/src/Exception.php';

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;


    $body = "Name: $name <br> Email: $email <br> Subject: $subject <br> Message: $message <br> <br> IP: $ip <br> Browser: $browser";

    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();                                  
        $mail->Host       = 'smtp.gmail.com';           
        $mail->SMTPAuth   = true;                        
        $mail->Username   = $smtpUser;                    
        $mail->Password   = $smtpPass;       
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;          
        $mail->Port       = 465;

        $mail->setFrom('tijnrodrigo.portfolio@gmail.com', 'Portfolio site');
        $mail->addAddress('formsubmit0182@gmail.com'); 
    
        $mail->isHTML(true);

        if ($subject == "") {
            $mail->Subject = 'Contact form submission';
        } else {
            $mail->Subject = $subject;
        }
      
        $mail->Body = $body;
     
        $mail->send();
        echo "<h1 class='title'>Oké dan 💯</h1>";
        echo "<p>Je bericht is verstuurd, $name! Ik neem snel contact met je op!</p>";
        echo "<a href='./' class='btn'>Ga terug</a>";
      } 
      catch (Exception $e) {
        echo "<h1 class='title'>Oeps, er ging iets mis </h1>";
        echo "<p>Sorry $name, maar er ging iets mis met het versturen van je bericht, probeer het later opnieuw.</p>";
        echo "<a href='./#contact' class='btn'>Probeer opnieuw</a>";
      }
      ?>
    </div>
  </div>
  <script src="assets/js/nav.js"></script>
</body>
</html>