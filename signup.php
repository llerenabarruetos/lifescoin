<style>
    .signUpPage {
        background-image: url("images/signupGradient.png");
        background-size: cover; /*Resizing page? No problem, background resizes to cover this column */
        background-position: bottom left;
        background-repeat: no-repeat;
        position: absolute;
        top: 0;
        left: 0;
        height: 90%;
        width: 100%;
    }
    .titleBigWords {
        font-family: Arial;
        font-size: 8vh;
        margin-left: 26vw;
        margin-top: 5.5vh;
        color: white;
        margin-bottom: 3.5vh;
    }
    .signUpInputBox {
        border-radius: 0.75vw;
        border: 0.05vw solid rgb(202, 202, 202);
        height: 5vh;
        width: 25vw;
        font-size: 3vh;
        margin-left: 40vw;
        margin-bottom: 3.5vh;
        margin-right: 20vw;
        padding-left: 0.7vw;
    }
    .termsText {
        font-family: Arial;
        font-size: 2.5vh;
        color: rgb(250, 250, 250);
        display: inline;
        margin-left: 33.6vw;
    }
</style>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel = "stylesheet" href = "styles/login.css">
    <link rel="shortcut icon" href="images/coinLogo.ico" type="image/x-icon"/>  
    <title>LifesCoin | Sign Up</title>
</head>
    <main>
        <div class = "signUpPage"> 

                <div class="titleBigWords">Sign Up for LifesCoin
                        <img src="images/coinLogo.png" style="height: 13vh; position: absolute; top: 3.25vh;margin-left: 1vw;">
                        </div>

                        <?php
                        if (isset($_GET['error']))
                        {
                            if ($_GET['error']=='emptyfields')
                            {
                            echo '<p class = "signuperror">fill in all fields!</p>';
                            }
                            else if ($_GET['error']=='invaliduidmail')
                            {
                            echo '<p class = "signuperror">invalid username and email!</p>';
                            }
                            else if ($_GET['error']=='invaliduid')
                            {
                            echo '<p class = "signuperror">Invalid username!</p>';
                            }
                            else if ($_GET['error']=='invalidmail')
                            {
                            echo '<p class = "signuperror">Invalid mail!</p>';
                            }
                            else if ($_GET['error']=='passwordcheck')
                            {
                            echo '<p class = "signuperror">Your passwords do not match!</p>';
                            }
                            else if ($_GET['error']=='usertaken')
                            {
                            echo '<p class = "signuperror">Username is already taken!</p>';
                            }
                        }
                        else if (isset($_GET['signup']) == 'success'){
                            echo '<p class = "successsignup">Welcome to LifesCoin!</p>';
                        }
                        ?>
                <form class = "form-signup" action = "signup.inc.php" method="post">
                    <input type = "text" class="signUpInputBox" style="width: 12vw; margin-right: 0;" placeholder = "First name">
                    <input type = "text" class="signUpInputBox" style="width: 12vw; margin-left:0.7vw;" placeholder = "Last name">
                    <input type = "text" class="signUpInputBox" name = "uid" placeholder = "Username">
                    <input type = "text" class="signUpInputBox" name = "mail" placeholder = "E-mail">
                    <div style="display:inline; font-family: Arial; color: white; font-size: 3vh;margin-left: 42vw;">Date of Birth:</div>
                    <input type = "date" class="signUpInputBox" style="font-family:Arial; width: 13vw; margin-left: 1.4vw;" placeholder = "Date of Birth:">
                    <input type = "password" class="signUpInputBox" name = "pwd" placeholder = "Password">
                    <input type = "password" class="signUpInputBox" name = "pwd-repeat" style="margin-bottom:3vh;" placeholder = "Repeat password">
                    
                    <div class="termsText">By signing up, you are agreeing to our </div>
                    <a href="#" style="color: white; font-size: 2.5vh; font-family: Arial;"> Terms, Data and Privacy Policy</a>

                    <button type = "submit" name = "signup-submit" class="signUpButton" style="margin-left: 47.5vw; margin-top:2.75vh;">Sign Up</button>
                </form>
        </div>
        <?php 
            require "footer.php";
        ?>
    </main>
</html>
 

