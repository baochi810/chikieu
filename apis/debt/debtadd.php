<?php
/**
 * Created by PhpStorm.
 * User: BaoChi
 * Date: 7/7/15
 * Time: 11:05 AM
 */

require_once '../../common/DBConnector.php';

session_start();

$amount=$_POST['amount'];
$name=$_POST['name'];

date_default_timezone_set('Asia/Ho_Chi_Minh');

$sql="INSERT INTO ".dbDebtTable." (debtid,name,amount , date) VALUES (NULL,'".$name."',".$amount."000,'".date('Y-m-d H:i:s')."')";

mysqli_query($connection,$sql);
// header("location:home.php");
echo "1";



?>