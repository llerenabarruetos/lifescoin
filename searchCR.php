<?php
    $con = mysqli_connect('localhost', 'root', '') or die(mysqli_error($con));
    mysqli_select_db($con, "lifescoin");
    $output = '';

    
    $searchChatRoom = $_POST['searchVal']; //sent in from jquery script on index.php
    $searchChatRoom = preg_replace("#^0-9a-z#i", "", $searchChatRoom);
    session_start();
    $username = $_SESSION['userUid'];

    $query = mysqli_query($con, "
            SELECT * FROM publictopics WHERE topicName LIKE '%$searchChatRoom%' AND topicName NOT IN (
                SELECT publicTopic FROM recenttopicof WHERE username = '$username'
            );") or die(mysqli_error($con));        
    $count = mysqli_num_rows($query);
    $checkIfAlreadyInQuery = mysqli_query($con, "SELECT publicTopic FROM recenttopicof WHERE username = '$username' AND 
                    publicTopic = '$searchChatRoom';") or die(mysqli_error($con));

    if($searchChatRoom != '')
    {
        if($count == 0) {
            if(mysqli_num_rows($checkIfAlreadyInQuery) > 0)
            {
                $output = "<div style='margin-top: 2.5vh;margin-left: 3vw;'>- You are already in this Chat Room -</div>";
            }
            else 
            {
            $output = 
            "<div>
                <div style='margin-top: 2.5vh;margin-left: 4.5vw;'>- There were no search results -</div>
                <hr style='border-top: 0.1vw solid white; width: 5vw;margin-left: 10vw;margin-bottom: 2vw; margin-top: 2vw;'/>
                <h style='color:white;display: block;font-size: 5vh; margin-bottom: 1.5vh;'>Create $searchChatRoom:</h>
                <form action='createNewCR.inc.php' method='post' style='font-size: 2.5vh;margin-left: 0.5vw;'>
                    Public <input type='radio' name='chatRoomType' id='public' value='public' style='
                        margin-right: 18vw;margin-bottom:2vh;'/>
                    Private (join by invite) <input type='radio' name='chatRoomType' id='private' value='private' style='
                        margin-bottom: 3vh;/>  
                    <input type='hidden' name='createTopic' value='$searchChatRoom'/>  
                    <div style='margin-left:30%;'>                    
                    <input type='submit' style='border-radius: 1.5vw; cursor: pointer; background-color:rgb(0, 162, 255);
                        border: none; font-size: 2.5vh; padding: 1.5vh; padding-top: 1vh; padding-bottom: 1vh;
                        color: white;display: block;' value='Create $searchChatRoom'/>
                    </div>
                </form>
            </div>";
            }
        }
        else {
            while($row = mysqli_fetch_array($query)) {
                $chatRoomName = $row['topicName'];
                $chatRoomColor = $row['tabColor'];

                $output .= "<div style='display: flex; justify-content: center;padding-top: 1vh;'>
                    <form action = 'addTopicToUser.inc.php' method='post' style='margin-top: 1.2vh;'>
                        <input type='hidden' name='addTopic' value='$chatRoomName'/>
                        <div style='border-radius: 0.5vw;background-color:".$chatRoomColor."; padding: 0.5vh; 
                            padding-right: 1.5vh, padding-left: 1.5vh; font-size: 2.5vh;
                            text-align: center; display: inline; max-width: 10vw;'>".$chatRoomName."</div>
                        <input type='submit' value='Join' style='border-radius: 0.5vw; margin-left: 0.5vw; font-size: 2vh;
                                    border:none; color: white;background-color:rgb(0, 162, 255);cursor:pointer;'/>
                    </form>
                    </div>";
            }
        }
    }
    
    echo $output;
?>