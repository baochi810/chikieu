<?php
/**
 * Created by PhpStorm.
 * User: BaoChi
 * Date: 7/8/15
 * Time: 9:57 PM
 */
include_once "../common/header.php";

?>
<script src="../common/jquery.number.min.js"></script>
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
    $(document).ready(function(){

        var jpage = parseInt(getUrlParameter("page"),10);

        $.post("../apis/inout/inoutlist.php",
            {
                page:jpage
            },
            function(data,status){
                if ($.trim(data) == '1'){
                    window.location.replace("home.php");
                }
                else
                {
                    $("#tbodyContent").empty();

                    $.each(data, function (index, value) {
                        var cl = "";
                        var typename = "";
                        if (value.type == '0'){
                            cl = "<td style='font-size:20px;color: #00e516'><b>";
                            typename ="In";
                        } else if (value.type == '1'){
                            cl = "<td style='font-size:20px;color: #E80000'><b>";
                            typename ="Out";
                        } else if (value.type == '2'){
                            cl = "<td style='font-size:20px;color: #00e516'><b>";
                            typename ="Debt";
                        } else {
                            cl = "<td style='font-size:20px;color: #E80000'><b>";
                            typename ="Pay Debt";
                        }
                        $('#table-custom-2 > tbody:last').append('<tr>' + cl + $.number(parseInt(value.money,10)) + '</b><a href="confirmdel.php?id='+value.id+'" rel="external"><img src="../resource/del_icon.png" /></a> </td><td>' + value.content + '</td><td style="font-size:10px; color:#98949a"><i>' + value.date + '</i></td></tr>');
                    });
                }



            },"json");

        // Neu nhan nut
        $("#btn_next").click(function(){
            var jpage = parseInt(getUrlParameter("page"),10);
            jpage++;

            window.location.replace("listview.php?page=" + jpage);
        });

        $("#btn_next2").click(function(){
            var jpage = parseInt(getUrlParameter("page"),10);
            jpage++;

            window.location.replace("listview.php?page=" + jpage);
        });

        $("#btn_previous").click(function(){
            var jpage = parseInt(getUrlParameter("page"),10);
            jpage--;
            if (jpage < 0)
            jpage = 0;

            window.location.replace("listview.php?page=" + jpage);
        });

        $("#btn_previous2").click(function(){
            var jpage = parseInt(getUrlParameter("page"),10);
            jpage--;
            if (jpage < 0)
                jpage = 0;

            window.location.replace("listview.php?page=" + jpage);
        });

        $("#btn_back").click(function(){
            window.location.replace("../inout.php");
        });

        $("#btn_back2").click(function(){
            window.location.replace("../inout.php");
        });

    });
</script>


<table align="center">
    <tr>
        <td><input id="btn_back" type="submit" name="Submit" value="Back"></td>
        <td><input id="btn_previous" type="submit" name="Submit" value="Previous"></td>
        <td><input id="btn_next" type="submit" name="Submit" value="Next"></td>
    </tr>
</table>

<table data-role="table" id="table-custom-2" class="ui-body-d ui-shadow table-stripe ui-responsive" data-column-btn-theme="b" data-column-btn-text="Columns to display..." data-column-popup-theme="a">
    <thead>
    <tr class="ui-bar-d">

        <th style="width:30%" data-priority="3">Money</th>
        <th style="width:30%" data-priority="1"><abbr title="Rotten Tomato Rating">Content</abbr></th>
        <th style="width:40%" data-priority="5">Date</th>
    </tr>
    </thead>
    <tbody id="tbodyContent">

    </tbody>
</table>

<table align="center">
    <tr>
        <td><input id="btn_back2" type="submit" name="Submit" value="Back"></td>
        <td><input id="btn_previous2" type="submit" name="Submit" value="Previous"></td>
        <td><input id="btn_next2" type="submit" name="Submit" value="Next"></td>
    </tr>
</table>