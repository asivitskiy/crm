<div class="adminpanel">
<?
//Панель управления счетами и зарплатами
// ?action=administrating
/*include("dbconnect.php");*/


//ссылки на операции
if ($_GET['filter'] == 'startscreen') {  ?>
    <? if ($_SESSION['supervisor'] == 1) { ?>
		<a class="a_orderrow" href="_oborot.php">ОБОРОТЫ</a><br>
    <? } ?>
		<a class="a_orderrow" href="?action=administrating&filter=add_demand">Выставить счет</a><br>
        <!--<a class="a_orderrow" href="http://192.168.1.221/?&myorder=0&noready=0&showlist=&delivery=1&manager=<?/* echo $userdata*/?>"></a>-->
		<a class="a_orderrow" href="http://192.168.1.221/?action=administrating&filter=demand_list_first">Список незакрытых счетов</a><br>
		<!--<a class="a_orderrow" href="?action=administrating&filter=all_demands">Все счета</a><br><br>-->
		<!--<a class="a_orderrow" href="?action=administrating&filter=new_all_demands">Новый список счетов</a><br><br>-->
        <a class="a_orderrow" href="?action=rashodka">Расходка общая</a><br>
        <a class="a_orderrow" href="http://192.168.1.221/?&myorder=0&noready=0&showlist=&delivery=1&manager=Ю">Ю</a>
        <a class="a_orderrow" href="http://192.168.1.221/?&myorder=0&noready=0&showlist=&delivery=1&manager=Н">Н</a>
        <a class="a_orderrow" href="http://192.168.1.221/?&myorder=0&noready=0&showlist=&delivery=1&manager=Ч">Ч</a>
        <a class="a_orderrow" href="http://192.168.1.221/?&myorder=0&noready=0&showlist=&delivery=1&manager=Е">Е</a>
        <a class="a_orderrow" href="http://192.168.1.221/?&myorder=0&noready=0&showlist=&delivery=1&manager=П">П</a>


    <br>
	<? if ($_SESSION['supervisor'] == 1) { ?>	<a class="a_orderrow" href="?action=zarplata">Зарплатная таблица</a><br><br> <? } ?>

<? } ?>




<? //блок для выставления счета (пок что без инклудов - всё в одном файле беспрерывным кодом) ?>

