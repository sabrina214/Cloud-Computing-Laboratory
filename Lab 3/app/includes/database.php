<?php

$servername = 'localhost';
$username= 'root';
$password = '';
$dbName = 'lms';

$conn = mysqli_connect($servername, $username, $password, $dbName);

if (!$conn){
    die('Database connection failed');
}
?>