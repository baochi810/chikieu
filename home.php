<?php
/**
 * Created by PhpStorm.
 * User: BaoChi
 * Date: 7/21/14
 * Time: 7:37 AM
 */

include_once 'common/functions.php';

checkSession();

include_once "common/header.php";
require_once "common/DBConnector.php";
?>

    <div class="ui-content" role="main">
        <ul  data-role="listview" data-inset="true">
            <li class=" ui-first-child"><a class="ui-btn" href="home.php">
                    <h2>Home</h2>
                </a>
            </li>


<?php

$sql="SELECT * FROM ckmenu";

if ($result=mysqli_query($connection,$sql))
{
    // Return the number of rows in result set
    $rowcount=mysqli_num_rows($result);

    if($rowcount>=1){


        $row = $result->fetch_array(MYSQLI_NUM);
        while ($row){
            // Kiem tra count trong tung menu
            $sql = "SELECT count FROM ckmenucounter WHERE userid=".$_SESSION["userid"]." and menuid=".$row[0];
            if ($result2 = mysqli_query($connection,$sql)){
                // Neu chua tung co count thi insert
                $rowcount2 = mysqli_num_rows($result2);
                if ($rowcount2 == 0){
                    $sql = "INSERT INTO ckmenucounter (counterid, userid, menuid, count) VALUES (NULL, '".$_SESSION["userid"]."', '".$row[0]."', '0')";
                    mysqli_query($connection,$sql);
                }

            }
            $row = $result->fetch_array(MYSQLI_NUM);
        }

        // Sau khi insert xong thi loi ra lai
        $sql = "SELECT menuid FROM ckmenucounter WHERE userid=".$_SESSION["userid"]." ORDER BY count DESC";
        if ($result2 = mysqli_query($connection,$sql)){

            $row = $result2->fetch_array(MYSQLI_NUM);

            while ($row){
                $sql = "SELECT * FROM ckmenu WHERE menuid=".$row[0];
                if ($result3 = mysqli_query($connection,$sql)){
                    $row2 = $result3->fetch_array(MYSQLI_NUM);
                    if ($row2){
                        echo '<li><a class="ui-btn" href="/'.$row2[2].'"><h2>'.$row2[1].'</h2></a></li>';
                    }

                }

                $row = $result2->fetch_array(MYSQLI_NUM);
            }

        }

    }
    else {
        echo "0";
    }

    mysqli_free_result($result);
}


?>

        <li class="ui-last-child"><a class="ui-btn" href="logout.php">
                <h2>Log out</h2>
    </a>
        </li>
    </ul>
        </div>

<?php
include_once "common/footer.php";
?>