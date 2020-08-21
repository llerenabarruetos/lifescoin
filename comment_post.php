<?php
    session_start();
    $username = $_SESSION['userUid'];
    $initialCoins = 0;
    $dateToday = date("Y-m-d h:i:s");
    $commentText = $_POST['myComment'];
    $postId = $_POST['postId'];

    $con = mysqli_connect('localhost', 'root', '') or die(mysqli_error($con));
    mysqli_select_db($con, "lifescoin");
    
    $sql="INSERT INTO postcomments (postUniqueId, text, postedWhen, likecoins, username) 
            VALUES (?,?,?,?,?)";
    $stmt = mysqli_stmt_init($con);
    if(mysqli_stmt_prepare($stmt,$sql))
    {
        mysqli_stmt_bind_param($stmt,"sssis", $postId, $commentText,$dateToday,$initialCoins,$username);
        mysqli_stmt_execute($stmt);
    }
    mysqli_stmt_close($stmt);
    
?>