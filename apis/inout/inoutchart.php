<?php
/**
 * Created by PhpStorm.
 * User: BaoChi
 * Date: 7/12/15
 * Time: 5:06 PM
 */

require_once '../../common/global.php';
include_once '../../common/functions.php';

checkSession();
require_once "../../common/DBConnector.php";


$month=$_POST['month'];

// Total income
//SELECT sum(money) FROM `ckinout` WHERE (type='2') or (type = '0')

// Total outcome
//SELECT sum(money) FROM `ckinout` WHERE (type='1') or (type = '3') or (type='2' and specialtype='1')

// Total debt
//SELECT sum(money) FROM `ckinout` WHERE (type='2')

// Total pay debt
//SELECT sum(money) FROM `ckinout` WHERE (type='3')

$sql="SELECT sum(money) FROM ckinout WHERE (type=2) or (type =0)";
$result=mysqli_query($connection,$sql);
$row = $result->fetch_array(MYSQLI_NUM);
$income = (int)$row[0];

$sql="SELECT sum(money) FROM ckinout WHERE (type='1') or (type = '3') or (type='2' and specialtype='1')";
$result=mysqli_query($connection,$sql);
$row = $result->fetch_array(MYSQLI_NUM);
$outcome = (int)$row[0];

$sql="SELECT sum(money) FROM ckinout WHERE (type='2')";
$result=mysqli_query($connection,$sql);
$row = $result->fetch_array(MYSQLI_NUM);
$debt = (int)$row[0];

$sql="SELECT sum(money) FROM ckinout WHERE (type='3')";
$result=mysqli_query($connection,$sql);
$row = $result->fetch_array(MYSQLI_NUM);
$paydebt = (int)$row[0];

$month = $month.'/1/2015';

$fd = date('Y-m-01', strtotime($month));
$ld = date('Y-m-t', strtotime($month));

//$fd = new DateTime('2015-07-01');
//$ld = new DateTime('2015-07-31');

$sql="SELECT sum(money) FROM ckinout WHERE (type=1 or (type='2' and specialtype='1')) and (date >= '".$fd."' and date <= '".$ld."')";
$result=mysqli_query($connection,$sql);
$row = $result->fetch_array(MYSQLI_NUM);
$moutcome = (int)$row[0];

$sql="SELECT sum(money) FROM ckinout WHERE type=1 and specialtype=1 and (date >= '".$fd."' and date <= '".$ld."')";
$result=mysqli_query($connection,$sql);
$row = $result->fetch_array(MYSQLI_NUM);
$mfoutcome = (int)$row[0];


$str = '{"debt":"'.($debt - $paydebt).'","hand":"'.($income - $outcome).'","moutcome":"'.$moutcome.'","mfoutcome":"'.$mfoutcome.'","list":[';


$sql="SELECT content, money, date FROM ckinout WHERE (type=1 or (type='2' and specialtype='1')) and money >= 500000 and (date >= '".$fd."' and date <= '".$ld."') ORDER BY date ASC";


if ($result=mysqli_query($connection,$sql))
{
// Return the number of rows in result set
    $rowcount=mysqli_num_rows($result);

    if($rowcount>=1){
        $row = $result->fetch_array(MYSQLI_NUM);
        $count = 0;
        while ($row){
            $str = $str.'{"money":"'.$row[1].'","content":"'.$row[0].'","date":"'.$row[2].'"}';
            $count++;
            if ($count < $rowcount)
                $str = $str.",";
            $row = $result->fetch_array(MYSQLI_NUM);
        }
        $str = $str."]}";
        echo $str;
    }
}


?>