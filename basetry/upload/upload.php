<?

if(isset($_FILES)) {

$allowedTypes = array('image/jpeg','image/png','image/gif','text/plain');

$uploadDir = "./uploads/"; //Директория загрузки. Если она не существует, обработчик не сможет загрузить файлы и выдаст ошибку

for($i = 0; $i < count($_FILES['file']['name']); $i++) { //Перебираем загруженные файлы

$ext = end(explode('.',basename($_FILES['file']['name'][$i])));
	echo 'xx'.$ext.'xx';
	
$uploadFile[$i] = $uploadDir . 'try1'.'.'.$ext;

$fileChecked[$i] = false;

echo $_FILES['file']['name'][$i]." | ".$_FILES['file']['type'][$i]." — ";

for($j = 0; $j < count($allowedTypes); $j++) { //Проверяем на соответствие допустимым форматам

if($_FILES['file']['type'][$i] == $allowedTypes[$j]) {

$fileChecked[$i] = true;

break;

}

}

if($fileChecked[$i]) { //Если формат допустим, перемещаем файл по указанному адресу


if(move_uploaded_file($_FILES['file']['tmp_name'][$i], $uploadFile[$i])) {

echo "Успешно загружен <br>";

} else {

echo "Ошибка ".$_FILES['file']['error'][$i]."<br>";

}

} else {

echo "Недопустимый формат <br>";

}

}

} else {

echo "Вы не прислали файл!" ;

}

?>