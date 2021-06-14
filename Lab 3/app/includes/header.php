<?php
session_start();
require_once 'database.php';
require_once 'register-inc.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css" type="text/css">
    <title>Document</title>
</head>

<body>
    <header>
        <nav>
            <ul>
                <li><a href=login.php>Login</a>
                <li><a href=register.php>Register</a>
            </ul>
        </nav>
    </header>