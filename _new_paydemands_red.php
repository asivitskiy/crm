<? require_once  'dbconnect.php'; ?>
<? session_start(); ?>
<?  // 't' - указывает взять последний день
    /*$last_day_this_month  = date('t',strtotime('2020-02-17'));
    echo $first_day_this_month;print'<->';echo $last_day_this_month;*/
?>
<? require_once  './inc/global_functions.php'; ?>
<? require_once  './_oborot_functions.php'; ?>
<? require_once  './inc/cfg.php'; ?>
<? $action = $_GET['action']; ?>
<? $current_manager = $_SESSION['manager']; ?>
<? if (strlen($current_manager) > 0 ) {  ?>

<?
if (isset($_GET['outcontragent_id'])) {
    $outcontragent_to_add_req = $_GET['outcontragent_id'];
    $outcontragent_to_add_req_data = mysql_fetch_array(mysql_query("SELECT * FROM `outcontragent` WHERE `outcontragent_id` ='$outcontragent_to_add_req' LIMIT 1"));
    echo "Добавление реквизитов для: ".$outcontragent_to_add_req_data['outcontragent_fullname'];
    echo "<br>";
    ?>
        <form method=post action="_new_paydemands_red.php">
            <input type="hidden" name="addreq" value="1">
            <input type="hidden" name="addreq_outcontragent_id" value="<? echo $outcontragent_to_add_req; ?>">
            ИНН<br><input type=text name=outcontragent_inn><br>
            Полные реквизиты<br>
            <textarea name=outcontragent_req_full rows="10" cols="50"></textarea>
            <br><br>
            <input type=submit  value="Добавить">
        </form>    

    <?
}
if (isset($_POST['addreq'])) {
    $addreq_inn = $_POST['outcontragent_inn'];
    $addreq_req = $_POST['outcontragent_req_full'];
    $addreq_outcontragent = $_POST['addreq_outcontragent_id'];

    $sssql = "INSERT INTO `outcontragent_req` (

    `outcontragent_id` ,
    `outcontragent_req_inn` ,
    `outcontragent_req_full`
    )
    VALUES (
        '$addreq_outcontragent', 
        '$addreq_inn', 
        '$addreq_req'
    )";
    mysql_query($sssql);
}


?>
<?
}

//переадресация обратно
//header('Location: http://'.$_SERVER['SERVER_NAME'].'/index.php?action=paydemands');

?>