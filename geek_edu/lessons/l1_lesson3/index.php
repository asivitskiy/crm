<!DOCTYPE html>
<html>
<head>
 
	<meta charset="utf-8">
	<title>Личный сайт студента GeekBrains</title>

	<link rel="stylesheet" href="inc/style.css">
</head>
<body>

<div class="content">

    <div class="header">
        <? include 'inc/header.php';?>
        <div>
<hr>

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

<div class="footer">
    <? include 'inc/footer.php';?>
<div>


</body>
</html>