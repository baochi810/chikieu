<?php
/**
 * Created by PhpStorm.
 * User: BaoChi
 * Date: 8/4/14
 * Time: 9:13 AM
 */


require_once 'common/DBConnector.php';
include_once 'common/functions.php';

include_once "common/header.php";

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

    session_start();
    $row = $result->fetch_array(MYSQLI_NUM);

    $_SESSION["userid"] = $row[0];

    // Add log login
    $sql="INSERT INTO ckloginlog (logid, userid, date) VALUES (NULL,".$row[0].",now())";
    mysqli_query($connection,$sql);
   // header("location:home.php");


    mysqli_free_result($result);
}
}




checkSession();

?>

<div class="ui-content" role="main">
    <ul  data-role="listview" data-inset="true">
        <li class=" ui-first-child"><a class="ui-btn" href="inout/income.php">
                <h2>Income</h2>
            </a>
        </li>
        <li><a class="ui-btn" href="inout/outcome.php">
                <h2>Outcome</h2>
            </a>
        </li>
        <li><a class="ui-btn" href="inout/debt.php">
                <h2>Debt</h2>
            </a>
        </li>
        <li><a class="ui-btn" href="inout/paydebt.php">
                <h2>Pay Debt</h2>
            </a>
        </li>
        <li><a class="ui-btn" href="inout/chart.php">
                <h2>Chart</h2>
            </a>
        </li>
        <li><a class="ui-btn" href="inout/listview.php?page=0">
                <h2>List View</h2>
            </a>
        </li>
        <li class="ui-last-child"><a class="ui-btn" href="apis/logout.php">
                <h2>Log out</h2>
            </a>
        </li>
    </ul>
</div>
<?php

?>
