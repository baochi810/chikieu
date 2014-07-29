<?php
/**
 * Created by PhpStorm.
 * User: BaoChi
 * Date: 7/21/14
 * Time: 8:36 AM
 */



function checkSession(){

    session_start();

    if (isset($_SESSION['userid'])){
#        echo "welcome";
    }
    else{
        header("location:index.php");
    }
}

function addMenuCount($webpage, $connection){
    $sql = "SELECT menuid FROM ckmenu WHERE webpage='".$webpage."'";
    if ($result2 = mysqli_query($connection,$sql)){

        $row = $result2->fetch_array(MYSQLI_NUM);

        if ($row){
            $sql = "SELECT count FROM ckmenucounter WHERE userid=".$_SESSION["userid"]." and menuid=".$row[0];
            if ($result3 = mysqli_query($connection,$sql)){
                $row2 = $result3->fetch_array(MYSQLI_NUM);
                if ($row2){
                    $sql = "UPDATE ckmenucounter SET count='".($row2[0] + 1)."' WHERE userid=".$_SESSION["userid"]." and menuid=".$row[0];
                    mysqli_query($connection,$sql);
                }
            }
        }
    }
}
?>