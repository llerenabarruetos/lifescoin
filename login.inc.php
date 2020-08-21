<?php

if (isset($_POST['login-submit'])){

    require 'dbh.inc.php';

$mailuid = $_POST['mailuid'];
$password = $_POST['pwd'];

if (empty($mailuid)|| empty($password)){
    header("Location:login.php?error=emptyfields");
    exit();
}
else {
    $sql = "SELECT * FROM users WHERE uidUsers=? OR emailUsers=?;";
    $Statement = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($Statement,$sql)){
        header("Location:login.php?error=sqlerror");
        exit();
    }
    else{
function get_result( $Statement ) {
    $RESULT = array();
    $Statement->store_result();
    for ( $i = 0; $i < $Statement->num_rows; $i++ ) {
        $Metadata = $Statement->result_metadata();
        $PARAMS = array();
        while ( $Field = $Metadata->fetch_field() ) {
            $PARAMS[] = &$RESULT[ $i ][ $Field->name ];
        }
        call_user_func_array( array( $Statement, 'bind_result' ), $PARAMS );
        $Statement->fetch();
    }
    return $RESULT;
}
        mysqli_stmt_bind_param($Statement,"ss",$mailuid,$mailuid);
        mysqli_stmt_execute($Statement);
       

        $result = get_result($Statement);
        if ($row = array_shift( $result ))
        {
            $pwdCheck = password_verify($password,$row['pwdUsers']);
            if (pwdCheck == false){
                header("Location:login.php?error=wrongpwd");
                exit();
            }
            else if ($pwdCheck == true){
                session_start();
                $_SESSION['userId'] = $row['idUsers'];
                $_SESSION['userUid'] = $row['uidUsers'];
                $_SESSION['lifescoin'] = $row['likesCoin'];

                header("Location:index.php?login=success");
            }
            else {
                header("Location:login.php?error=wrongpwd");
                exit();
            }
        }
        else {
            header("Location:login.php?error=nouser");
        }
    }
}

}
else {
    header("Location:login.php");
    exit();
}