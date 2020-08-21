<?php
    session_start();
    $username = $_SESSION['userUid'];

    $coinsGiven = $_POST['coinsGiven'];
    $postId = $_POST['postId'];

    $con = mysqli_connect('localhost', 'root', '') or die(mysqli_error($con));
    mysqli_select_db($con, "lifescoin");

    $sql = "UPDATE posts SET likecoinNum = likecoinNum + ?  WHERE uniqueId = ?;";
    $stmt = mysqli_stmt_init($conn);
    if(mysqli_stmt_prepare($stmt,$sql))
    {
        mysqli_stmt_bind_param($stmt,"is", $coinsGiven, $postId);
        mysqli_stmt_execute($stmt);
    }
    mysqli_stmt_close($stmt);

    $sql = "UPDATE users SET likesCoin = likesCoin - ?  WHERE uidUsers = ?;";
    $stmt = mysqli_stmt_init($conn);
    if(mysqli_stmt_prepare($stmt,$sql))
    {
        mysqli_stmt_bind_param($stmt,"is", $coinsGiven, $username);
        mysqli_stmt_execute($stmt);
    }
    mysqli_stmt_close($stmt);

        header("Location:index.php");
?>