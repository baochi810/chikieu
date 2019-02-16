<?php
/**
 * Created by PhpStorm.
 * User: BaoChi
 * Date: 7/10/15
 * Time: 2:37 AM
 */

require_once '../../common/DBConnector.php';

$id=$_POST['id'];


$sql="DELETE FROM ".dbDebtTable." WHERE debtid=".$id;

mysqli_query($connection,$sql);



// header("location:home.php");
echo "1";



?>