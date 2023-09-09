<?php

require 'assets/php/.config.php';

// Connect with the database
$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>


<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tijn Rodrigo</title>

    <link rel="stylesheet" href="assets/css/style.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

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
          <li><a href="./" class="menu-item">Start</a></li>
          <li><a href="./#about" class="menu-item">Over Mij</a></li>
          <li><a href="./#projects" class="menu-item">Projecten</a></li>
          <li><a href="./#contact" class="menu-item">Contact</a></li>
      </ul>
      <div class="icon menu-btn">
        <i class="fas fa-bars"></i>
      </div>
    </div>
  </nav>
  <div class="banner">
    <div class="content">
      <h1 class="title">Tijn <span class="crimson">Rodrigo</span></h1>
      <p>Welkom op mijn Portfolio!</p>
      <div class="btns">
        <a href="#about" class="btn">Over Mij</a>
      </div>

      <div class="particles" id="particles-js"></div>
    </div>
  </div>

  <div class="about" id="about">
    <div class="content">
        <div class="grid">
          <div class="col">
            <img class="profile-picture" src="assets/img/tijn.jpeg" draggable="false">
          </div>

          <div class="col">
            <h1>Tijn <span class="crimson">Rodrigo</span></h1>
            <p>
              Hallo, ik ben <span class="crimson">Tijn</span> en ik ben <span class="crimson" id="age_display"></span> jaar oud. Ik ben een student op het <span class="crimson">Grafisch Lyceum Rotterdam</span>
            </p>
            <p>
              Ik heb ervaring met <span class="crimson">HTML</span>, <span class="crimson">CSS</span>, <span class="crimson">JavaScript</span>, <span class="crimson">PHP</span>, <span class="crimson">C</span> en <span class="crimson">C++</span>.</p> 
          </div>
        </div>
    </div>
  </div>

  <div class="projects" id="projects">
    <div class="content">
        <h1 class="title">Projecten</h1>
        <div class="hr_50"></div>
        <p class="center">Hieronder staan mijn 3 meest recente projecten.</p>
        <div class="grid">

          <?php

          $sql = "SELECT * FROM projects ORDER BY date_time DESC LIMIT 3";

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
        <div class="hr_100"></div>

        <div class="center">
          <a class="round-btn btn-hover-animation" href="projects.php">Bekijk al mijn projecten</a>
        </div>
    </div>
  </div>

  <div class="contact" id="contact">
    <div class="content">
        <?php

        $banned = false;

        $ip = $_SERVER['REMOTE_ADDR'];

        $sql = "SELECT * FROM banned WHERE ip='$ip'";

        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
          $banned = true;
        }

        // als het ip verbannen is haal dan de contact form weg en laat een bericht zien dat de gebruiker verbannen is maar alles na het formulier moet nog wel werken
        if ($banned) {
          // remove the 100 vh from the contact class using js
          echo "<script>document.querySelector('.contact').style.height = 'auto';</script>";
          echo "<h1 class='title'>Contact</h1>";
          echo "<div class='hr_50'></div>";
          echo "<p class='center'>U bent verbannen van het contact formulier.</p>";
          echo "<p class='center'>Heeft u vragen of opmerkingen? Neem dan contact met mij op via <a href='mailto:tijn.rodrigo@gmail.com'>tijn.rodrigo@gmail.com</a></p>";
        } else {
          echo "<h1 class='title'>Contact</h1>";
          echo "<div class='hr_50'></div>";
          echo "<p class='center'>Heeft u vragen of opmerkingen? Neem dan contact met mij op!</p>";
          echo "<form action='submit.php' method='post'>";
          echo "<input type='text' name='name' id='name' placeholder='Uw naam' required>";
          echo "<input type='email' name='email' id='email' placeholder='Uw email' required>";
          echo "<input type='text' name='subject' id='subject' placeholder='Onderwerp'>";
          echo "<textarea name='message' id='message' cols='30' rows='10' placeholder='Bericht' resize='none' required></textarea>";
          echo "<div class='center'>";
          echo "<button class='secondary-btn btn-hover-animation' type='submit'>Verstuur</button>";
          echo "<button class='secondary-btn btn-hover-animation' onclick='reset_contact_form();'>Reset</button>";
          echo "</div>";
          echo "</form>";
        }
        ?>
    </div>
  </div>

  <footer>
    <p>Copyright &copy; <span id='year'></span> Tijn Rodrigo</p>
  </footer>

  <script src="assets/js/particles.js"></script>
  <script src="assets/js/script.js"></script>
  <script src="assets/js/nav.js"></script>

  <script>
    calculate_age();
  </script>
</body>
</html>