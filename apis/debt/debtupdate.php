<?php
/**
 * Created by PhpStorm.
 * User: BaoChi
 * Date: 7/7/15
 * Time: 11:05 AM
 */

require_once '../../common/DBConnector.php';

session_start();

$id=$_POST['id'];
$amount=$_POST['amount'];

$sql="SELECT debtid, name, amount, date FROM ckdebt WHERE debtid=".$id;


if ($result=mysqli_query($connection,$sql))
{
// Return the number of rows in result set
$rowcount=mysqli_num_rows($result);

if($rowcount>=1){

$row = $result->fetch_array(MYSQLI_NUM);

$new = $row[2] - $amount;

$sql="UPDATE ".dbDebtTable." SET amount='".$new."' WHERE debtid=".$id;;

mysqli_query($connection,$sql);
}
}
// header("location:home.php");
echo "1";



?>