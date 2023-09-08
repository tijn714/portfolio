<?php
require 'assets/php/.config.php';

// Connect with the database
$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Session start should be at the top of the script
session_start();

// submit logic

if (isset($_POST['submit'])) {
  $username = $_POST['username'];
  $password = $_POST['password'];

  // hash the password using sha
  $password = sha1($password);

    // check if the username and password are correct
    $sql = "SELECT * FROM login WHERE username = '$username' AND password = '$password'";

    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
      // login
      $_SESSION['loggedin'] = true;
      $_SESSION['admin'] = true;
      $_SESSION['username'] = $username;
      header("location: dashboard.php");
    } else {
      // don't login
      $error_message = "Gebruikersnaam of wachtwoord is onjuist!";
    }
}
?>

<!-- HTML Code -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Tijn Rodrigo</title>

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
            <h2 class="title">Login</h2>
            <p class="center">Login om data te beheren en content toe te voegen</p>
            <div class="hr_100"></div>

            <?php if (isset($error_message)): ?>
              <div class="error-message"><?php echo $error_message; ?></div>
            <?php endif; ?>

            <form class="login-form" action="login.php" method="POST">
                <input type="text" name="username" placeholder="Gebruikersnaam" required>
                <input type="password" name="password" placeholder="Wachtwoord" required>
                <div class="center">
                    <button type="submit" name="submit" class="round-btn btn-no-hover-animation">Login</button>
                </div>
            </form>
        </div>
    </div>

    <footer>
    <p>Copyright &copy; <span id='year'></span> Tijn Rodrigo</p>
  </footer>

  <script src="assets/js/script.js"></script>
</body>
</html>