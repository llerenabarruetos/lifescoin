<?php
session_start();
?>
 
<style>
        .logoButton img {
            position:fixed;
            top: 0;
            left: 0;
            float: left;
        }
        .mainLogo{
            top: 0;
            height:6.3vh;
            width: 13vw;
            border-bottom: 3px solid rgb(34, 34, 34);
            }
        .Main-Title {
        /*width: 300px;*/
        background-color:rgb(0, 141, 235);
        border-bottom: 3px solid rgb(0, 91, 109);
        top: 0;
        height: 6.3vh;
        position: fixed;
        width: 100%; /*Playing with "position: whatever" will make bg color dissapear unless content inside. So we add a fixed width*/
        z-index: 999; /*Presedence over anything else, especially made for header's interaction with Social Market*/
        }
        .Main-Title input {
        top: 1.1vh;
        left: 36vw;
        position: absolute;
        border-radius: 15px;
        align-self: center;
        width: 27vw;
        height: 3.5vh;
        padding-left: 10px;
        }
        .headerLoginButton {
        float: right;
        padding-top: 0.5vh;
        padding-right: 3.2vw;
        font-size: 3.25vh;
        color: white;
        font-family: Arial;
        text-decoration: none;
        }
        .headerFeedButton {
        float: right;
        padding-top: 2vh;
        padding-right: 3vw;
        font-size: 3vh;
        color: white;
        font-family: Arial;
        text-decoration: none;
        }
    </style>
    <script>
            function searchUser() {
                var searchTxt = $("input[name='searchUser']").val();
                $.post("searchUser.php", {searchVal: searchTxt}, function(data) {
                    $('#userSearchResult').html(data);
                });
            }
    </script>
 
 <?php
        function startsWith ($string, $startString) 
        { 
            $len = strlen($startString); 
            return (substr($string, 0, $len) === $startString); 
        } 
 
        $link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://" . $_SERVER['HTTP_HOST'] .  
                        $_SERVER['REQUEST_URI']; 
        if(startsWith($link, "http://localhost/lifescoin/index.php") || $link == "http://localhost/lifescoin/" || startsWith($link, "http://localhost/Lifescoin/index.php") || $link == "http://localhost/Lifescoin/") //Future: add the actual link "www.Lifescoin.com..." AND also add other if-clause of when a session is started (else, display "Log In  Sign Up")
           { echo "<div id = 'container' class = 'Main-Title'>
                <a href = 'index.php' id='container' class='logoButton'><img class = 'mainLogo' src='images/mainLogo.png'/></a>
                  <input type='text' name='searchUser' placeholder='Search...' style='outline-width: 0;font-size: 2.5vh;z-index:50;' onkeyup='searchUser()'/>
                  <ul id='userSearchResult' style='color: gray;background-color: white;z-index: 10;height:auto;width: 27.85vw;position: absolute;
                            left: 36vw; top:5.5vh;border-radius:0.25vw;'></ul>";
                  if (!isset($_SESSION['userId'])){
                   ?> 
                   <a href="login.php" class = "headerLoginButton" style="padding-top: 1.8vh;">Log In</a>
                    <?php
                    }
                    if (isset($_SESSION['userId']))
                    {
                        ?>
                    <form action = "logout.inc.php" method = "post">
                        <button type = "submit" name = "logout-submit" class = "headerLoginButton" 
                            style="background: none; border: none;padding-top:1.45vh;">Log Out</button>
                    </form>
                <?php
                    }
                }
        else if(startsWith($link, "http://localhost/lifescoin/login.php") || startsWith($link, "http://localhost/Lifescoin/login.php")) 
            echo "<div id = 'container' class = 'Main-Title'  style='height: 9.5vh;left: 0;'>
              <a href = 'index.php' id='container' class='logoButton'><img class = 'mainLogo' style='height: 9.5vh; width: 19vw;' src='images/mainLogo.png'/></a>
                <a href='signup.php' class = 'headerLoginButton' style='padding-top:3.1vh;'>Sign Up</a>
                ";
 
        echo "</div>"; //to close off Main-Title div (main header class!)
    ?>
