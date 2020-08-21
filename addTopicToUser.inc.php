<?php
    session_start();
    $username = $_SESSION['userUid'];

    $newTopicToAdd = $_POST['addTopic'];
    $con = mysqli_connect('localhost', 'root', '') or die(mysqli_error($con));
    mysqli_select_db($con, "lifescoin");

    $sql = "INSERT INTO recenttopicof (username, publicTopic) VALUES (?,?);";
    $stmt = mysqli_stmt_init($con);
    if(mysqli_stmt_prepare($stmt,$sql))
    {
        mysqli_stmt_bind_param($stmt,"ss", $username, $newTopicToAdd);
        mysqli_stmt_execute($stmt);
    }
    
    mysqli_stmt_close($stmt);
    header("Location:index.php");
?>