<?
include 'dbconnect.php';
session_start();
include './inc/cfg.php';
//дефолтные переменные
$q_zakazchik = '<Заказчик>
<Контакты>
<Адрес доставки>
<Реквизиты>';
$q_time_to_end = "14:00";
$q_date_to_end = date("Y-m-d");
$select_preprint = "Требуется";
$select_preprint = "Не выдано";
//						ПРОСТО ОПРЕДЕЛЯЕТСЯ ПОСТ ИЛИ ГЕТ И ДОСТАЮТСЯ ИЗ НИХ ФЛАГИ ПЕРЕДАЧИ 
	if (isset($_POST['changeorder'])) {
$flag_changeorder = $_POST['changeorder'];
$flag_changeorder_manager = $_POST['changeorder_manager'];
$flag_changeorder_number = $_POST['changeorder_number'];
}
	if (isset($_GET['changeorder'])) {
$flag_changeorder = $_GET['changeorder'];
$flag_changeorder_manager = $_GET['changeorder_manager'];
$flag_changeorder_number = $_GET['changeorder_number'];
}
///////////////////////////
//проверяем последний оформленный бланк текущего менеджера
$current_manager = $_SESSION['manager'];
$query_cclist_2 = "SELECT `name` FROM `order` WHERE ((`manager` LIKE '$current_manager') AND (`deleted` <> 1)) ORDER BY `name` DESC LIMIT 1";
$res_cclist_2 = mysql_query($query_cclist_2);
mysql_error();
$row_cclist_2 = mysql_fetch_array($res_cclist_2);
$current_number = $row_cclist_2['name'] + 1;

?>


<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="./jquery-ui.css">
 <link rel="stylesheet" href="./resources/demos/style.css">
 <script src="./jquery-1.12.4.js"></script>
 <script src="./jquery-ui.js"></script>


<?  // подключение двух скриптов автодополнения для поля заказчик и для поля работ
	include("./blank_incs/autocomplete.php"); ?>

<style type="text/css">
	body {	 /* Путь к фоновому рисунку */
    background-position: left bottom; /* Положение фона */
    background-repeat: repeat; /* Повторяем фон по горизонтали */}
	body,td,th {

	font-size: 12px;
}
	.deal_foreign22 td {vertical-align: top;}
</style>
</head>




<body style="font-family: Consolas, 'Andale Mono', 'Lucida Console', 'Lucida Sans Typewriter', Monaco, 'Courier New', 'monospace'">
<? //ДОСТАЁМ ПО НОМЕРУ БЛАНКА ВЕСЬ ЗАКАЗ
	if ($flag_changeorder == '1') {
		$current_manager = $flag_changeorder_manager;
		$current_number = $flag_changeorder_number;
		
		$blank_number = $current_manager."-".$current_number;
			//--------------------
			$q_redact = "SELECT * FROM `order` WHERE ((`manager` = '$current_manager') AND (`name` = '$current_number') AND (`deleted` <> '1'))";
			$q_array = mysql_query($q_redact);
			$q_data = mysql_fetch_array($q_array);
			//--------------------

			//--------------------
			$q_zakazchik = $q_data['contragent'];
				$z_redact = "SELECT * FROM `contragents` WHERE `id` = '$q_zakazchik'";
				$z_array = mysql_query($z_redact);
				$z_data = mysql_fetch_array($z_array);
			$q_zakazchik = $z_data['contragent_shortcut'];
			//--------------------
		
		$select_preprint = $q_data['preprint'];
		$select_delivery = $q_data['delivery'];
		$select_soglas = $q_data['soglas'];
		$select_handing = $q_data['handing'];		
		$select_paymethod = $q_data['paymethod'];		
		$select_paystatus = $q_data['paystatus'];		
		$q_vneseno = $q_data['vneseno'];	
		$q_order_description = $q_data['order_description'];
		$q_time_to_end = $q_data['time_to_end'];
		$q_date_to_end = $q_data['date_to_end'];
		
	} 
	?>
<form action="dob_red_processor.php" method="POST">
<input type="hidden" name="current_manager" value="<? echo $current_manager; ?>">
<? if ((isset($_POST['changeorder'])) or (isset($_GET['changeorder']))) { ?> <input type="hidden" name="changeorder" value="1"> <? } ?>
<table class="deal_foreign" id="deal_foreign"  border="0" bordercolor="#CCCCCC" style="background-color: rgba(200,200,200,0.7); display: inline-block; float: left;">
   	<tbody>
    	<tr>
    		<td colspan="6">
    			<table border="0" class="deal_foreign22" id="deal_foreign">
    				<tr>
						<td>Бланк &nbsp;<b><? echo($current_manager); ?>-</b><input type="text" name="nomer_blanka" style="width: 100px;" value="<? printf("%04d", $current_number); ?>">&nbsp;&nbsp;<input type="submit" name="act_type" value="Выбрать другого клиента" style="width: 170px">&nbsp;&nbsp;<input type="submit" name="act_type" value="Изменить данные клиента" style="width: 180px"></td>
    					
    					<td align="right" colspan="2">Дата сдачи <input type="date" style="font-size: 10pt; width: 150px;" name="datetoend" value="<?php echo($q_date_to_end); ?>"> Время сдачи <input type="time" value="<? echo ($q_time_to_end); ?>" name="timetoend"></td>
    				</tr>
    				<tr>
						<td>Заказчик <textarea class="autocomplete_deals ac_input tags"  name="zakazchik" style="width: 500px; height: 100px;" id="tags" autocomplete=""><? echo($q_zakazchik);?>
