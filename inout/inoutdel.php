<?php
/**
 * Created by PhpStorm.
 * User: BaoChi
 * Date: 7/10/15
 * Time: 2:37 AM
 */

require_once '../../common/DBConnector.php';

$id=$_POST['id'];



$sql="SELECT money, content FROM ckinout WHERE inoutid=".$id;

#echo $sql;
if ($result=mysqli_query($connection,$sql))
{
    // Return the number of rows in result set
    $rowcount=mysqli_num_rows($result);

    if($rowcount==1){

        session_start();
        $row = $result->fetch_array(MYSQLI_NUM);

        $sql="INSERT INTO ckinoutlog (inoutlogid, userid, money, content, date) VALUES (NULL,".$_SESSION["userid"].",".$row[0].",'".$row[1]."',now())";
        mysqli_query($connection,$sql);

    }
}

$sql="DELETE FROM ".dbInOutTable." WHERE inoutid=".$id;

mysqli_query($connection,$sql);



// header("location:home.php");
echo "1";



?>