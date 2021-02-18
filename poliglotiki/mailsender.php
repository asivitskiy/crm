<?php

$filename = rand(100,200).".csv";
$list[] = array('очень длинная строка на русском языке', 'bbb', 'ccc', 'dddd');
$list[] = array('очень длинная строка на русском языке', 'bbb', 'ccc', 'dddd');
$list[] = array('очень длинная строка на русском языке', 'bbb', 'ccc', 'dddd');
$list[] = array('очень длинная строка на русском языке', 'bbb', 'ccc', 'dddd');

$fp = fopen($filename, 'w');

foreach ($list as $fields) {
    fputcsv($fp, $fields);
}

fclose($fp);



/*$to = 'test-ktcf5uyk8@srv1.mail-tester.com';
$subject = '=?utf-8?B?'.base64_encode('Тут тема').'?=';
$headers .= "From: От кого письмо <from@example.com>\r\n";
$headers .= 'Return-path: <' . $email . ">\r\n";
$headers .= 'Content-type: text/plain; charset=utf-8' . "\r\n";
$headers .= 'Content-Transfer-Encoding: quoted-printable' . "\r\n\r\n";

$message = "Тут сообщение";
$mail = mail($to, $subject, $message, $headers);*/

$name        = "Название здесь идет";
$email       = "sivikmail@gmail.com";
$to          = "$name <$email>";
$from        = "sivitskiy.pro";
$subject     = "тема ";
$mainMessage = "Привет,я сообщение с pdf файлом";
$fileatt     = $filename; // Расположение файла

$fileatttype = "application/pdf";
$fileattname = "zakaz.csv"; //Имя, которое вы хотите использовать для отправки, или вы можете использовать то же имя
$headers     = "From: $from";

// Открываем и читаем файл в переменную.
$file = fopen($fileatt, 'rb');
$data = fread($file, filesize($fileatt));
fclose($file);

// Это прикрепляет файл
$semi_rand     = md5(time());
$mime_boundary = "==Multipart_Boundary_x{$semi_rand}x";
$headers      .= "\nMIME-Version: 1.0\n" .
    "Content-Type: multipart/mixed;\n" .
    " boundary=\"{$mime_boundary}\"";
$message = "Это multi-part сообщение в формате MIME․\n\n" .
    "-{$mime_boundary}\n" .
    "Content-Type: text/plain; charset=\"iso-8859-1\n" .
    "Content-Transfer-Encoding: 7bit\n\n" .
    $mainMessage  . "\n\n";

$data = chunk_split(base64_encode($data));
$message .= "--{$mime_boundary}\n" .
    "Content-Type: {$fileatttype};\n" .
    " name=\"{$fileattname}\"\n" .
    "Content-Disposition: attachment;\n" .
    " filename=\"{$fileattname}\"\n" .
    "Content-Transfer-Encoding: base64\n\n" .
    $data . "\n\n" .
    "-{$mime_boundary}-\n";

// Отправить письмо
if(mail($to, $subject, $message, $headers))
{
    echo "Письмо отправлено.";
} else {
    echo "При отправке почты произошла ошибка.";
}

unlink($filename);
?>
