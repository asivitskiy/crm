<?php
$filename = $_POST['filename'];
$pagecount = $_POST['pagecount'];
$color = $_POST['color'];
$bound= $_POST['bound'];
$contacts= $_POST['contacts'];
$city= $_POST['city'];
$bookcount= $_POST['bookcount'];
$message = urlencode('Файл: http://'.$_SERVER['SERVER_NAME'].'/upload/'.$filename.'.pdf').'%0A';
$message .= urlencode('Контакты: '.$contacts).'%0A';
$message .= urlencode('Количество сраниц: '.$pagecount).'%0A';
$message .= urlencode('Цветность: '.$color).'%0A';
$message .= urlencode('Сборка: '.$bound).'%0A';
$message .= urlencode('Город: '.$city).'%0A';
$message .= urlencode('Количество: '.$bookcount).'%0A';
file_get_contents('https://wamm.chat/api2/msg_to/f0sZ7BuL/?phone=79138957956&text='.$message);


header('Location: http://'.$_SERVER['SERVER_NAME'].'/success.php');
?>