</textarea><br></td>
    					
     					<td><br>
  						СОГЛАСОВАНИЕ -> <select  name="soglas" style="height: 25px; width: 145px;"><option <? if ($select_soglas == 'Согласовано') {echo('selected');} ?> value="Согласовано">Согласовано</option>
      								<option  <? if ($select_soglas == 'На согласовании') {echo('selected');} ?> value="На согласовании">На согласовании</option>
							</select><br>
  						ДОПЕЧАТЬ -> &nbsp;&nbsp;&nbsp;&nbsp;<select  name="preprint" style="height: 25px; width: 145px;"><option <? if ($select_preprint == 'Требуется') {echo('selected');} ?> value="Требуется">Требуется</option>
      								<option  <? if ($select_preprint == 'Подготовлено') {echo('selected');} ?> value="Подготовлено">Подготовлено</option>
									<option  <? if ($select_preprint == 'Не требуется') {echo('selected');} ?> value="Не требуется">Не требуется</option>
							</select><br>
  						ДОСТАВКА -> &nbsp;&nbsp;&nbsp;&nbsp;<select  name="delivery" style="height: 25px; width: 145px;"><option <? if ($select_delivery == 'Требуется') {echo('selected');} ?> value="Требуется">Требуется</option>
      								<option  <? if ($select_delivery == 'Не требуется') {echo('selected');} ?> value="Не требуется">Не требуется</option>
							</select><br>
  						
  						
   						</td>
   						
    					<td><br>
     								Выдача -> <select  name="handing" style="height: 25px; width: 175px;"><option  <? if ($select_handing == 'Не выдано') {echo('selected');} ?>  value="Не выдано">Не выдано</option>
      								<option  <? if ($select_handing == 'Частично выдано') {echo('selected');} ?>  value="Частично выдано">Частично выдано</option>
									<option  <? if ($select_handing == 'Выдано') {echo('selected');} ?>  value="Выдано">Выдано</option>
							</select><br>
     								Оплата -> <select  name="paymethod" style="height: 25px; width: 175px;"><option <? if ($select_paymethod == 'Наличные') {echo('selected');} ?> value="Наличные">Наличные</option>
      								<option <? if ($select_paymethod == 'Безнал') {echo('selected');} ?> value="Безнал">Безнал</option>
									<option <? if ($select_paymethod == 'Другое') {echo('selected');} ?> value="Другое">Другое</option>
							</select><br>
     								Статус -> <select  name="paystatus" style="height: 25px; width: 175px;"><option <? if ($select_paystatus == 'Не оплачено') {echo('selected');} ?> value="НЕОПЛАЧЕНО">Не оплачено</option>
      								<option <? if ($select_paystatus == 'Частично оплачено') {echo('selected');} ?> value="Частично оплачено">Частично оплачено</option>
									<option <? if ($select_paystatus == 'Оплачено') {echo('selected');} ?> value="Оплачено">Оплачено</option>								
							</select><br>
 									
  									Внесено-> <input type="text" name="vneseno" value="<? echo($q_vneseno); ?>" style="height: 25px; width: 175px;"> </td><br>
  									
    				</tr>
    				<tr>
						<td>Описание <textarea name="base_description" style="width: 500px; height: 40px;"><? echo($q_order_description); ?></textarea></td>
    					<td colspan="2"></td>
    					
    				</tr>
    			</table>
    		</td>
    	</tr>
		<tr>
      		<td colspan="3">
      			
       		</td>
       		
       	</tr>
        
        
        <tr><td colspan="6" align="right">---------------------------------------------------</td></tr>
        <tr>
            <td class="hidden_ru"></td>
            <td class="item_ru">Наименование</td>
            <td class="quantity_ru" style="width: 400px">Оборудование</td>
            
          
            <td class="quantity_ru" colspan="3">&nbsp;&nbsp;Цена &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Количество &nbsp;&nbsp;&nbsp;   Сумма</td>


        </tr>
        
		<? // подключение самой формы =================================================================== ?>
        <? //if ($flag_changeorder == 1) { 
	include('./inc/blank_form.php'); 
