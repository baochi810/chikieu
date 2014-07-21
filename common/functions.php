<?php
/**
 * Created by PhpStorm.
 * User: BaoChi
 * Date: 7/21/14
 * Time: 8:36 AM
 */

function checkSession(){

    session_start();

    if (isset($_SESSION['userid'])){
#        echo "welcome";
    }
    else{
        header("location:index.php");
    }
}

?>