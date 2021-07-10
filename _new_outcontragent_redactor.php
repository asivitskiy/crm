<?php
include 'dbconnect.php';

?>
<a href="?action=addnew_outcontragent">Добавить нового контрагента</a><br>


<?
$outcontragent_redactor_sql = "SELECT * FROM `outcontragent`";
$outcontragent_redactor_array = mysql_query($outcontragent_redactor_sql);
while ($outcontragent_redactor_data = mysql_fetch_array($outcontragent_redactor_array)) {
    echo $outcontragent_redactor_data['outcontragent_fullname'];
    echo '<br>';
}

?>