<?php

if (isset($_POST['submit'])){
    require 'database.php';

    $username = $_POST['username'];
    $password = $_POST['password'];

    if(empty($username) || empty($password)){
        header('Location: ../index.php?error=emptyfields');
        exit();
    } else{
        $sql = "SELECT * FROM users WHERE username = ?";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header('Location: ../index.php?error=sqlrerror');
            exit();
        } else {
            mysqli_stmt_bind_param($stmt, "s", $username);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            
            if ($row = mysqli_fetch_assoc($result)) {
                $pass_check = password_verify($password, $row['passwd']);
                if ($pass_check == false){
                    header('Location: ../index.php?error=wrongpass');
                    exit();
                } elseif ($pass_check == true){
                    session_start();
                    $_SESSION['sessionId'] = $row['username'];
                    header('Location: ../index.php?success=loggedin');
                    exit();
                } else {
                    header('Location: ../index.php?error=wrongpass');
                    exit();
                }
            } else {
                    header('Location: ../index.php?error=nouser');
                    exit();
            }
        }
    }
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
} else {
    header('Location: ../index.php>error=accessforbidden');
    exit();
}

?>