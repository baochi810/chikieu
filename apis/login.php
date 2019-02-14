<?php
/**
 * Created by PhpStorm.
 * User: BaoChi
 * Date: 7/20/14
 * Time: 11:09 AM
 */

require_once '../common/DBConnector.php';

$password=$_POST['password'];
$applogin=$_POST['applogin'];






$password = stripslashes($password);
$password = mysqli_real_escape_string($connection,$password);
date_default_timezone_set('Asia/Ho_Chi_Minh');

$sql="SELECT userid FROM ".dbUserTable." WHERE password='$password'";

#echo $sql;
if ($result=mysqli_query($connection,$sql))
{
    // Return the number of rows in result set
    $rowcount=mysqli_num_rows($result);

    if($rowcount==1){

    session_start();
    $row = $result->fetch_array(MYSQLI_NUM);

    $_SESSION["userid"] = $row[0];

    // Add log login
    $sql="INSERT INTO ckloginlog (logid, userid, date) VALUES (NULL,".$row[0].",'".date('Y-m-d H:i:s')."')";
    mysqli_query($connection,$sql);
   // header("location:home.php");
    if ($applogin == "0"){
        echo "1";
    } else if ($applogin == "1"){

        header("Location: http://chikieu.com/inout.php");
        exit();
        }

    }
    else {
        echo "0";
    }

    mysqli_free_result($result);
}
else{
    echo "3";
}




?>