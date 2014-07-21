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


$sql="SELECT * FROM ".dbUserTable." WHERE password='$password'";

#echo $sql;
if ($result=mysqli_query($connection,$sql))
{
    // Return the number of rows in result set
    $rowcount=mysqli_num_rows($result);

    if($rowcount==1){
        echo "Okay";
// Register $myusername, $mypassword and redirect to file "login_success.php"
#    session_register("myusername");
#    session_register("mypassword");
#    header("location:login_success.php");
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