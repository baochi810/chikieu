
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
<script>
$(document).ready(function(){

	// Neu nhan enter
	$("input").keypress(function(event) {
		if (event.which == 13) {

			event.preventDefault();
			$.post("apis/login.php",
			{
				password:$("#pass_field").val(),
                applogin:"0"
			},
			function(data,status){
				if ($.trim(data) == '1'){
					window.location.replace("inout.php");
				}
				else
				{
					$("#result_p").text('Wrong pass, bitch');
				}



			});
		}
	});

	
	// Neu nhan nut
	$("#btn_login").click(function(){
		$.post("apis/login.php",
		{
			password:$("#pass_field").val(),
            applogin:"0"
		},
		function(data,status){
			if ($.trim(data) == '1'){
				window.location.replace("inout.php");
			}
			else
			{
				$("#result_p").text('Wrong pass, bitch');
			}
				

			
		});
	});
});
</script>

<div style="position: absolute; top: 50%; margin-top: -2em; left: 50%;margin-left: -9em;">
<table style="margin: 0 auto">
	<tr>
		<td>
			<div id="result_p" style="color:#E80000" ></div>
		</td>
	</tr>
    <tr>
        <td>
            <input id="pass_field" name="password" type="password">
        </td>
        <td>
            <input id="btn_login" type="submit" name="Submit" value="<?php echo LA_LOGIN_BUTTON; ?>">
        </td>
    </tr>
</table>
</div>



<?php
include_once 'common/footer.php'
?>