//} else { include('./inc/free_blank.php'); }; ?>
        <? // =========================================================================================== ?>
        
        <tr class="click"><td colspan="8" align="right"><a href="#" >++добавить</a></td></tr>
         <tr class="click2"><td colspan="8" align="right"><a href="#" >++убавить</a></td></tr>
		<tr><td colspan="8" align="right">---------------------------------------------------</td></tr>
        <tr>
            <td colspan="8"  align="right">Итог<input id="itog" type=text readonly> </td>
        </tr>

    </tbody>

    <script>
	
		$( document ).ready(function() {
			$('.click').on('click', function(){
			$(this).before($(".work_row:last").clone());
			autocompleteRun();
			});
					
		});
		$( document ).ready(function() {
			$('.click2').on('click', function(){
			$('.work_row:last').remove();
			autocompleteRun();
			});
					
		});
		
		
		
        function checkRow(_el){
            var _element = $(_el).parents('.work_row');
            var _counts = $(_element).find('[name="item_counts[]"]').val();
            var _price = $(_element).find('[name="item_prices[]"]').val();
			_price = _price.replace(/,/g, '.');
            $(_element).find('[name="result[]"]').val((_counts * _price).toFixed(2));
            var _itog = 0;
            $('.work_row').each(function(){
                _itog += $(this).find('[name="result[]"]').val()*1;
            });
            $('#itog').val(_itog.toFixed(2));
        }
        $('[name="item_counts[]"]').each(function(){
            checkRow(this);
        });
		function checkRow2(_el){
            var _element = $(_el).parents('.work_row');
            var _counts = $(_element).find('[name="item_counts[]"]').val();
            var _price = $(_element).find('[name="item_prices[]"]').val();
			_price = _price.replace(/,/g, '.');
            $(_element).find('[name="result[]"]').val((_counts * _price).toFixed(2));
            var _itog = 0;
            $('.work_row').each(function(){
                _itog += $(this).find('[name="result[]"]').val()*1;
            });
            $('#itog').val(_itog.toFixed(2));
        }
        $('[name="item_counts[]"]').each(function(){
            checkRow(this);
        });
    </script>
</table>
		<div class="calc"  style="display: inline-block; width: 140px; height: 150px; font-size: 20px; padding-left: 10px;">
           			
            			<input style="width: 80px;" onkeyup="raskladka(this)"  type="text" name="dl" placeholder="длина" autocomplete="off">
            			<input style="width: 80px;" onkeyup="raskladka(this)"  type="text" name="shir" placeholder="ширина" autocomplete="off"><br><br>
            			На лист
            			<input style="width: 80px;" type="text" value="" name="bezlam" readonly><br>
            			Под лам.
            			<input style="width: 80px;" type="text" value="" name="lam" readonly><br>       			
            			
Расклад<br><input style="width: 80px; display: inline-block; width: 35px;" type="text" value="" name="shirina" readonly><input style="width: 80px;display: inline-block; width: 35px;" type="text" value="" name="visota" readonly>
            		
<script>
        function raskladka(_el){
            var _element = $(_el).parents('.calc');
            var _counts = $(_element).find('[name="shir"]').val();
			_counts *=1;
            var _price = $(_element).find('[name="dl"]').val();
			_price *=1;
            var _col11 = Math.trunc(440/ (_counts + 3));
			var _col12 = Math.trunc(312/ (_price + 3));
			var _col21 = Math.trunc(440/ (_price + 3));
			var _col22 = Math.trunc(312/ (_counts + 3));
			var _cnt1 = _col11*_col12;
			var _cnt2 = _col21*_col22;
			var _col = Math.max(_cnt1,_cnt2);
			if (_cnt1>_cnt2) {_col=_cnt1; var _shirina = _col11; var _visota=_col12;} else {_col=_cnt2; var _shirina = _col21; var _visota=_col22;}
            $(_element).find('[name="bezlam"]').val((_col));
         	$(_element).find('[name="shirina"]').val((_shirina));
         	$(_element).find('[name="visota"]').val((_visota));
         	
			var _lam11 = Math.trunc(415/ (_counts + 3));
			var _lam12 = Math.trunc(300/ (_price + 3));
			var _lam21 = Math.trunc(415/ (_price + 3));
			var _lam22 = Math.trunc(300/ (_counts + 3));
			var _cntlam1 = _lam11*_lam12;
			var _cntlam2 = _lam21*_lam22;
			var _lamcol = Math.max(_cntlam1,_cntlam2);
			
			$(_element).find('[name="lam"]').val((_lamcol));
         	
        }
      
	
	</script>		


</div><br><br>
<div style="display: inline-block; float: left; width: 300px;">
<input type="submit" name="act_type" value="оформить заказ" style="width: 200px; display: block; float: left;"></div>
</form>

</body>