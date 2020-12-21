
<?
include("dbconnect.php");
// Если запрос не AJAX или не передано действие, выходим
if ($_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest' || empty($_REQUEST['action'])) {exit();}
$action = $_REQUEST['action'];
switch ($action) {
    case 'getContent':
        // Если не передан id страницы, тоже выходим
        $id = isset($_REQUEST['id']) ? (int) $_REQUEST['id'] : 0;
        $contragent = isset($_REQUEST['aaa']) ? (int) $_REQUEST['aaa'] : 0;
        if (empty($id)) {
            exit();
        };
				}
$order_number = $id;

echo $proba;
//формируем табличку с данными заказа
        $common_order_data_array = mysql_query("SELECT * FROM `contragents` WHERE `id` = '$contragent' LIMIT 1");
        $common_order_data_data = mysql_fetch_array($common_order_data_array);
            ?>
        <div class="clientcard-wrapper">
            <div class="clientcard-left">
                <?php
            echo "<h3 class=clientinfo>Заказчик:</h3>";
            echo '<p>'.$common_order_data_data['name'].'</p>';

            echo "<h3 class=clientinfo>Контактные данные:</h3>";
            echo '<p>'.$common_order_data_data['contacts'].'</p>';
                ?>
            </div>

            <div class="clientcard-right">
                <h3>Реквизиты заказчика</h3>
                <p style="display: inline-block; width: 0px; overflow: hidden;">&nbsp;</p><? echo $common_order_data_data['fullinfo'].'<br>'; ?>
            </div>
        </div>

        <div class="spacer" style="height: 5px"></div>
               <?php


		$sps_redact = "SELECT * FROM `works` WHERE (`work_order_number` = '$order_number')";
		$sps_array = mysql_query($sps_redact);
		while($sps_data = mysql_fetch_array($sps_array))
	    { ?>

            <h1><? echo $sps_data['name']; ?></h1>
            <div class="details-row-wrapper">

                <div class="details-row">
                    <div class="details-block work-name"><?
                        echo $sps_data['work_name'].'<br><p>'.$sps_data['work_description'].'</p>';
                        ?> </div>
                    <div class="details-block work-tech"><?
                        echo $sps_data['work_tech'];
                        ?> </div>
                    <div class="details-block work-shir-vis"><?
                        echo $sps_data['work_shir'];
                        ?>&nbsp;</div>
                    <div class="details-block work-shir-vis"><?
                        echo $sps_data['work_vis'];
                        ?>&nbsp;</div>
                    <div class="details-block work-color"><?
                        echo $sps_data['work_color'];
                        ?>&nbsp;</div>
                    <div class="details-block work_media"><?
                        echo $sps_data['work_media'];
                        ?>&nbsp;</div>
                 <!--   <div class="details-block">
                        <?/* echo $sps_data['work_tech']; */?></div>-->
                    <div class="details-block postprint"><?
                        echo $sps_data['work_postprint'];
                        ?> </div>
                    <div class="details-block work-count"><?
                        echo $sps_data['work_count'];
                        ?> </div>
                    <div class="details-block work-price"><?
                        echo $sps_data['work_price'];
                        ?>р. </div>
                    <div class="details-block work-summ"><?
                        echo $sps_data['work_price']*$sps_data['work_count'];
                        ?>р. </div>
                </div>
            </div>
    <? $amount_order = $sps_data['work_price']*$sps_data['work_count'] + $amount_order;
	    }
session_write_close();
?>
</div>
