<?php
        if(isset($_REQUEST['action']))
        {
            switch($_REQUEST['action'])
            {
                case 'GetPosts':
                    GetPosts($_POST['newTopic']);
                    break;
                case 'ShowPostForm':
                    ShowPostForm();
                    break;
                case 'ShowPlusTopicForm':
                    ShowPlusTopicForm();
                    break;
                case 'ShowCurrentCRs':
                    ShowCurrentCRs();
                    break;
                case 'GetCoinBox':
                    GetCoinBox($_POST['postID']);
                    break;
                case 'ShowCommentView':
                    ShowCommentView($_POST['postId']);
                    break;
            }
        }


        function GetTopicBar()
        {
            $con = mysqli_connect('localhost', 'root', '') or die(mysqli_error($con));
            mysqli_select_db($con, "lifescoin");
            $result = mysqli_query($con, "SELECT DISTINCT publicTopic, tabColor FROM recenttopicof AS r, publictopics AS p 
                                WHERE r.username = 'PepeTheD' AND p.topicName = r.publicTopic;") or die(mysqli_error($con));
            $topicsArray = array();
            $colorsOfTabs = array(); //to later pair each tab with its color and style it

            //Load data from the query (instruction we just wrote: SELECT...) results into a usable format, an array
            while($row = mysqli_fetch_array($result))
            {
                array_push($topicsArray, $row[0]); //0 cuz the result of the query are tuples, we only asked for one thing, publicTopic
                array_push($colorsOfTabs, $row[1]);
            }
            mysqli_close($con);
            //END OF DATABASE EXTRACTION PART

            $returningCode = "<div class='topicBar' id='topicBar'> <ul id='menu'>";
            $returningCode = $returningCode .
                       "<li><a class='topictab' id='World' value='World' style='font-weight: bold;background:linear-gradient(90deg, rgba(131,58,180,1) 0%, rgba(253,29,29,1) 50%, rgba(252,176,69,1) 100%); cursor: pointer;'>World</a></li>";
            $returningCode = $returningCode .
                       "<li><a class='topictab' id='Friends' value='Friends' style='font-weight: bold;background:linear-gradient(90deg, rgba(0,25,235,1) 0%, rgba(0,251,252,1) 100%); cursor: pointer;'>Friends</a></li>"; 
            $index = 0;
            $topicsArray = array_reverse($topicsArray);
            foreach ($topicsArray as $key => $topic)
            {
                if ($index < 7)  //TO BE CALCULATED: a max number of tabs, this is depending of the max-width of each and any
                                //adjustments they have such as if its over  ___ chars, to cut off and add '...'
                {
                    if($topic != 'Friends' && $topic != 'World')
                    {
                        $returningCode = $returningCode . 
                        "<li><a class='topictab' id='$topic' value='$topic' style='background-color: $colorsOfTabs[$key]; cursor: pointer;'>$topic</a></li>";                       
                    }
                }
                else
                    break;
                $index = $index + 1;
            }
            $returningCode = $returningCode . "<li><a class='plusTab' style='background-color: orange;
                                                padding-right: 1.1vw; padding-left: 1.1vw;cursor: pointer;'>+</a></li> </ul><hr/> </div>"; 
                                                //the + button for each user will be their own post color (customization ftw bro!)
            echo $returningCode;
        }

        function GetPosts($newTopic)
        {
            $con = mysqli_connect('localhost', 'root', '') or die(mysqli_error($con));
            mysqli_select_db($con, "lifescoin");
            //Make a variable for current day yyyy-mm-dd hh:mm:ss AND compare it with the postedWhen of posts
            $result = mysqli_query($con, "SELECT * FROM posts WHERE topicName = '$newTopic';") or die(mysqli_error($con));
            $postsArray = array();
            $lifecoinNum = array();
            $users = array();
            $postedWhen = array();
            
            $idArray = array();

            while($row = mysqli_fetch_array($result))
            {
                array_push($postsArray, $row[1]); //text (because the first one [0] is postID, which we won't need rn)
                array_push($lifecoinNum, $row[2]); //lifecoinNum
                array_push($users, $row[3]); //user
                array_push($postedWhen, $row[4]); //date
                
                
                array_push($idArray, $row[0]); //POST ID
            }
            mysqli_close($con);
            //END OF DATABASE EXTRACTION PART
            
            $returningCode = "";
            foreach ($postsArray as $key => $post)
            {
                $coinBoxId = "coinBox" . $idArray[$key];
                $returningCode = $returningCode . 
                    "<div id='container' class = 'post'>
                        <p class='postNameTag'>
                            <img src='images/profilePic.png'>
                            $users[$key]
                        </p>
                        <div class='postText'>$postsArray[$key]</div>
                        <div id='container' class = 'postDetailRow'>
                            <div class='postLikeNum' id='postLikeNum'>
                                $lifecoinNum[$key]
                                <img src='images/coin.png' style = 'width:25px; cursor:pointer;' id='$idArray[$key]' onclick='ShowCoinBox(this.id)'>
                                    
                                <div style='position:absolute;z-index:999;left:8vw;' id='$coinBoxId'></div>
                            </div>
                            <div class='postComment'>
                                <img src='images/commentIcon.png' style = 'width:30px' id='$idArray[$key]' onclick='ShowCommentView(this.id)'>
                            </div>
                            <div class='postShare'>
                                <img src='images/shareIcon.png' style = 'width:25px'>
                            </div>
                        </div>
                    </div>";
            }
            echo $returningCode;
        }

        function ShowPostForm()
        {
            
            $postWildCardCode = "<div style='margin-left: 2.5vw; margin-top: 1vh; '>
                                    <h1 style='color: white; font-size: 5vh; margin-bottom: 1.5vh;'>Post to a Chat Room: </h1>
                                    <form action='updatePost.inc.php' method='post' style='color: white;font-size: 3vh;' name='postForm'>
                                        Topic: <input type='text' name='topicToPostTo' style='border-radius: 0.5vw;height: 3.5vh; font-size: 2.5vh;
                                                                border: none;width: 15vw;padding-left: 0.5vw;margin-right: 5vw;'>
                                        
                                        <textarea name='newPost' cols='40' rows='5' placeholder='Let the world know...'
                                            style='font-family: Arial; font-size: 2.8vh;border-radius: 0.8vw;margin-top: 2vh;height: 22vh;width: 22vw;padding-left: 0.5vw;'></textarea>
                                        <input type='submit' style='margin-top: 1vh; padding: 0;margin-left: 8.5vw; height: 4.5vh; width: 5.5vw;font-size: 2.5vh;
                                            border-radius: 2vw; background: rgb(0, 162, 255); border: none; color: white;'>
                                    </form>
                                    
                                </div>";

            echo $postWildCardCode;
        }

        function ShowPlusTopicForm()
        {
            $plusForm = 
            "<div style='margin-left: 2.5vw;'>
                <h1 style='color: white;font-size: 5vh; margin-bottom: 1.5vh;'>Join/Create a Chat Room: </h1>
                <div style='color: white;font-size: 2.5vh;margin-right: 0.5vw;line-height: 3.5vh;'>Search for existing Chat Rooms, you can create one if it doesn't exist</div>
                <form method='post' name='addChatRoom' style='color: white; margin-top: 2vh;font-size: 2.5vh;'>
                    Name: <input type='text' name='searchChatRoom' placeholder='Search for Chat Room...' onkeyup='SearchQ();' style='
                        border-radius: 0.5vw;height: 3.5vh; font-size: 2.5vh; border: none;width: 15vw;padding-left: 0.5vw;margin-right: 5vw;'>
                </form>
                    <div id='searchCROutput' style='color: white;'></div>
            </div>"; //onkeyup for optimal instant update
            echo $plusForm;
        }

        function ShowCurrentCRs()
        {
            $currentCRs = "
                <div>
                    <h1 style='color:white; font-size: 5vh;margin-bottom:1vh;margin-left:2.5vw;margin-top:1vh;'>My Chat Rooms:</h1>";
                    
            $con = mysqli_connect('localhost', 'root', '') or die(mysqli_error($con));
            mysqli_select_db($con, "lifescoin");
            session_start();
            $username = $_SESSION['userUid'];
            $result = mysqli_query($con, "SELECT DISTINCT R.publicTopic, P.tabColor FROM recenttopicof as R, publictopics as P 
                        WHERE R.username='$username' AND P.topicName = R.publicTopic;") or die(mysqli_error($con));
                        //FUTURE CONSIDERATION: If private chats in separate DB table (plz don't), adjust query to access 
                        //   also that private chat DB to get their colors

                            //add: ORDER BY lastVisted  to the query now please

            while($row = mysqli_fetch_array($result))
            {
                $currentCRs .=
                    "<div style='color: white;text-align:center;padding-top:2vh;'>                            
                        <button type='button' name='goToCRButton' id='$row[0]' onclick='GoToCR(this.id)' style='background-color: rgb(0, 218, 0);
                                border: none; font-weight:bold;border-radius: 0.5vw; display: inline;color:white;font-size:2vh;margin-right:0.75vw;cursor:pointer;'>Go</button>
                        <div style='background-color: $row[1]; width: auto; padding: none;display:inline-block;
                                border-radius:0.5vw;padding:0.5vh;padding-right:1.5vh;padding-left:1.5vh;font-size:2.5vh;
                                margin-right:0.75vw;'>$row[0]</div>
                        <button type='button' name='leaveCRButton' id='$row[0]' onclick='LeaveCR(this.id)' style='background-color: rgb(231, 0, 0);
                            border:none; border-radius:0.5vw;font-weight:bold;color:white;font-size:2vh;cursor:pointer;'>Leave</button>
                    </div>";
            }

            $currentCRs .=  "  </div> ";

            echo $currentCRs;
        }

        function GetCoinBox($topicId) 
        {
            echo "<div class='arrow-up' style='margin-left:2.5vh;top:-2vh;'></div>
                    <div class='coinBox'>
                    Give Coins: 
                    <form action='giveCoins.inc.php' method='post'>
                        <input type='number' name='coinsGiven' placeholder='Amount' style='display:block;margin-top:1vh;border-radius: 0.2vw;
                                border:none;padding-left:0.4vw;font-size: 2.5vh;width:7vw;height:3.5vh;'/>
                        <input type='hidden' name='postId' value = '$topicId'/>
                        <input type='submit' value='Send' style='margin-top: 1vh; padding: 0;margin-left: 1.25vw; height: 4vh; width: 5vw;font-size: 2.5vh;
                        border-radius: 2vw; background: rgb(240, 240, 240); border: none; color: rgb(0, 162, 255);font-weight:bolder;cursor: pointer;'/>
                    </form>
            </div>";
        }

        function ShowCommentView($postId)
        {
            $con = mysqli_connect('localhost', 'root', '') or die(mysqli_error($con));
            mysqli_select_db($con, "lifescoin");
            $result = mysqli_query($con, "SELECT * FROM posts WHERE postID = '$postId';") or die(mysqli_error($con));
            // CHANGE postID to uniqueId
            $row = mysqli_fetch_array($result);
            $poster = $row['user']; //MAKE SURE ALL OF THIS MATCH THE ONLINE DB
            $text = $row['text'];
            $likecoins = $row['likecoinNum'];
            $topic = $row['topicName'];
            $coinBoxId = "coinBox" . $postId;

            session_start();
            $username = $_SESSION['userUid'];
            $resultComments = mysqli_query($con, "SELECT * FROM postcomments WHERE postUniqueId ='$postId' ORDER BY likecoins;") or die(mysqli_error($con));

            $output = "<div style='font-size:4vh;padding-left:1.5vw;color:white;'>$poster's Post to $topic:</div>
            
                    <div id='container' class = 'post' style='margin-bottom:0;'>
                    <p class='postNameTag'>
                        <img src='images/profilePic.png'>
                        $poster
                    </p>
                    <div class='postText'>$text</div>
                    <div id='container' class = 'postDetailRow' style='left:-2.5%;width: 105.1%;'>
                        <div class='postLikeNum' id='postLikeNum'>
                            $likecoins
                            <img src='images/coin.png' style = 'width:25px; cursor:pointer;' id='$postId' onclick='ShowCoinBox(this.id)'>
                                
                            <div style='position:absolute;z-index:999;left:8vw;' id='$coinBoxId'></div>
                        </div>
                        <div class='postShare' style='margin-left:6.5vw;'>
                            <img src='images/shareIcon.png' style = 'width:25px'>
                        </div>
                    </div>
                </div>

                <div style='margin-left: 1.8vh;margin-right: 1.8vh;'>
                    <form method='post'  id='commentSubmitForm'>
                        <textarea id='commentTextInput' type='text' name='myComment' cols='40' rows='2' ";
                    
            if(mysqli_num_rows($resultComments) == 0)
                $output .=  "placeholder = 'Write the first comment...' ";
            else
                $output .=  "placeholder = 'Write a comment...' ";
            
            $output .= " style='font-family:Arial;border-radius:0.5vw;margin-left:0.5vh;
                        margin-top:1.5vh;font-size:2.5vh;height:7vh;width:20vw;border:none;padding-left:0.75vh;padding-right:0.75vh;
                        padding-top:0.4vh;resize:none;'></textarea>
                    <input id='postCommentButton' type='submit' value='Post' style='background:none;border:none;color:rgb(0, 183, 255);display:inline;
                        font-size: 3vh;margin-top:-13%;cursor:pointer;' onclick='PostComment()'/>
                    </form>
                    
                    <div id='commentSpace'></div>"; //Comment space tag

            echo $output;
        }
?>