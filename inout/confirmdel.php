<?php
/**
 * Created by PhpStorm.
 * User: BaoChi
 * Date: 7/10/15
 * Time: 3:36 AM
 */
include_once "../common/header.php";
?>


<script>
    function getUrlParameter(sParam)
    {
        var sPageURL = window.location.search.substring(1);
        var sURLVariables = sPageURL.split('&');
        for (var i = 0; i < sURLVariables.length; i++)
        {
            var sParameterName = sURLVariables[i].split('=');
            if (sParameterName[0] == sParam)
            {
                return sParameterName[1];
            }
        }
    }


    function decide(param){
        if (param == 1){
            var jid = parseInt(getUrlParameter("id"),10);

            $.post("../apis/inout/inoutdel.php",
                {
                    id:jid
                },
                function(data,status){
                    window.location.replace("listview.php");
                });
        } else {
            window.location.replace("listview.php");
        }

    };



    $(document).ready(function(){

    });
</script>

<div data-history="false" data-role="dialog" data-overlay-theme="a" data-theme="c" data-dismissible="false" style="position: absolute;" class="ui-corner-all">
    <div data-role="content">
        <h3 class="sure-1">Do you want to delete this entry?</h3>
        <a href="#" data-role="button" data-inline="true" data-theme="c" onclick="decide(0); return false;" >Cancel</a>
        <a href="#" data-role="button" data-inline="true" data-transition="flow" data-theme="b" onclick="decide(1); return false;">Delete</a>
    </div>
</div>