<?
//первый этап добавления счета - вывод списка запрошенных счетов с сортировкой по заказчику
//........................................................................
//........................................................................
if ($_GET['filter'] == 'add_demand') {
	?>
	<br><a class="a_orderrow" href="?action=administrating&filter=startscreen">Вернутсья в панель администрирования</a>
	<form method="post" action="?action=administrating&filter=demand_count">
        <table class="adminpanel__demands">

	<?
	echo '<h3>Запросы счетов:</h3>';
	include("dbconnect.php");
	// рабочее окно администратора базы данныъ
	// тут своя таблица заказов
	$main_sql = "   SELECT * FROM `order`
	                LEFT JOIN `contragents` ON order.contragent = contragents.id
	                WHERE ((order.paystatus>0) and (order.paylist=''))
	                ORDER by contragents.name DESC";
	$main_array = mysql_query($main_sql);
	/*echo mysql_error(); */

	while ($main_data = mysql_fetch_array($main_array)) {

		$sss = $main_data['order_number'];
		$sss2 = $main_data['order_manager'];

        $order_amount_calc_array = mysql_fetch_array(mysql_query("        SELECT SUM(works.work_count*works.work_price)  ssmm
                                                              FROM `works`
                                                              WHERE works.work_order_number = '$sss'
                                                              GROUP BY works.work_order_number"));
        $sss3 = number_format($order_amount_calc_array['ssmm'],2, '.', ' ');

		echo '<tr><td height="30" border="1" style="white-space: nowrap"><input type="checkbox" style="height:20px; width:20px;margin-top: 4px; margin-right: 15px;" name="names['.$sss.']"></td><td>
		<a style="display: inline-block; width:65px;"
		href=?action=redact&order_number='.$sss.'>'.$sss2.'-'.$sss.'
		</a> <div style="width: 90px; display: inline-block; text-align: left; margin-right: 15px; margin-left: 5px;white-space: nowrap;"> '.$sss3.'</div>'.$main_data['name'].' ==> '.$main_data['order_description'].'</td></tr>';
	}
	?>
        </table>
	<input type="submit" value="Рассчитать">
	</form>
	<?
}
?>



<?
//второй этап добавления счета - рассчет суммы по выделенным счетам
//........................................................................
//........................................................................
if ($_GET['filter'] == 'demand_count') {
	?>
	<br><a class="a_orderrow" href="?action=administrating&filter=startscreen">Вернутсья в панель администрирования</a>;
	<form method="post" action="?action=administrating&filter=complete_demand">
	<?

	$searchstring1 = array_keys($_POST['names']);
	$searchstring = implode(',',$searchstring1);
	//поиск контрагента из номера бланка
	$contragent_info_array = mysql_query(	"SELECT * FROM `order`
											LEFT JOIN `contragents` ON contragents.id = order.contragent
											WHERE `order_number` IN ($searchstring) LIMIT 1");
	$contragent_info_data = mysql_fetch_array($contragent_info_array);



	// рабочее окно администратора базы данныъ
	// тут своя таблица заказов
	$amount_demand_works = 0;
	$main_sql = "SELECT * FROM `works` WHERE `work_order_number` IN ($searchstring)";
	$main_array = mysql_query($main_sql);
	mysql_error();
	while ($main_data = mysql_fetch_array($main_array)) {
		$amount_demand_works = $main_data['work_price']*$main_data['work_count'] + $amount_demand_works;
		?><input type=hidden name=names[<? echo $main_data['work_order_number']; ?>] value="<? echo $main_data['work_order_number']; ?>"> <?
	}
	echo '<b>Заказчик:</b> '.$contragent_info_data['name'].'<br>';
	echo '<b>Контакты:</b> <div style=width:400px;>'.$contragent_info_data['contacts'].'</div><br>';
	echo '<b>Реквизиты:</b> <div style=width:400px;> '.$contragent_info_data['fullinfo'].'</div><br>';
	echo '<b>Общая сумма:</b> '.$amount_demand_works.'<br>';
	echo '<b>Номера заказов:</b> '.$searchstring.'<br>';
	//поиск последнего счета для этого клиента (чтобы понять с какой организации был выставлен)
	echo "<br><b>Оплаты по последним 10 бланкам:</b><br>";
	$last_demand_sql = "SELECT * FROM `order` WHERE `contragent` = ".$contragent_info_data['id']." LIMIT 10";
	$last_demand_array = mysql_query($last_demand_sql);
	while ($last_demand_data = mysql_fetch_array($last_demand_array)) {
		echo $last_demand_data['paymethod']."; ";
	}
	?>
	<br><br>
	<input type="text" name="paylist" placeholder="Номер счета">

	<select name="paymethod">
		<option value="ООО">ООО</option>
		<option value="ИП">ИП</option>
		</select>
	<br>
	<input type="submit" value="Записать">
	<input type="hidden" name="amount_of_orders" value="<? echo $amount_demand_works; ?>">
	<input type="hidden" name="contragent_id" value="<? echo $contragent_info_data['id']; ?>">
	</form>
	<br>
	Информация о заказах, включаемых в счет:
	<table class="adminpanel_main_table">
		<tr>
			<td>Номер бланка</td>
			<td>Изделие</td>
			<td>Описание</td>
			<td>Изготовитель</td>
			<td>Расход</td>
			<td>Цена</td>
			<td>Количество</td>
			<td>Сумма</td>
		</tr>

	<?
	$info_order_sql = 	"SELECT * FROM `order`
						WHERE `order_number` IN ($searchstring)";
	$info_order_array = mysql_query($info_order_sql);
	while ($info_order_data = mysql_fetch_array($info_order_array)) {
		$info_order_number = $info_order_data['order_number'];
	?>

		<tr style="background-color: #D3D3D3">
			<td><? echo $info_order_number; ?></td>
			<td colspan="7"><? echo $info_order_data['order_description'] ?></td>

		</tr>
		<?
		$info_works_sql = "SELECT * FROM `works` WHERE `work_order_number` = '$info_order_number'";
		$info_works_array = mysql_query($info_works_sql);
		while ($info_works_data = mysql_fetch_array($info_works_array)) {
			?>
			<tr style=" background-color: #F0F0F0">
				<td></td>
				<td><? echo $info_works_data['work_name']; ?></td>
				<td><? echo $info_works_data['work_description']; ?></td>
				<td><? echo $info_works_data['work_tech']; ?></td>
				<td><? echo $info_works_data['work_rashod']; ?></td>
				<td><? echo $info_works_data['work_price']; ?></td>
				<td><? echo $info_works_data['work_count']; ?></td>
				<td><? echo (($info_works_data['work_price']*1)*($info_works_data['work_count']*1)); ?></td>
			</tr>
		<?
		}
		?>
	<tr style="padding: 0px; border-spacing: 0px; border: 0px;"><td>&nbsp;</td></tr>
	<?
	$prev_order_number = $info_order_data['order_number'];
	} ?>
	</table>
	<b>Итог: <? echo $amount_demand_works; ?></b>




	<?
}
?>


<?
//тертий этап добавления счета - вписывание номера счета и типа оплаты во все бланки связанные
//........................................................................
//........................................................................
if ($_GET['filter'] == 'complete_demand') {
			$datein = date("YmdHi");
			$amount_of_orders = $_POST['amount_of_orders'];
			$paylist = $_POST['paylist'];
			$contragent_id = $_POST['contragent_id'];
			$paymethod = $_POST['paymethod'];
			$orders = array_keys($_POST['names']);
				//вставка номер счета в таблицу с номерами счетов
				mysql_query("INSERT INTO `contragent_demand` (
															contragent_demand_summ,
															contragent_demand_name,
															contragent_demand_date_in,
															contragent_demand_paymethod,
															contragent_demand_paid,
															contragent_demand_contragent_id
															)
															VALUES
															(
															'$amount_of_orders',
															'$paylist',
															'$datein',
															'$paymethod',
															'0',
															'$contragent_id'
															)
															");
				$aaa = mysql_query("SELECT `contragent_demand_id` FROM `contragent_demand` WHERE `contragent_demand_name` = '$paylist' LIMIT 1");
				$aaa_data = mysql_fetch_array($aaa);
				$aaa_result = $aaa_data['contragent_demand_id'];
			/*$orders = array_unique($orders);*/
			foreach	($orders as $key => $value) {
				mysql_query("UPDATE `order` SET `paylist` = '$paylist' WHERE (`order_number` = '$value')");
				mysql_query("UPDATE `order` SET `paylist_id` = '$aaa_result' WHERE (`order_number` = '$value')");
				mysql_query("UPDATE `order` SET `paymethod` = '$paymethod' WHERE (`order_number` = '$value')");
				//вставка в таблицу связей (заказ-номер счета - клиент)
					mysql_query("INSERT INTO `contragent_demand_order_key` (
															cdok_order,
															cdok_demand,
															cdok_contragent,
															cdok_contragent_demand_id
															)
															VALUES
															(
															'$value',
															'$paylist',
															'$contragent_id',
															'$aaa_result'
															)
															");

			}
				$sucsess_ckeck_sql = "SELECT * FROM `order` WHERE order.paylist ='$paylist'";
				$sucsess_ckeck_array = mysql_query($sucsess_ckeck_sql);
				while ($sucsess_ckeck_data = mysql_fetch_array($sucsess_ckeck_array)) {
					echo "счет № ".$paylist." добавлен в бланк ".$sucsess_ckeck_data['manager']."-".$sucsess_ckeck_data['order_number']."<br>";
					$cur_manager = $sucsess_ckeck_data['order_manager'];
					$cur_order = $sucsess_ckeck_data['order_number'];
					add_history_message('manager','счет: выставлен',$cur_manager,$cur_order);
				}
			echo "если не перечислены бланки - значит счет не выставился<br>";
			echo ('<br><a href=?action=administrating&filter=startscreen>Вернутсья в панель администрирования</a>');
	/*$update_old_contragent_sql = "UPDATE `contragents` SET `name`='$contragent_name',`address`='$contragent_address',`fullinfo` ='$contragent_fullinfo',`contacts`='$contragent_contacts' WHERE (`id`='$contragent_id')";
	*/
}
?>


<?
//Первый этап промотра списка всех выставленных счетов
//........................................................................
//........................................................................
if ($_GET['filter'] == 'demand_list_first') {
	?><br><a class="a_orderrow" href="?action=administrating&filter=startscreen">Вернутсья в панель администрирования</a><br><br><?
/*	$main_sql = "SELECT DISTINCT `paylist`,`order_number` FROM `order` WHERE ((`paystatus` <> '') and (`deleted` <> 1)) ORDER by contragent DESC";*/
	$main_sql = "SELECT `paylist`,`order_number` FROM `order` WHERE ((`paylist` <> '') and (`deleted` <> 1) and (`paystatus` <> '')) GROUP BY `paylist` ORDER by paylist DESC";
	$main_array = mysql_query($main_sql);
	/*echo mysql_error(); */

	while ($main_data = mysql_fetch_array($main_array)) {
		$sss = $main_data['paylist'];
		//обнуление массива номеров заказов с текущим счетом
		$order_numbers = array();
		$order_amount = 0;
		$paycheck = 0;
		$colorflag = '';
		$colorflag2 = '';
		//запрос номеров заказов по номеру счета (их там может быть несколько)
		$secondary_array = mysql_query("SELECT * FROM `order` LEFT JOIN `contragents` ON order.contragent = contragents.id WHERE order.paylist = '$sss' ");
		while ($secondary_data = mysql_fetch_array($secondary_array)) {
				//обнуление суммы по заказу

				$order_contragent_name = $secondary_data['name'];
				/*echo($order_contragent_name);*/
				$order_number = $secondary_data['order_number'];
				//добавление очередного номера заказа в массив номеров заказов
				array_push($order_numbers,$order_number);
					$summ_array = mysql_query("SELECT `work_price`,`work_count` FROM `works` WHERE `work_order_number` = '$order_number'");
					while ($summ_data = mysql_fetch_array($summ_array)) {

						$order_amount = $order_amount + $summ_data['work_price']*$summ_data['work_count'];

					}
			//выборка из таблицы MONEY для проверки оплачен ли счет. если оплачен - подсветка зеленым строки
				$paycheck_sql = "SELECT * FROM `money` WHERE `parent_order_number` = '$order_number'";
				$paycheck_array = mysql_query($paycheck_sql);
				while ($paycheck_data = mysql_fetch_array($paycheck_array)) {
					$paycheck = $paycheck + $paycheck_data['summ']*1;
				}

		}

		//Вывод строки на экран

		/*echo $sss.' =>'.$main_data['order_number'].'<br>';*/
		if ((abs($paycheck - $order_amount)<0.1) and ($paycheck > 0)) {$colorflag = "color:black";$colorflag2 = "background-color: #C4D9C4"; /*echo '<b>'.$paycheck.' / '.$order_amount.'</b>';*/}
			?>

			<div class="paylist_row" style="white-space: nowrap; <? echo($colorflag2); ?>">

			<a class="adminpanel_a"  style="overflow: hidden; width: 185px;<? echo $colorflag; ?>" href="?searchstring=<? echo $main_data['paylist'] ;?>&delivery=1&myorder=1&noready=&showlist=">
				<b><? echo $main_data['paylist'] ; ?></b>
			</a>

				<div style="width: 230px;display: inline-block; white-space: nowrap; overflow: hidden;"?><? echo $order_contragent_name; ?> </div>
				<div style="width: 130px;display: inline-block; text-align: right;"?><b> <? echo $order_amount; ?> руб. </b></div>

			<a class="adminpanel_a" style=" <? echo $colorflag; ?>"; href="_payment_processor.php?action=plusmoney&paylist=<? echo $main_data['paylist'] ;?> ">
				Счет оплачен
			</a>

<!--			<a class="adminpanel_a" <? /*echo 'style='.$colorflag;*/ ?>; href="">
				Отменить оплату

			</a>-->
			<div style="display:inline-block; ">
			<? echo " ("; echo implode(', ',$order_numbers).')';/* echo '  '.$order_contragent_name.'---'; echo $order_amount;*/?></div>
			<div style="display: inline-block; width: 5px; height: 0px;">&nbsp;</div>

			</div>

			<?
	}


}
?>


<?
//новый список счетов
//........................................................................
//........................................................................
if ($_GET['filter'] == 'new_all_demands') {
	//в запросе сортировка по дате выставления счета от новых к старым
	$new_demand_list_query = "SELECT * FROM `contragent_demand`
							LEFT JOIN `contragent_demand_order_key` ON contragent_demand_order_key.cdok_demand = contragent_demand.contragent_demand_name
							LEFT JOIN `contragents` ON contragent_demand.contragent_demand_contragent_id = contragents.id
							WHERE contragent_demand.contragent_demand_paid <> '3'
							GROUP BY contragent_demand.contragent_demand_name
							ORDER BY contragent_demand.contragent_demand_date_in DESC

							";
	$new_demand_list_array = mysql_query($new_demand_list_query);

	while ($new_demand_list_data = mysql_fetch_array($new_demand_list_array)) {
		//вывод одной строки
		//одна строка-один выставленный счет

		?>
		<div class="" style="display: table; padding: 0; margin: 0; border-spacing: 0px; height: 25px; border: 1px solid black; padding: 3px; margin-bottom: 5px; border-radius: 4px; white-space: nowrap; ">
			<div style="display: table-cell; vertical-align: middle; border: 0px solid gray; height: 100%; width: 150px;">
				<? echo $new_demand_list_data['contragent_demand_name']; ?>
				</div>
			<div style="display: table-cell; vertical-align: middle; border: 0px solid gray; height: 100%; width: 80px; background-color: aliceblue; text-align: right; padding-right: 5px;">
				<? echo $new_demand_list_data['contragent_demand_summ']; ?>
				</div>
			<div style="display: table-cell; vertical-align: middle; border: 0px solid gray; height: 100%; width: 300px; overflow: hidden; ">
				<? echo $new_demand_list_data['name']; ?>
				</div>
			<div style="border-radius: 3px; display: table-cell; padding-left: 4px; padding-right: 4px; vertical-align: middle; border: 2px solid green; height: 100%; width: 60px; overflow: hidden; ">
				сумма верна
				</div>
			<div style="display: table-cell; vertical-align: middle; ">
				&nbsp;
				</div>
			<div style="border-radius: 3px;display: table-cell; padding-left: 4px; padding-right: 4px; vertical-align: middle; border: 2px solid red; height: 100%; width: 60px; overflow: hidden; ">
				не оплачен
				</div>
			<div style="display: table-cell; vertical-align: middle; ">
				&nbsp;
				</div>
			<div style="border-radius: 3px;display: table-cell; padding-left: 4px; padding-right: 4px; vertical-align: middle; border: 2px solid green; height: 100%; width: 60px; overflow: hidden; ">
				оплатить
				</div>



		</div>






	<?

	} 	/*print_r($resultr);*/

} ?>


</div>
