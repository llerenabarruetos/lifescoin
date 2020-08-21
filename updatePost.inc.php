<?php
session_start();
    $username = $_SESSION['userUid'];

    $topic = $_POST['topicToPostTo'];
    $post = $_POST['newPost'];

    $con = mysqli_connect('localhost', 'root', '') or die(mysqli_error($con));
    mysqli_select_db($con, "lifescoin");

    mysqli_query($con, "INSERT INTO posts (postID, text, likecoinNum, user, postedWhen, topicName)
                                    VALUES ('$username', '$post', 0, '$username', '2019-12-26', '$topic');") or die(mysqli_error($con));
    
    mysqli_close($con);
    header("Location:index.php");

?>