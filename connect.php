<?php

$servername = "x71wqc4m22j8e3ql.cbetxkdyhwsb.us-east-1.rds.amazonaws.com";
$username = "m7k7zvf6yqprnzb3";
$password = "m91xvo4g4x6dttqf";
$dbname = "rfyvtbf1p7phyjc7";

try {
  $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
  // set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}
