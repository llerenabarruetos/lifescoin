<?php
session_start();
 if (!isset($_SESSION['userId'])){
               header("Location:login.php");
               
           }

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel = "stylesheet" href = "styles/index.css">
        <link rel="shortcut icon" href="images/coinLogo.ico" type="image/x-icon"/>
        <title>LifesCoin</title>
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <script>
            $(document).ready(function() {
                function loadTopic(newTopic)
                {
                    $.ajax({
                        url: "userController.php",
                        method: "POST",
                        data: {
                            newTopic: newTopic,
                            action: 'GetPosts'
                        },
                        success:function(data)
                        {
                            $('#postArea').html(data);
                        }
                    });
                }

                $('.topictab').click(function() {
                    var newTopicName = $(this).attr("id");
                    loadTopic(newTopicName);
                });

                $('.PostButton').click(function() {
                    
                    $.ajax({
                        url: "userController.php",
                        method: "POST",
                        data: {
                            action: 'ShowPostForm'
                        },
                        success:function(data)
                        {
                            $('#wild-card').html(data);
                        }
                    })
                })
               
                $('.plusTab').click(function() {
                    $.ajax({
                        url: "userController.php",
                        method: "POST",
                        data: {
                            action: 'ShowPlusTopicForm'
                        },
                        success:function(data)
                        {
                            $('#wild-card').html(data);
                        }
                    })
                })




               
            });
        </script>
        <script type="text/javascript">
            function SearchQ() {
                var searchTxt = $("input[name='searchChatRoom']").val();
                $.post("searchCR.php", {searchVal: searchTxt}, function(output) {
                    $('#searchCROutput').html(output);
                });
            }





            function showCurrentCRs() {
                $.post("userController.php", {action: 'ShowCurrentCRs'}, function(data) {
                    $('#wild-card').html(data);
                });
            }
            function GoToCR(topicName) {                
                $.post("userController.php", {newTopic: topicName,action: 'GetPosts'}, function(data) {
                    $('#postArea').html(data);
                })
                $.post("goToTopic.inc.php");
            }
            function LeaveCR(topicName) {
                $.post("leaveCR.inc.php");

                $.post("userController.php", {newTopic: topicName,action: 'GetTopicBar'}, function(data) {
                    $('#topicBar').html(data);

                showCurrentCRs();
                })
            }

            function ShowCoinBox(postId) {
                var coinBoxId = "#coinBox" + postId;

                $.post("userController.php", {postID: postId, action:'GetCoinBox'}, function(data) {
                    $(coinBoxId).html(data);
                } )
            }

            //Comment Real time function
            function UpdateCommentSpaceRT(postId) { //YO: send parameters to this function when a post's comment icon is clicked WITH the 'postId'
                setInterval(function() {
                    $.ajax({
                        url: 'comment_listing.php',
                        method: "POST",
                        data: {
                            postIDNum: postId
                        },
                        success:function(data) {
                            $('#commentSpace').html(data);
                        }
                    })
                },1000); //every 3000 ms
                
            }
            
            function ShowCommentView(postId) {
                $.post("userController.php", {postId: postId, action: 'ShowCommentView'}, function(data) {
                    $('#wild-card').html(data);
                });
                UpdateCommentSpaceRT(postId); //start comment RT
            }
 
            //clear comment input box when submit is clicked
           
        </script>
    </head>
    <body>
        <?php
            include 'header.php';
            include 'dbh.inc.php';
        ?>
        <div class = "Main-Feed"> 
            <?php
                require 'userController.php';
        //        require 'feedFunctions.php';
              //  $userController = new userController(); /*Here is where the username should be entered upon login. 
                //This is the main class for the user info and funtions */
 
                GetTopicBar();
                //include 'socialMarket.php'; //send 2 functions with $_SESSION[get the user name]
                echo "<div class='postArea' id='postArea'>";
                GetPosts("LakeDeep");
                echo "</div>";
            ?>
        </div>
        <div class = "NavigationArea">

   
            <img class="ProfilePic" src="images/profilePic.png">
            <h2 style="margin-bottom:1.6vh;">
            <?php
          
           if (isset($_SESSION['userId'])){
              echo $_SESSION['userUid'];
              
              echo '<form action = "upload.inc.php" method = "POST" enctype ="multipart/form-data">
              <input type ="file" name = "file">
              <button type = "submit" name = "upload">Upload</button>';
  
           }
?>
</h2>


            <div id="container" style="display:inline;" class = "LikecoinBox">
                
                <div id="image" style="display:inline">
                
                    <img src='images/coin.png' style = "width:42px" >
                    
                </div>
                
                
                <div id="texts"  style="display:inline; white-space:nowrap;padding-left: 0.8vw; font-size: 1.8vw;">
:&nbsp&nbsp
                    <?php
                    echo $_SESSION['lifescoin'];
                    ?>
                    
                </div>    
                
                
                <div id="button" style="display:inline; white-space:nowrap;">
                
                    <button type = "button" id='POST-button' class = "PostButton">POST</button>
                    
                </div>
 
 
                <h5 style="padding-left: 1.7vw;">LikeCoins</h5>
                
            </div>
          
            <button type="button" class="NavigationButtons" onclick="window.location.href='./'">Profile</button>
            <button type="button" class="NavigationButtons" onclick="window.location.href='./'">Friends</button>
            <button type="button" class="NavigationButtons" onclick='showCurrentCRs()'>Saved Chat Rooms</button>
            <button type="button" class="NavigationButtons" onclick="window.location.href='./'">Idea Vaults</button>
 
            <div id="container" style="display:inline;" class = "AboutRow">
                <div id="texts"  style="display:inline; white-space:nowrap;padding-left: 1vw; font-size: 0.8vw;">
                    <a style="text-decoration: none; color: white;"href="#">About</a>
                </div> 
                <div id="texts"  style="display:inline; white-space:nowrap;padding-left: 1vw; font-size: 0.8vw;">
                    <a style="text-decoration: none; color: white;"href="#">Terms</a>
                </div>
                <div id="texts"  style="display:inline; white-space:nowrap;padding-left: 1vw; font-size: 0.8vw;">
                    <a style="text-decoration: none; color: white;"href="#">Privacy</a>
                </div>
                <div id="texts"  style="display:inline; white-space:nowrap;padding-left: 1vw; font-size: 0.8vw;">
                    <a style="text-decoration: none; color: white;"href="#">FAQ</a>
                </div>
            </div>
            <div style="position: absolute; top: 90.3vh; margin-left: 10.3vw; align-text: center; font-size: 0.8vw;">LifesCoin © 2020</div>
        </div>
        <div class = "Friend-Area" id="wild-card">
            <h2 style = "color:orange">Friends</h2>
            <p>
            <button type="button" class="NavigationButtons" onclick="window.location.href='./'">RaylKing</button>
            <button type="button" class="NavigationButtons" onclick="window.location.href='./'">Shebasquine</button>
            <button type="button" class="NavigationButtons" onclick="window.location.href='./'">ImpossibleBurgerMan</button>
            <button type="button" class="NavigationButtons" onclick="window.location.href='./'">Danky</button>
            </p>
        </div>
        </body>
</html>
 
 
 