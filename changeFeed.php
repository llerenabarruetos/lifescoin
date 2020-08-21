<?php
    $newTopic = $_POST["newTopic"];
    $con = mysqli_connect('localhost', 'root', '') or die(mysqli_error($con));
    mysqli_select_db($con, "lifescoin");
    //Make a variable for current day yyyy-mm-dd hh:mm:ss AND compare it with the postedWhen of posts
    $result = mysqli_query($con, "SELECT * FROM posts WHERE topicName = '$newTopic';") or die(mysqli_error($con));
    $postsArray = array();
    $lifecoinNum = array();
    $users = array();
    $postedWhen = array();

    while($row = mysqli_fetch_array($result))
    {
        array_push($postsArray, $row[1]); //text (because the first one [0] is postID, which we won't need rn)
        array_push($lifecoinNum, $row[2]); //lifecoinNum
        array_push($users, $row[3]); //user
        array_push($postedWhen, $row[4]); //date
    }
    mysqli_close($con);
    //END OF DATABASE EXTRACTION PART
    
    $returningCode = "<div class='postArea' id='postArea'>";
    foreach ($postsArray as $key => $post)
    {
        $returningCode = $returningCode . 
            "<div id='container' class = 'post'>
                <p class='postNameTag'>
                    <img src='images/profilePic.png'>
                    $users[$key]
                </p>
                <div class='postText'>$postsArray[$key]</div>
                <div id='container' class = 'postDetailRow'>
                    <div class='postLikeNum'>
                        $lifecoinNum[$key]
                        <img src='images/coin.png' style = 'width:25px'>
                    </div>
                    <div class='postComment'>
                        <img src='images/commentIcon.png' style = 'width:30px'>
                    </div>
                    <div class='postShare'>
                        <img src='images/shareIcon.png' style = 'width:25px'>
                    </div>
                </div>
             </div>";
    }

    $returningCode = $returningCode . "</div>"; //End the div that is postArea, contains the posts
    echo $returningCode;
?>