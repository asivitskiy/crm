<?
include 'dbconnect.php'; 
include './inc/global_functions.php';
?>
<?
if ($_GET['change_factor'] == 'work') {
	$work_id = $_GET['id'];
	$work_change_field = $_GET['field'];
	$work_change_data = $_GET['data'];
	$sql = "UPDATE `works` SET `".$work_change_field."`='".$work_change_data."' WHERE `work_id`='".$work_id."'";
	mysql_query($sql);
}




if ($_GET['parent'] == 'blank_zakaz') {
	header('Location: http://192.168.1.221/index.php?page='.$_GET['parent'].'&changeorder=1&changeorder_number='.$_GET['number'].'&changeorder_manager='.$_GET['manager']);
}


//вот в таком виде ссылка отлично работает
//button_processor.php?change_factor=work&field=deleted&data=1&id=160681386
//parent=blank_zakaz&manager=Ю&number=1606&change_factor=work&field=deleted&data=1&id=160674443
?>
