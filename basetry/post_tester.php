<? echo '<pre>'.print_r($_POST,true).'</pre>'; ?>
<? 
$nnn[] = $_POST['item_ids'];
print_r($nnn); 
echo('количество записей в таблице ->');
echo count($_POST['item_ids']);
echo(' строк');



?>
<? unset($_POST);?>