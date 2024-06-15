<?php
$uname = isset($_POST["uname"]) ? $_POST["uname"] : '';
$psw = isset($_POST["psw"]) ? $_POST["psw"] : '';

$encr_psw = md5($psw);

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "carsproject";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$sql = "insert into login values('$uname','$encr_psw')";
$result = $conn->query($sql);
?>