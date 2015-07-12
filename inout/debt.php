<?php
/**
 * Created by PhpStorm.
 * User: BaoChi
 * Date: 7/7/15
 * Time: 10:26 AM
 */

include_once '../common/functions.php';

checkSession();

include_once "../common/header.php";
require_once '../common/language.php';
?>

<script>
    $(document).ready(function(){

        $("#btn_back").click(function(){
            window.location.replace("../inout.php");
        });
        // Neu nhan nut
        $("#btn_add").click(function(){
            var spt = "";
            if ( $("#checkbox-v-1a").is(":checked") ){
                spt = "1";
            } else {
                var spt = "0";
            }
            $.post("../apis/inout/inoutadd.php",
                {
                    type:"2",
                    specialtype:spt,
                    money:$("#money").val(),
                    content:$("#content").val()
                },
                function(data,status){
                    if ($.trim(data) == '1'){
                        $("#result_s").text('Done');
                        $("#money").val('');
                        $("#content").val('');
                    }
                    else
                    {
                        $("#result_p").text('Fail');
                    }
                });

        });
    });
</script>

<div style="position: absolute; top: 15%; margin-top: -2em; left: 50%;">
    <div style="position: relative; left:-50%">
    <table style="margin: 0 auto; width: 300px">
        <tr>
            <td>
                <div style="color:#3158e8; text-align: center; font-size: 15;" ><b>Debt</b></div>
            </td>
        </tr>
        <tr>
            <td>
                <div id="result_p" style="color:#E80000; text-align: center" ></div>
            </td>
        </tr>
        <tr>
            <td>
                <div id="result_s" style="color:#0026e8; text-align: center" ></div>
            </td>
        </tr>
        <tr>
            <td>
                <div style="padding: 0px; margin: 0px; width: 300px">
                    <table style="margin: 0 auto">
                        <tr>
                            <td>
                                <div >

                                    <label for="checkbox-v-1a" style="padding-top: 7px;padding-bottom: 7px;">
                                        Visa
                                    </label>

                                    <input id="checkbox-v-1a" type="checkbox" name="checkbox-v-1a" data-cacheval="true"></input>

                                </div>
                            </td>
                            <td>
                                <input type="number" id="money" name="money">
                            </td>
                            <td valign="bottom">
                                <div style="margin-bottom: 6px;">
                                    <small><b><i>.000</i></b></small>
                                </div>
                                <!-- <input id="btn_login" type="submit" name="Submit" value="<?php echo LA_LOGIN_BUTTON; ?>"> -->
                            </td>
                        </tr>
                    </table>
                </div>
            </td>

        </tr>
        <tr>
            <td>
                <div  style="padding-left: 2px; padding-right: 2px; padding-top: 0px; padding-bottom: 0px; margin: 0px">
                    <textarea id="content" style="margin: 0px;"></textarea>
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div  style="padding-left: 2px; padding-right: 2px; padding-top: 0px; padding-bottom: 0px; margin: 0px">
                    <input id="btn_add" type="submit" name="Submit" value="<?php echo LA_ADD_BUTTON; ?>">
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div  style="padding-left: 2px; padding-right: 2px; padding-top: 0px; padding-bottom: 0px; margin: 0px">
                    <input id="btn_back" type="submit" value="<?php echo LA_BACK_BUTTON; ?>">
                </div>
            </td>
        </tr>
    </table>
    </div>
</div>


<?php

?>
