<? include 'dbconnect.php'; ?>
<? if (($_POST['type'])=='orderdetails') { include './inc/show_order_detail.php'; } 
   if (($_POST['type'])=='neworder')     { include './inc/add_new_order.php'; } 
   if (($_GET['type'])=='redact_order')     { header("Location: ./redact_order.php?order_id=".$_GET['order_id']."&"); }


?>
