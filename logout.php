<?php

session_start();
$_SESSION["loggedin"] = false;
$_SESSION["admin"] = false;
session_destroy();

header("Location: ./")
?>