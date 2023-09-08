<?php

require 'assets/php/.config.php';

// Connect with the database
$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
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
            <h2 class="title">Projecten</h2>
            <p class="center">Hieronder vind je een overzicht van mijn projecten.</p>
            <div class="center">
                <a class="round-btn btn-no-hover-animation" href="./">Terug</a>
            </div>
            <div class="hr_100"></div>
            <div class="grid">
            <?php

            $sql = "SELECT * FROM projects ORDER BY date_time DESC";

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

                $des = $row['description'];

                // limit the $des to 80 chars max
                if (strlen($des) > 80) {
                  $des = substr($des, 0, 80) . " ...";
                }


                $github = $row['github'];



                echo "<div class='project'>";
                echo "<img src='data:image/jpeg;base64,$img' draggable='false'>";
                echo "<h3>" . $row['title'] . "</h3>";
                echo "<p class='date'>" . $date . "</p>";
                echo "<div class='hr_50'></div>";
                echo "<p>" . $des ."</p>";
                echo "<div class='hr_100'></div>";
                echo "<a class='round-btn btn-no-hover-animation' href='display.php?id=" . $row['unique_id'] . "'>Bekijk</a>";
              
                echo "</div>";

              }
            } else {
              echo "<p class='center'>Er zijn geen projecten gevonden.</p>";
            }

            ?>
            </div>
        </div>
    </div>

    <footer>
    <p>Copyright &copy; <span id='year'></span> Tijn Rodrigo</p>
  </footer>

  <script src="assets/js/script.js"></script>
</body>
</html>