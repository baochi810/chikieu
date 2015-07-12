<?php
/**
 * Created by PhpStorm.
 * User: BaoChi
 * Date: 8/4/14
 * Time: 9:13 AM
 */


include_once 'common/functions.php';

checkSession();

include_once "common/header.php";
require_once "common/DBConnector.php";
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
