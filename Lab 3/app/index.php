<?php include_once './includes/header.php';
?>

<?php
    if (isset($_SESSION['sessionId'])){
        echo '<p>'.'You are logged in'.'</p>';
    } 
?>

<!-- <?php

// $sql = "SELECT * FROM users";
// $result = mysqli_query($conn, $sql);
// $row_count = mysqli_num_rows($result);

// if ($row_count > 0){
    // while($row = mysqli_fetch_assoc($result)){
        // echo $row['username']. '<br>' ;
    // }
// } else{
    // echo 'No results found';
// }
?> -->

<?php include_once './includes/footer.php';
?>