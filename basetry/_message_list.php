<? $current_manager = $_SESSION['manager']; ?>
<? 	$now_date = date('YmdHis');
	mysql_query("UPDATE `users` SET `last_visit_messages`='$now_date' WHERE `word` = '$current_manager'"); ?>
<!--Стартовый экран с кнопкой добавления и списком цепочек-->
<? if ($_GET['step'] == 'start_page') { ?>

<form method="post" action="<? echo 'http://'.$_SERVER['SERVER_NAME'].':'.$_SERVER['SERVER_PORT'].'/_message_processor.php';?>">
<input type="submit" name="new_chain" value="(+) Новая цепочка">
</form>
<br>
Незакрытые цепочки: <br>
<?
$chain_output_sql = "SELECT *,messages_chains.id as idd FROM `messages_chains` 
LEFT JOIN `users` ON users.word=messages_chains.asking_pearson
WHERE 
(
	(`flag_of_chain_close` = 0) 
	and 
	(
		(`responders` LIKE '%$current_manager%') 
		or 
		(`responders` = 'all')
		or 
		(`asking_pearson` = '$current_manager')
	)
)";
$chain_output_array = mysql_query($chain_output_sql);
while ($chain_output_data = mysql_fetch_array($chain_output_array)) {
	
	?>
	
	<div class="chain_body">
		<div class="chain_header">
		<b>
			<? echo dig_to_d($chain_output_data['date_of_chain_start']).".".dig_to_m($chain_output_data['date_of_chain_start'])." "; ?>
			<? echo "(".dig_to_h($chain_output_data['date_of_chain_start']).":".dig_to_minute($chain_output_data['date_of_chain_start']).")   "; ?>
			<? echo $chain_output_data['a3']; ?> -> <? echo $chain_output_data['responders']; ?>
		</b><Br>
			<? echo $chain_output_data['chain_header'];?>
		</div>
		
			<?
				$current_chain = $chain_output_data['idd'];
				$text_sql = "	SELECT * FROM `messages_texts` 
								LEFT JOIN `users` ON messages_texts.text_writer = users.word
								WHERE `text_parent_chain` = '$current_chain'";
				$text_array = mysql_query($text_sql);
				while ($text_data = mysql_fetch_array($text_array)) {
					?><div class="chain_text" style="border: 0px solid gray; background-color:#FcFcFc; border-radius: 5px; margin-bottom: 5px; padding: 5px;"><?
					echo "<b>";
					echo dig_to_d($text_data['message_text_date_in']).".".dig_to_m($text_data['message_text_date_in'])." ";
					echo "(".dig_to_h($text_data['message_text_date_in']).":".dig_to_minute($text_data['message_text_date_in']).")   ";
					echo "</b>";
					echo nl2br($text_data['a3']."<br>".$text_data['message_text']."<br>");
					?></div><?
					
				}
			?>
		<br>
		<!--</div>-->
	
	<a href="_message_processor.php?action=newtext&chain=<? echo $chain_output_data['idd'];?>" class="a_orderrow">Ответить</a>
	<a href="_message_processor.php?action=setclose&chain=<? echo $chain_output_data['idd'];?>" class="a_orderrow">Завершить</a>
	<!--<a href="ya.ru" class="a_orderrow">Удалить</a>-->
	
	</div>
		
		
	
	
<? } ?>
<? } ?>



<!--Стартовый экран с кнопкой добавления и списком цепочек-->
<? if ($_GET['step'] == 'new_chain') { ?>

<form method="post" action="<? echo 'http://'.$_SERVER['SERVER_NAME'].':'.$_SERVER['SERVER_PORT'].'/_message_processor.php';?>">

Ответственные<br>
	<? 	$hum_sql = "SELECT * FROM `users`"; 
		$hum_array = mysql_query($hum_sql)	;
		while ($hum_data = mysql_fetch_array($hum_array)) {
			?> <input type="checkbox" name=names[<? echo $hum_data['word'];?>]> <? echo $hum_data['a3'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
		}
				?>
	
<br>
<textarea name="message_text" style="width: 700px; height: 200px;"></textarea><br>
<input type="submit" name="add_new_chain" value="Добавить">
</form>


<? } ?>








<!--окно ввода сообщения-->
<? if ($_GET['step'] == 'addnewtext') { ?>

<form method="post" action="<? echo 'http://'.$_SERVER['SERVER_NAME'].':'.$_SERVER['SERVER_PORT'].'/_message_processor.php';?>">
	<? 
		$current_chain = $_GET['arg'];
		$chain_red_array = mysql_query("SELECT * FROM `messages_chains` WHERE `id` = '$current_chain'");
		$chain_red_data = mysql_fetch_array($chain_red_array);
			echo $chain_red_data['chain_header'];
	?>
<br>

<textarea name="message_text" style="width: 700px; height: 200px;"></textarea><br>
<input type="hidden" name="arg" value="<? echo $_GET['arg']?>">
<input type="submit" name="add_new_text" value="Добавить">
</form>


<? } ?>






