<?
include("dbconnect.php");
// Если запрос не AJAX или не передано действие, выходим
if ($_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest' || empty($_REQUEST['action'])) {exit();}
$action = $_REQUEST['action'];
switch ($action) {
    case 'getContent':
        // Если не передан id страницы, тоже выходим
        $id = isset($_REQUEST['id']) ? (int) $_REQUEST['id'] : 0;
        if (empty($id)) {
            exit();
        };
				}
$order_number = $id;

//формируем табличку с данными заказа ?>
<div class="details_of_order ">

 <table class="table table-sm table-borderless" style="width: 1000px; pointer-events: none;">
  <tbody>
    <tr style="background-color: antiquewhite;">

      <th >Техника</th>
      <th >Шир</th>
      <th >Выс</th>
      <th >Цвет</th>
      <th >Материал</th>
      <th >Постпечать</th>
      <th >Цена</th>
      <th >кол.</th>
      <th >Сумма</th>

    </tr>
<?
		echo $order_number;
		$sps_redact = "SELECT * FROM `works` WHERE (`work_order_number` = '$order_number')";
		$sps_array = mysql_query($sps_redact);
		while($sps_data = mysql_fetch_array($sps_array))
	    { ?>
     <tr class="order_details">
      <td ><b><? echo $sps_data['work_name']; ?></b><p><? echo $sps_data['work_description']; ?></td>
      <td ><? echo $sps_data['work_tech']; ?></td>
      <td ><? echo $sps_data['work_shir']; ?></td>
      <td ><? echo $sps_data['work_vis']; ?></td>
      <td ><? echo $sps_data['work_color']; ?></td>
      <td ><? echo $sps_data['work_media']; ?></td>
      <td ><? echo $sps_data['work_postprint']; ?></td>
      <td ><? echo $sps_data['work_price']; ?></td>
      <td ><? echo $sps_data['work_count']; ?></td>
      <td ><? echo $sps_data['work_price']*$sps_data['work_count']; ?></td>
	  
    </tr>
    
    <? $amount_order = $sps_data['work_price']*$sps_data['work_count'] + $amount_order;	?>
    <? } ?>
    
    <tr class="order_details">
    	<td colspan="7" style="border: none;"></td>
    	<td colspan="3" style="">
    	Итог: <b style="float: right;"><? echo $amount_order; ?>  руб.</b> 
    	</td>
    </tr>
    
  </tbody>
</table>
	
</div>


<?
session_write_close();

?>