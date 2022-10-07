<?  
    include_once "./inc/dbconnect.php";
    include_once "./inc/global_functions.php";
    include_once "./inc/config_reader.php";

    $qr_order_number = $_GET['order_number'];
    $qr_type = $_GET['summ'];

        //сумма остатка по заказу
		$works_sql = "SELECT SUM( works.work_price * works.work_count ) as `summa` FROM `works` WHERE `work_order_number` ='$qr_order_number'";
		$works_darray = mysql_query($works_sql);
		$works_data = mysql_fetch_array($works_darray);
		$work_amount = $works_data['summa'];
        //echo $work_amount." work_amount <br>";

		$money_sql = "SELECT SUM(money.summ) as `summa` FROM `money` WHERE `parent_order_number` ='$qr_order_number'";
		$money_darray = mysql_query($money_sql);
		$money_data = mysql_fetch_array($money_darray);
		$money_amount = $money_data['summa'];
        //echo $money_amount." money_amount <br>";

		$current_summ_forced = $work_amount - $money_amount;

	//конец расчета суммы остатка

    $qr_summ = number_format(str_replace(',','.',$current_summ_forced),2,'.','');
    
    if ($qr_type == 'forced') {
        $getcontent = "http://www.admixprint.ru/qr_generator/index.php?string=".urlencode("https://sberbank.ru/qr/?uuid=2000044976&amount=".$qr_summ); 
    }
    if ($qr_type == 'free') {
        $qr_summ = 0;
        $getcontent = "http://www.admixprint.ru/qr_generator/index.php?string=".urlencode("https://qr.nspk.ru/AS1A003AJ72EERKQ9G4P7KQN2NKTFRRP?type=01&bank=100000000111&crc=CF97");
    }
    //echo $getcontent;
    //echo $getcontent."<br>";  
    $responce = file_get_contents($getcontent);
    $sbbol_qr_png = "http://www.admixprint.ru/qr_generator/qr_store/".$responce;
     
    mysql_query("INSERT INTO `qr_pay` (`qr_pay_order_number`,`qr_pay_summ`,`qr_sended`,`qr_code_image`) VALUES ('$qr_order_number','$qr_summ',0,'$sbbol_qr_png')");
    //echo $sbbol_qr_png; 
?>

<script>window.close()</script>

