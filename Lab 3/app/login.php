<?php include_once './includes/header.php';
?>

<div>
    <h1>Log in</h1>
    <p>No account? <a href="./register.php">Register here</a></p>

    <form action="includes/login-inc.php" method="post">
        <input type="text" name="username" placeholder="Username">
        <input type="password" name="password" placeholder="Password">
        <button type="submit" name='submit'>login</button>
    </form>
</div>

<?php include_once './includes/footer.php'; ?>
