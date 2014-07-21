<?php
/**
 * Created by PhpStorm.
 * User: BaoChi
 * Date: 7/20/14
 * Time: 11:09 AM
 */

require_once 'common/DBConnector.php';

$password=$_POST['password'];






$password = stripslashes($password);
$password = mysqli_real_escape_string($connection,$password);


$sql="SELECT userid FROM ".dbUserTable." WHERE password='$password'";

#echo $sql;
if ($result=mysqli_query($connection,$sql))
{
    // Return the number of rows in result set
    $rowcount=mysqli_num_rows($result);

    if($rowcount==1){
        echo "Okay";

    session_start();
    $row = $result->fetch_array(MYSQLI_NUM);
        echo "User id : $row[0]";
    $_SESSION["userid"] = $row[0];
    header("location:home.php");
    }
    else {
        echo "Bitch";
    }

    mysqli_free_result($result);
}
else{
    echo "Deo vao duoc";
}




?>