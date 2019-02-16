<?php
/**
 * Created by PhpStorm.
 * User: BaoChi
 * Date: 7/8/15
 * Time: 10:18 PM
 */

//SELECT * FROM `ckinout` ORDER BY money DESC LIMIT 2,4


require_once '../../common/global.php';
include_once '../../common/functions.php';

checkSession();
require_once "../../common/DBConnector.php";


$page=$_POST['page'];
$page = $page*20;

$sql="SELECT debtid, name, amount, date FROM ckdebt WHERE amount > 0 ORDER BY date DESC";


if ($result=mysqli_query($connection,$sql))
{
// Return the number of rows in result set
$rowcount=mysqli_num_rows($result);

if($rowcount>=1){

$str = '[';

$row = $result->fetch_array(MYSQLI_NUM);
   $count = 0;
while ($row){
    $str = $str.'{"id":"'.$row[0].'","name":"'.$row[1].'","amount":"'.$row[2].'","date":"'.$row[3].'"}';
    $count++;
    if ($count < $rowcount)
        $str = $str.",";
    $row = $result->fetch_array(MYSQLI_NUM);
}
    $str = $str."]";
    echo $str;
}
 else
echo "[]";
}
else
    echo "[]";
?>