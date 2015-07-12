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
<script src="../common/jquery.number.min.js"></script>
<script>

    $(document).ready(function () {
        var d = new Date();

        var n = d.getMonth() + 1;

        $("#datepick").val(n);
        $.post("../apis/inout/inoutchart.php",
            {
                month: n
            },
            function (data, status) {

                $("#debt").text($.number(parseInt(data.debt, 10)));
                $("#hand").text($.number(parseInt(data.hand, 10)));
                $("#moutcome").text($.number(parseInt(data.moutcome, 10)));
                $("#mfoutcome").text($.number(parseInt(data.mfoutcome, 10)));

                $("#tbodyContent").empty();

                $.each(data.list, function (index, value) {
                    $('#table-custom-2 > tbody:last').append('<tr><td style="color: #E80000"><b>' + $.number(parseInt(value.money, 10)) + '</b></td><td>' + value.content + '</td><td style="font-size:10px; color:#98949a"><i>' + value.date + '</i></td></tr>');
                });
            }, "json");

        $("#btn_back").click(function(){
            window.location.replace("../inout.php");
        });

        // Neu nhan nut
        $("#btn_get").click(function(){
            $("#tbodyContent").empty();
            $("#debt").text("");
            $("#hand").text("");
            $("#moutcome").text("");
            $("#mfoutcome").text("");
            $.post("../apis/inout/inoutchart.php",
                {
                    month: $("#datepick").val()
                },
                function (data, status) {

                    $("#debt").text($.number(parseInt(data.debt, 10)));
                    $("#hand").text($.number(parseInt(data.hand, 10)));
                    $("#moutcome").text($.number(parseInt(data.moutcome, 10)));
                    $("#mfoutcome").text($.number(parseInt(data.mfoutcome, 10)));

                    $("#tbodyContent").empty();

                    $.each(data.list, function (index, value) {
                        $('#table-custom-2 > tbody:last').append('<tr><td style="color: #E80000"><b>' + $.number(parseInt(value.money, 10)) + '</b></td><td>' + value.content + '</td><td style="font-size:10px; color:#98949a"><i>' + value.date + '</i></td></tr>');
                    });
                }, "json");
        });

    });
</script>
<div style="position: absolute; top: 15%; margin-top: -2em; left: 50%;">
    <div style="position: relative; left:-50%">
        <table style="margin: 0 auto; width: 300px">
            <tr>
                <td>
                    <table style="margin: 0 auto; width: 300px">
                        <tr>
                            <td>
                                <b>Total debt:</b>
                            </td>
                            <td style='font-size:20px;color: #0200e5;text-align: left'><b>
                                    <div id="debt"></div>
                                </b></td>
                        </tr>
                        <tr>
                            <td>
                                <b>Money In Hand:</b>
                            </td>
                            <td style='font-size:20px;color: #00e516;text-align: left'><b>
                                    <div id="hand"></div>
                                </b></td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td>
                    <input id="btn_back" type="submit" value="<?php echo LA_BACK_BUTTON; ?>">
                </td>
            </tr>
            <tr>
                <td>
                    <table style="margin: 0 auto; width: 300px">
                        <tr>
                            <td>
                                Month
                            </td>
                            <td>
                                <input type="number" id="datepick">
                            </td>
                            <td>
                                <input id="btn_get" type="submit" name="Submit" value="Get">
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td>
                    <table style="margin: 0 auto; width: 300px">
                        <tr>
                            <td>
                                Month Used:
                            </td>
                            <td style='font-size:20px;color: #E80000;text-align: left'><b>
                                    <div id="moutcome"></div>
                                </b></td>
                        </tr>
                        <tr>
                            <td>
                                Food Used:
                            </td>
                            <td style='font-size:20px;color: #E80000;text-align: left'><b>
                                    <div id="mfoutcome"></div>
                                </b></td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td>
                    Highlight (>500k)
                </td>
            </tr>
            <tr>
                <td>
                    <table data-role="table" id="table-custom-2"
                           class="ui-body-d ui-shadow table-stripe ui-responsive" data-column-btn-theme="b"
                           data-column-btn-text="Columns to display..." data-column-popup-theme="a">
                        <thead>
                        <tr class="ui-bar-d">

                            <th style="width:30%" data-priority="3">Money</th>
                            <th style="width:30%" data-priority="1"><abbr title="Rotten Tomato Rating">Content</abbr>
                            </th>
                            <th style="width:40%" data-priority="5">Date</th>
                        </tr>
                        </thead>
                        <tbody id="tbodyContent">

                        </tbody>
                    </table>
                </td>
            </tr>
        </table>

    </div>
</div>