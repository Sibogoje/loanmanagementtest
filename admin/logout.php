<?php
require_once('auth.php');
session_start();
$online = '0';
$dates = date("Y-m-d H:i:s");
$statement = $conn->prepare("UPDATE `useraccounts` SET `last_login` = ?, `onlines` =?  WHERE username = ?");
$statement->bind_param("sss", $dates, $online,  $_SESSION['name']);
$statement->execute();
session_destroy();
// Redirect to the login page:
header('Location: index.php');
?>