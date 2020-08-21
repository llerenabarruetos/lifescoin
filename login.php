<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel = "stylesheet" href = "styles/login.css">
    <link rel="shortcut icon" href="images/coinLogo.ico" type="image/x-icon"/>  
    <title>LifesCoin</title>
</head>
<body>
    <?php
        require "header.php"
    /* if (isset($_SESSION['userId'])){
            echo''
        }*/
    ?>
    <div class = 'leftGreetingColumn'>
        <img class="transparentLogo" src="images/transparentLogo.png">
        <ul>
            <div class="featureWords">Coins &nbsp|&nbsp To empower good content.</div>
            <div class="featureWords">Posts &nbsp|&nbsp &nbsp 24 hours to collect coins.</div>
            <div class="featureWords">Connect &nbsp|&nbsp Chat, give & receive coins, seize the spotlight.</div>
        </ul>
        <div class="slogan">The future currency of your social life</div>
    </div>
    <div class = 'rightLoginColumn'>
        <nav>  
            <div>
                <div class="loginContainer">
                    <div class="titleWords">Log In</div>
                    <form action = "login.inc.php" method = "post">
                        <input type = "text" class="loginTextBox" name = "mailuid" placeholder = "Username">
                        <input type = "password" class="loginTextBox" style="margin-bottom: 1vh;" name = "pwd" placeholder = "Password">
                        <a href="reset-password.php" class="forgotPasswordLink">Forgot password?</a>
                        <button type = "submit" class="loginButton" name = "login-submit">Log In</button>
                    </form>
                </div>
                <hr style="width: 25vw;border-top: 0.1vw solid rgb(0, 12, 175);border-bottom: 0.1vw solid rgb(0, 12, 175);"/>
                <div class="signUpContainer">
                    <div class="titleWords" style="padding-bottom: 0.1vh;">New?</div>
                    <div class="mediumLoginText">Get started collecting coins today</div>
                    <div style="margin-top: 3vh; margin-bottom: 1.8vh;margin-left: 5.1vw;">
                        <a href = "signup.php" class="signUpButton">Sign Up</a>
                    </div> 
                </div>
                
                
            </div>
        </nav> 
    </div>
    <?php
        require "footer.php";
    ?>
</body>
</html>