<?php
    session_start();
    $username = $_SESSION['userUid'];

    $newTopic = $_POST['createTopic'];
    $con = mysqli_connect('localhost', 'root', '') or die(mysqli_error($con));
    mysqli_select_db($con, "lifescoin");

    $sql = "INSERT INTO publictopics (topicName, tabColor)
                     VALUES (?,?);"; //$newTopic','rgb(0, 162, 255)
    $stmt = mysqli_stmt_init($con);
    $defaultColor = "rgb(0,162,255)"; //TEMPORAL: until we allow users to choose colors
    if(mysqli_stmt_prepare($stmt,$sql))
    {
        mysqli_stmt_bind_param($stmt,"ss", $newTopic, $defaultColor);
        mysqli_stmt_execute($stmt);
    }
    mysqli_stmt_close($stmt);
   

    $sql2 = "INSERT INTO recenttopicof (username, publicTopic)
                    VALUES (?,?);"; //$username', '$newTopic
    $stmt2 = mysqli_stmt_init($con);

    if(mysqli_stmt_prepare($stmt2,$sql2))
    {
        mysqli_stmt_bind_param($stmt2,"ss", $username, $newTopic);
        mysqli_stmt_execute($stmt2);
    }
    mysqli_stmt_close($stmt2);

    mysqli_close($con);
    header("Location:index.php");
?>