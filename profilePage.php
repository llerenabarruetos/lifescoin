<?php
session_start();

require 'dbh.inc.php';

if (!isset($_SESSION['userId']))
{
    header("Location:login.php?attemptdprofileaccess");
}
else if (!isset($_GET['id']))
{
header("Location:index.php");
}
else{
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
   <link rel = "stylesheet" href = "styles/profilepage.css">
 
    <link rel="shortcut icon" href="images/coinLogo.ico" type="image/x-icon"/>  
    <title>LifesCoin</title>
</head>
<body>
    <?php
        
        echo "<div style='margin-top:5.5vh;'>";
      
        if (isset($_GET['id'])){
            $sql = "SELECT * FROM users WHERE idUsers =".$_GET['id'];
            $result = mysqli_query($conn,$sql);
            if(mysqli_num_rows($result)> 0){
                while($row = mysqli_fetch_assoc($result)){
                    $id = $_GET['id'];
                    $sqlImg = "SELECT * FROM profileimg WHERE userid = '$id'";
                    $resultImg = mysqli_query($conn,$sqlImg);
                    while($rowImg = mysqli_fetch_assoc($resultImg))
                    {
                        
                        
                    $filename = "uploads/profile".$id."*";
                    $fileinfo = glob($filename);
                    $fileext = explode(".",$fileinfo[0]);
                    $fileactualext=$fileext[1];
                        
                        if ($rowImg['status']== 0)
                        {
                            echo "<img class = 'ProfilePic' src='uploads/profile".$id.".".$fileactualext."?".mt_rand().
                            "'>";
                            echo "<h2 class = 'coinage'><img src='images/coin.png' style = 'width:42px' >".$row['likesCoin']."</h2>";
                        } 
                        else if($rowImg['status'] != 0) {
                            echo '<img class="ProfilePic" src="uploads/profiledefault.png">';
                            echo "<h2>LifesCoins:".$row['likesCoin']."</h2>";
                        }
                    }
                }
            }
    $id = $_GET['id'];
$sql = "SELECT * FROM users WHERE idUsers = '$id'";
            $result = mysqli_query($conn,$sql);
            if(mysqli_num_rows($result)> 0){
                while($row = mysqli_fetch_assoc($result)){
                    $username = $row['uidUsers'];
                    $firstName = $row['firstName'];
                    $lastName = $row['lastName'];
                    $lifescoins = $row['likesCoin'];
                    $DOB = $row['dob'];
                    $email = $row['emailUsers'];
                }
        }
        
        echo "<h2 class = 'profileUsername'>".$username."</h2>";
        
         if ($username == $_SESSION['userUid'])
        {
            $myId = $_SESSION['userId'];
            echo '<form action = "uploadToProfilePage.inc.php" method ="POST" enctype ="multipart/form-data">
             <input  style ="position:absolute; right: 80px; top:50px" type ="file" name = "file">
            <button  style = "position:absolute; right: 50px; top:50px"name = "upload">upload pic </button></form>';
            echo '<h2>Me</h2>';
        }
         else {
            
             $myId = $_SESSION['userId'];
             $otherId = $_GET['id'];
             #this is if you are not on your own profile page. i.e. on another #persons profile page
             #here i will be checking if a request has already been sent.
             $sql = "SELECT * FROM friendslist WHERE userId ='$myId' AND friends ='$otherId' OR userId = '$otherId' AND friends = '$myId'";
             $result = mysqli_query($conn,$sql);
             if (mysqli_num_rows($result) > 0)
             {
                 while ($row = mysqli_fetch_assoc($result))
                 {
                     if ($row['request'] == 1 && ($row['userId'] == $myId))
                     {
                         #userId is the requester, you are the requester.
                         echo 'friend request pending...';
                     }
                     else if ($row['request'] == 1 && ($row['friends'] == $myId))
                     {
                         #if your id is in friends db column, they requested
                         echo 'They have sent you a friend request check your profile page';
                     }
                     else if ($row['request'] == 0)
                     {
                         #if the status of any friend request is 0 you are #friends
                         echo '<h3 class = friendText>Friend</h3>';
                         echo '<form  method = "POST" action = "sendCoin.inc.php"><button class = "sendCoinButton" value = "'.$otherId.'" name = "sendCoin">send LifesCoin</button></form>';
                         echo '
                         <form method = "POST" action="unfriend.inc.php">
                         <button class = "unfriendButton" name = "unfriend" value = "'.$_GET['id'].'">
                         Un-Friend
                         </button>
                         </form>';
                     }
                 }
             }
             else{
             echo '
            <br>
            <form action = "addFriend.inc.php" method = "POST" >
            <button name = "addFriend" value = "'.$id.'">Add</button>
            </form>
            ';
             }
        }
        #here is the end of the friend system code
       
        
        $Description = "This is your description";
    echo"<div class 'profile'>
    
    <div class = 'informationBox'>
    <div class = 'informationInput'>
        <h3>Username:".$username."</h3>
        <br>
        <h3>FirstName:".$firstName."</h3>
        <br>
        <h3>LastName:".$lastName."</h3>
        <br>
        <h3>LifesCoin:".$lifescoins."</h3>
        <br>
        <h3>Date of Birth:".$DOB."</h3>
        <br>
        <h3>Email:".$email."</h3>
        <br>
        </div>    
        
    </div>
    <div class = 'pictureArea'>
    <h3 class = 'pictureAreaTitle'> Insert pictures here</h3>";
 

    $sql = "SELECT * FROM users WHERE idUsers =".$_GET['id'];
        $result = mysqli_query($conn,$sql);
        if (mysqli_num_rows($result))
        {
        while ($row = mysqli_fetch_assoc($result))
        {
        $totalPictureCount = $row['pictureCount'];

            for($counter = 0;$counter < $totalPictureCount;$counter++)
            {
                echo "<div class = 'row'>";
                 $filename = "uploads/name".$_GET['id']."number".$counter."*";
                    $fileinfo = glob($filename);
                    $fileext = explode(".",$fileinfo[0]);
                    $fileactualext=$fileext[1];
                    echo "<div class = 'column'>";
                 echo "<img  class = 'myImages' src='uploads/name".$_GET['id']."number".$counter.".".$fileactualext."?".mt_rand()."'>";
                echo '<h2>this is one picture<h2>';
                echo "</div>";
               echo "</div>";
                
            }
        }
    }
    
  echo" </div>
    </div>
    ";
    echo "<a class = 'returnButton' href = 'http://www.lifescoin.com/index.php'>return</a>";

    mysqli_close($conn);
    }
}
    ?>
    </div>
</body>
</html>

