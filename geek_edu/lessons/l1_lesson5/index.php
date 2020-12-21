<!DOCTYPE html>
<html>
<head>
    <link rel="apple-touch-icon" sizes="180x180" href="img/apple-touch-icon.png">
    <link rel="icon" type="img/png" sizes="32x32" href="img/favicon-32x32.png">
    <link rel="icon" type="img/png" sizes="16x16" href="img/favicon-16x16.png">

    <link rel="mask-icon" href="img/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">
	<meta charset="utf-8">
	<title>Личный сайт студента GeekBrains</title>

	<link rel="stylesheet" href="inc/style.css">
</head>
<body>
<!--<p style="font-size: 10px">** Страничка выполнена на PHP,
    поэтотому у вас не получится просмотреть её в работе на своем компьютере без установки окружения (denwer/xampp/nginx либо что-то еще)</p>
<a href="http://sivitskiy.pro" style="margin-left: 15%">Вернуться на исходную страницу</a>-->
<div class="header_wrapper">
   <div class="header">
        <? include 'inc/header.php';?>
    </div>
</div>
<div class="content">



    <?
        switch ($_GET['page']) {
            case ('mainpage'):
                include 'content_pages/main_page.php';
                break;

            case (''):
                include 'content_pages/main_page.php';
                break;

            case 'item1':
                include 'content_pages/item1.php';
            break;
           case 'catalogue':
                include 'content_pages/catalogue.php';
            break;

            case 'contact_page':
                include 'content_pages/contact_page.php';
            break;

            case 'item1':
                include 'content_pages/item1.php';
            break;

            case 'item2':
                include 'content_pages/item2.php';
            break;

 /*           case 'guess':
                include 'content_pages/guess.php';
            break;

            case 'randompassword':
                include 'content_pages/randompassword.php';
            break;*/



        }
    ?>

</div>
<div class="footer_wrapper">
	<div class="footer">
		<? include 'inc/footer.php';?>
	<div>
</div>

</body>
</html>