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

$author = "Tijn Rodrigo";
$title = $_POST['title'];
$github = $_POST['github'];
$description = $_POST['description'];
$date = date("Y-m-d H:i:s");

// generate a 11 character id using only uppercase letters and numbers
$unique_id = strtoupper(substr(uniqid(), 0, 11));

// check if the unique id already exists
$sql = "SELECT * FROM projects WHERE unique_id = '$unique_id'";

$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
  // if the unique id already exists generate a new one
  $unique_id = strtoupper(substr(uniqid(), 0, 11));
}

// check if the user uploaded a file
if (isset($_FILES['file-upload'])) {
  // get the file name
  $file_name = $_FILES['file-upload']['name'];

  // get the file extension
  $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

  // check if the file is an image
  if ($file_ext == "jpg" || $file_ext == "png" || $file_ext == "jpeg") {
    // get the file size
    $file_size = $_FILES['file-upload']['size'];

    // get the file tmp name
    $file_tmp = $_FILES['file-upload']['tmp_name'];

    // get the file type
    $file_type = $_FILES['file-upload']['type'];

    // check if the file size is less than 5mb
    if ($file_size <= 5000000) {
      // convert the file to a blob
      $img = addslashes(file_get_contents($file_tmp));

      // insert the project into the database
      $sql = "INSERT INTO projects (author, title, github, description, date_time, unique_id, img) VALUES ('$author', '$title', '$github', '$description', '$date', '$unique_id', '$img')";

      if (mysqli_query($conn, $sql)) {
        // redirect the user to the dashboard
        header("location: dashboard.php");
      } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
      }
    } else {
      echo "De afbeelding is te groot!";
    }
  } else {
    echo "De afbeelding is geen jpg, png of jpeg!";
  }
} else {
  // insert the project into the database
  $sql = "INSERT INTO projects (author, title, github, description, date_time, unique_id) VALUES ('$author', '$title', '$github', '$description', '$date', '$unique_id')";

  if (mysqli_query($conn, $sql)) {
    // redirect the user to the dashboard
    header("location: dashboard.php");
  } else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
  }
}
?>