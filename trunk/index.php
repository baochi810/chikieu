
<?php
/**
 * Created by PhpStorm.
 * User: BaoChi
 * Date: 7/20/14
 * Time: 9:30 AM
 */

include_once 'common/header.php';
require_once 'common/language.php';
?>


<div class='midle-center'>
<table style="margin: 0 auto">
    <form name="loginForm" method="post" action="login.php">
    <tr>
        <td>
            <input name="password" type="password">
        </td>
        <td>
            <input type="submit" name="Submit" value="<?php echo LA_LOGIN_BUTTON; ?>">
        </td>
    </tr>
    </form>
</table>
</div>


<?php
include_once 'common/footer.php'
?>