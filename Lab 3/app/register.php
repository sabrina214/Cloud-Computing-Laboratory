<?php include_once './includes/header.php';
?>

<div>
    <h1>Register</h1>
    <p>Already a user? <a href="./login.php">Log in</a></p>

    <form action="includes/register-inc.php" method="post">
        <input type="text" name="username" placeholder="Username">
        <input type="password" name="password" placeholder="Password">
        <input type="password" name="cpassword" placeholder="Confirm Password">
        <button type="submit" name='submit'>Register</button>
    </form>
</div>

<?php include_once './includes/footer.php'; ?>
