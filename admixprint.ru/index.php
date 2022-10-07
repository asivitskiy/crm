<?php
include "./db.php";
?><!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="./css/newstyle5.css?<? echo rand(1111,9999); ?>">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&family=Roboto:ital,wght@0,300;0,400;0,500;0,700;0,900;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>
<div class="main">
    <div class="upper_block">
        <div class="site">
            <div style="text-align:center">

                <!--noindex--><a href="https://go.2gis.com/in4bt">Новосибирск, Гурьевская 78, левый цоколь</a><!--/noindex-->
                <!--noindex--><a href="#"><span><strong>по будням 10:00 до 19:00</strong> пн-пт</span></a><!--/noindex-->
                <!--<a href="">Контакты</a>!-->
            </div>
        </div>
    </div>
    <div class="logoBlock">
        <div class="site">
            <div itemscope="" itemtype="http://schema.org/Organization" class="adm_top_block_container">
                <div class="adm_top_block_elem">
                    <img src="admix-logo-4.png" alt="Цифровая типография «Адмикс»" width="240">
                </div>
                <div class="adm_top_block_elem adm_top_phone">
                    <a class="telephone" href="tel:+73832075642">+7 (383) 207-56-42</a>
                    <a class="email" href="mailto:zakaz@admixprint.ru" >zakaz@admixprint.ru </a>
                    <span>цифровая, офсетная и широкоформатная печать</span>

                </div>
                <div class="adm_top_block_elem adm_top_phone">
                    <a class="telephone" href="tel:+79231242881">+7 (923) 124-28-81</a>
                    <a class="email" href="mailto:fastprint@admixprint.ru" >fastprint@admixprint.ru </a>
                    <span>Отдел выпуска проектной документации</span>

                </div>

                <div class="adm_top_block_elem messengers">
                    <a href="https://wa.me/79232401020">
                        <img src="wa.png" width="60">
                    </a>
                </div>
                <div class="adm_top_block_elem messengers">
                    <a href="https://t.me/+79232401020">
                        <img src="tg.png" width="60">
                    </a>
                </div>



            </div>
        </div>
    </div>

    <div class="menu_block">
        <div class="site">
            <nav>
                <ul class="menu">
                    <?php
                        $header_sql = "SELECT * FROM `site_categories` ORDER BY `categories_id`";
                        $header_array = mysql_query($header_sql);
                        while ($header_data = mysql_fetch_array($header_array)) {        
                                $current_cat = $header_data['categories_id'];
                                ?>
                    <li class="dropdown">
                        <!--noindex--><a class="dropbtn" href="./"><? echo $header_data['categories_name']?></a><!--/noindex-->
                        <div class="dropdown-content">
                            <div class="col">
                                <?php
                                    $el_of_cat_sql = "SELECT * FROM `site_predefined` WHERE `predef_group` = '$current_cat'";
                                    $el_of_cat_array = mysql_query($el_of_cat_sql);
                                    while ($el_of_cat_data = mysql_fetch_array($el_of_cat_array)) {
                                ?>
                                <? echo '<a class="contenthref" href="index.php?predef='.$el_of_cat_data['predef_id'].'">'.$el_of_cat_data['predef_name'].'</a>';?>
                                
                                <? } ?>
                            </div>
                            

                        </div>
                    </li>
                    <?php
                        }
                    ?>
                    

                </ul>
            </nav>
        </div>
    </div>


    <div class="site">
                <?
                if (!isset($_GET['predef'])) {
                    include "./contacts.php";
                }

                if (isset($_GET['predef'])) {
                    include "./predef_card.php";
                }
                ?>
    </div>



</body>
</html>