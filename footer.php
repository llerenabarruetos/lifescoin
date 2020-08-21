<style>
    .footerContainer {
        position: absolute;
        top: 100.5vh;
        left: 0;
        width: 98.9vw;
        background-color: rgb(245, 245, 245);
        color: rgb(0, 0, 0);
        text-align: center;
        padding-top: 2.7vh;
        padding-bottom: 1vh;
        overflow: hidden;

        font-family: Arial;
    }
    .footerLink {
        color: rgb(0, 0, 0);
        display:inline; 
        white-space:nowrap;
        padding-left: 3vw; 
        font-size: 1vw;
        text-decoration: none;
    }
    .footerLink:hover {
        text-decoration: underline;
        color: rgb(0, 140, 255);
    }
</style>
<?php 
    $link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://" . $_SERVER['HTTP_HOST'] .  
                    $_SERVER['REQUEST_URI']; 
    if($link == "http://localhost/Lifescoin/signup.php") //DO BEFORE LAUNCH: 
        echo "<div class='footerContainer' style='position: fixed; bottom: 0;top: auto;width: 100vw;'>";
    else
        echo "<div class='footerContainer'>";
?>
    <a href="#" class="footerLink">About</a>
    <a href="#" class="footerLink">Terms</a>
    <a href="#" class="footerLink">Privacy</a>
    <a href="#" class="footerLink">FAQ</a>
    <div style="margin-top: 2vh;margin-bottom:1vh;margin-left: 2.5vw;font-size: 1vw;">LifesCoin © 2020</div>
</div>