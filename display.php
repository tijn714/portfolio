<?php

require 'assets/php/.config.php';

// Connect with the database
$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// get the url parameter example = display.php?TEST3
$unique_id = $_GET['id'];

// get the project from the database
$sql = "SELECT * FROM projects WHERE unique_id = '$unique_id'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
  while ($row = mysqli_fetch_assoc($result)) {
    // use the img from the BLOB and convert it to base64
    $img = base64_encode($row['img']);

    // if no img is found use the default img
    if ($img == "") {
      $img = base64_encode(file_get_contents("assets/img/placeholder.png"));
    }

    // Convert the date_time to only the date in the format of dd/mm/yyyy
    $date = date_create($row['date_time']);
    $date = date_format($date, "d/m/Y");
    $link = "./";
    $des = $row['description'];
    $title = $row['title'];
    $github = $row['github'];
    $unique_id = $row['unique_id'];
  }
} else {
  $title = "Project niet gevonden";
  $des = "Er is geen project gevonden met id: " . $unique_id;
  $link = "./";

  // change page style to error
  echo "<style>";
}


?> 

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project - Tijn Rodrigo</title>

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
                <?php
            
            echo "<h2 class='title'>$title</h2>";
            echo "<p class='center'>$date</p>";
            echo "<div class='hr_100'></div>";
            echo "<div class='center'>";
            echo "<img src='data:image/jpeg;base64,$img' alt='project img'>";
            echo "</div>";
            echo "<p class='center'>$des</p>";
            echo "<div class='hr_100'></div>";
            echo "<div class='center'>";
            echo "<a class='round-btn btn-no-hover-animation' href='$link'>Terug</a>";

            if ($github != "") {
                echo "<a class='round-btn btn-no-hover-animation' href='$github'>Github</a>";
            }
            echo "</div>";
                ?>
        </div>
    </div>
</body>
</html>