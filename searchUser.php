<?php
    $searchValue = $_POST['searchVal'];
    $output = '';
    if($searchValue != '')
    {
        $con = mysqli_connect('localhost', 'root', '') or die(mysqli_error($con));
        mysqli_select_db($con, "lifescoin");

        $searchValue = preg_replace("#^0-9a-z#i", "", $searchValue);

        $sql = "SELECT uidUsers FROM users WHERE uidUsers LIKE ?;";
        $stmt = mysqli_stmt_init($con);

        if(mysqli_stmt_prepare($stmt,$sql))
        {
            $searchValue = '%' . $searchValue . '%';
            mysqli_stmt_bind_param($stmt,"s", $searchValue);
            mysqli_stmt_execute($stmt);

            $result = mysqli_stmt_get_result($stmt);
            while($row = mysqli_fetch_array($result))
            {
                $output .= "<div style='color:black; margin-left: 0.5vw;margin-top:0.5vh;margin-bottom:0.5vh;margin-top:2vh;'>
                            $row[0]
                    </div>";
            }
        }

        mysqli_stmt_close($stmt);
    }
    echo $output;
?>