<?php
/**
 * Created by PhpStorm.
 * User: BaoChi
 * Date: 7/7/15
 * Time: 11:05 AM
 */

require_once '../../common/DBConnector.php';

session_start();

$type=$_POST['type'];
$money=$_POST['money'];
$content=$_POST['content'];
$specialtype=$_POST['specialtype'];

$sql="INSERT INTO ".dbInOutTable." (inoutid, userid, type, specialtype, content, money, date) VALUES ('NULL','".$_SESSION["userid"]."','".$type."','".$specialtype."','".$content."','".$money."000',now())";

mysqli_query($connection,$sql);
// header("location:home.php");
echo "1";



?>