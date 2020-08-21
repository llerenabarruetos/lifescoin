<?php
    $postId = $_POST['postIDNum'];

    $output = '';
    $con = mysqli_connect('localhost', 'root', '') or die(mysqli_error($con));
    mysqli_select_db($con, "lifescoin");
    //Get the comments from the DB using $postId:
    $resultComments = mysqli_query($con, "SELECT * FROM postcomments WHERE postUniqueId ='$postId' ORDER BY likecoins;") or die(mysqli_error($con));

    if(mysqli_num_rows($resultComments) > 0)
    {
        while($row = mysqli_fetch_array($resultComments)) //comment while loop
        {
                    $commentPoster = $row['username'];
                    $commentText = $row['text'];
                    $likecoins = $row['likecoins'];
                    $coinBoxId = "coinBox" . $postId;
                    $output .= "<div style='background-color:rgb(255, 136, 0); border-radius:2vw; padding:1vh;width: 22vw;margin-left:2vw;margin-top:2vh;'>
                                    <p class='postNameTag'>
                                    <img src='images/profilePic.png'>
                                    $commentPoster
                                    </p>
                                    <div class='postText'>$commentText</div>
                                    <div id='container' class = 'postDetailRow' style='left:-2%;width: 104.2%;margin-bottom:-2%;'>
                                        <div class='postLikeNum' id='postLikeNum' style='width:22vw;text-align:center;margin-left:0;padding-left:1vw;'>
                                        $likecoins
                                        <img src='images/coin.png' style = 'width:25px; cursor:pointer;' id='$postId' onclick='ShowCoinBox(this.id)'>
                                            
                                        <div style='position:absolute;z-index:999;left:8vw;' id='$coinBoxId'></div>
                                        </div>
                                    </div>
                        </div>";
        }
    }

    echo $output;

    //TODO: make only the top 6 comments and then "Show more comments" button, which maybe sends a parameter to the UpdateCommentSpaceRT function?
?>