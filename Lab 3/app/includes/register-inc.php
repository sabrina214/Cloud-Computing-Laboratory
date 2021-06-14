<?php

if (isset($_POST['submit'])){
    require 'database.php';

    $username = $_POST['username'];
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];

    if(empty($username) || empty($password) || empty($cpassword)){
        header('Location: ../register.php?error=emptyfields&username='.$username);
        exit();
    } elseif (!preg_match("/^[a-zA-Z0-9]*/", '$username')){
        header('Location: ../register.php?error=invalidusername='.$username);
        exit();
    } elseif ($password !== $cpassword){
        header('Location: ../register.php?error=passwordsdonotmatch&username='.$username);
        exit();
    } else{
        $sql = "SELECT username FROM users WHERE username = ?";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header('Location: ../register.php?error=sqlrerror1');
            exit();
        } else {
            mysqli_stmt_bind_param($stmt, "s", $username);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);
            
            $row_count = mysqli_stmt_num_rows($stmt);
            if ($row_count > 0) {
                header('Location: ../register.php?error=usernametaken');
                exit();
            } else {
                $sql = "INSERT INTO users(username, passwd) VALUES (?, ?)";
                $stmt = mysqli_stmt_init($conn);
                if (!mysqli_stmt_prepare($stmt, $sql)) {
                    header('Location: ../register.php?error=sqlrerror2');
                    exit();
                } else {
                    $hash_pass = password_hash($password, PASSWORD_DEFAULT);
                    mysqli_stmt_bind_param($stmt, "ss", $username, $hash_pass);
                    mysqli_stmt_execute($stmt);
                    
                    header('Location: ../register.php?success=registered');
                    exit();
                }
            }
        }
    }
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}

?>