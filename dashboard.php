<?php

require 'assets/php/.config.php';

// Connect with the database
$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// check if user is logged in
session_start();


// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || $_SESSION["admin"] !== true){
    header("location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Projects - Tijn Rodrigo</title>

    <link rel="stylesheet" href="assets/css/style.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <noscript>
      <meta http-equiv="refresh" content="0; url=nojs.html">
    </noscript>
</head>
<body>
    <div class="projects">
        <div class="content">
            <h2 class="title">Dashboard</h2>
            <p class="center">Hieronder vind je een overzicht van mijn projecten.</p>
            <div class="center">
                <a class="round-btn btn-no-hover-animation" href="./">Start</a>
                <a class="round-btn btn-no-hover-animation" href="logout.php">Log out</a>
            </div>
            <div class="hr_100"></div>
            <h2 class="title">Project Uploaden</h2>

            <form class="project-form" action="upload_project.php" method="post">
                <input type="text" name="title" placeholder="Titel" required>
                <input type="text" name="github" placeholder="Github Link">
                <textarea name="description" placeholder="Beschrijving" required cols="30" rows="10"></textarea>

                <label for="file-upload" class="custom-file-upload">
                    <i class="fas fa-cloud-upload-alt"></i> Choose File
                </label>
                <input id="file-upload" type="file" accept="image/*"/>

                <br>

                <button type="submit" name="submit" class="round-btn btn-no-hover-animation">Posten</button>

            </form>
        </div>
    </div>

    <footer>
    <p>Copyright &copy; <span id='year'></span> Tijn Rodrigo</p>
  </footer>

  <script src="assets/js/script.js"></script>
</body>
</html>