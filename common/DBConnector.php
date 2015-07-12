<?php
require_once 'global.php';
require_once 'language.php';
/**
 * Created by PhpStorm.
 * User: BaoChi
 * Date: 7/20/14
 * Time: 10:25 AM
 */

$connection = mysqli_connect(host, dbUsername, dbPassword, dbName) or die (LA_CANNOT_CONNECT_DB);


// Check connection
if (mysqli_connect_errno())
{
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
?>