<!DOCTYPE html>
<html>
<head>
    <link rel="apple-touch-icon" sizes="180x180" href="img/apple-touch-icon.png">
    <link rel="icon" type="img/png" sizes="32x32" href="img/favicon-32x32.png">
    <link rel="icon" type="img/png" sizes="16x16" href="img/favicon-16x16.png">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;400;500;700&display=swap" rel="stylesheet">
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

  <div class="container">

       <!-- //слайдер вместе с плашкой сайта-->
    <? /*inlclude 'content_pages/main_page.php';*/
        require 'content_pages/main_page.php';
    ?>

    <div class="footer-wrapper site-padding clearfix">
        <div class="contact-us clearfix">
            <h3>contact us</h3>
            <p>132A Bridge Road Richmond VIC
                Australia.<Br><Br>Talk to us on 1300 132
                info@interior.com</p>
        </div>
        <div class="useful-info clearfix">
            <h3>Useful Information</h3>
            <a href=# class="uinfo">Sales terms</a>
            <a href=# class="uinfo">architect accounts</a>
            <a href=# class="uinfo">Customer care</a>
            <a href=# class="uinfo">careers</a>
            <a href=# class="uinfo">delivery</a>
            <a href=# class="uinfo">exchanges & returns</a>
        </div>
        <div class="lets-stay clearfix">
            <h3>Let’s Stay in Touch!</h3>
            <p>Suscribe to know about our latest news, products and special offers just for suscribers.</p>
            <input type="text" class="lets-stay-input" placeholder="your email address">
        </div>
    </div>
        <div class="end-wrapper clearfix site-padding">
            <div class="end-of-page-left clearfix">
                © Copyright - INTERIOR 2016. All Rights Reserved.
            </div><div class="end-of-page-center clearfix">
                <img src="img/social-links.png">
            </div><div class="end-of-page-right clearfix">
                Terms & Conditions  /  Privacy policy & Cookies
            </div>
        </div>



  </div>


</body>
</html>