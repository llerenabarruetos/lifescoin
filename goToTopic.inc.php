<?php
    session_start();
    $username = $_SESSION['topicToBringUp'];
    $dateToday = date("Y-m-d h:i:s");

    $topic = $_POST['topicToBringUp'];
    $con = mysqli_connect('localhost', 'root', '') or die(mysqli_error($con));
    mysqli_select_db($con, "lifescoin");

   // mysqli_query($con, "UPDATE recenttopicof SET lastVisited = '$dateToday' WHERE publicTopic = '$topic';") or die(mysqli_error($con));

    mysqli_close($con);
    header("Location:index.php");
?>