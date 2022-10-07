
<?

if (isset($_GET['filename']) and $_GET['filename']<>'') {
    $f_name_nopath = $_GET['filename'];
}
$pagecount = $_GET['pagecount'];
    $page = $_GET['page'];    
    $color = $_GET['color'];
    if (!isset($_GET['color'])) {$color = 'bnw';}
        if ($color == 'color') {$colorColor = 'clicked';} else {$colorBnw = 'clicked';} 
    $bound = $_GET['bound'];
        if ($bound == 'clip') {$boundclip = 'clicked';}
        if ($bound == 'glue') {$boundglue = 'clicked';}
        if ($bound == 'spring') {$boundspring = 'clicked';}
        
        if (!$_GET['page']) {
            $page='main';
        
        }  

function getNumPagesPdf($filepath) {
    $fp = @fopen(preg_replace("/\[(.*?)\]/i", "", $filepath), "r");
    $max = 0;
    if (!$fp) {
        return "Could not open file: $filepath";
    } else {
        while (!@feof($fp)) {
            $line = @fgets($fp, 255);
            if (preg_match('/\/Count [0-9]+/', $line, $matches)) {
                preg_match('/[0-9]+/', $matches[0], $matches2);
                if ($max < $matches2[0]) {
                    $max = trim($matches2[0]);
                    break;
                }
            }
        }
        @fclose($fp);
    }

    return $max;
} ?>
<title>tetradka.pro | распечатай себе учебник!</title>
<meta charset="utf-8" />
<meta name="keywords" content="frenglish.ru, лысенко, учебные тетради, распечатать, методичка, методическое указание,family and friends, oxford тетради, скорочтение, ментальная арифметика, распечатать книгу, рабочая тетрадь, workbook, classbook,activity book, учебник английского, английский для детей, автореферат"/>
</head>
<link rel="stylesheet" href="style.css">
<style>


</style>
<body>
<header class="main_header">
    <h2 class="header">Тетрадка.ПРО</h2>
    <h3 class="header">Служба печати и доставки учебной литературы</h3>
</header>

<nav class="margin-top-70">
        <ul class="block-center">
         
          <li>
            <a href="?page=main">О НАШЕМ СЕРВИСЕ</a>
          </li>
          
          <li>
            <a href="?page=calc" id="article-on" class="">КАЛЬКУЛЯТОР</a>
          </li>
          <li>
            <a href="?page=delivery" id="article-on" class="">ДОСТАВКА</a>
          </li>
          <li>
            <a href="?page=contacts" id="article-on" class="">КОНТАКТЫ</a>
          </li>
             
         
        </ul>
      </nav>

<div class="content">
    <? if ($page=='delivery') {?>
        <h2>Доставка осуществляется через следующие курьерские службы:</h2>
            <h3>CDEK</h3>
            <h3>Сберлогистика</h3>
            <h3>BOXBERRY</h3>
            <h3>Почта россии</h3>
        *Средняя стоимость доставки составляет 250 рублей при заказе одного изделия. В случае заказа нескольких позиций - доставка обходится значительно дешевле в пересчете на одну единицу.

    <? } ?>
    <? if ($page=='order') {?>

        <form action="processor.php" method="post">
            <input type="hidden" name="pagecount" value="<? echo $_GET['pagecount'];?>">
            <input type="hidden" name="filename" value="<? echo $_GET['filename'];?>">
            <input type="hidden" name="color" value="<? echo $_GET['color'];?>">
            <input type="hidden" name="bound" value="<? echo $_GET['bound'];?>">
            <h3 style="margin-bottom: 5px;">Укажите количество изделий<Br>
                <input type="text" name="bookcount" style="padding: 10px; border-radius:5px; font-size: 24px; width: 390px">

                <h3 style="margin-bottom: 5px;">Укажите любые актуальные контактные данные чтобы мы могли с вами связаться.</h3>
            (номер телефона, электронную почту tg либо vk)<Br>
            <input type="text" name="contacts" style="padding: 10px; border-radius:5px; font-size: 24px; width: 390px">
            <h3 style="margin-bottom: 5px;">Укажите ваш город<Br>
            <input type="text" name="city" style="padding: 10px; border-radius:5px; font-size: 24px; width: 390px">
                <br><br>
            Наш менеджер свяжется с вами в рабочее время для уточнения деталей печати и доставки<Br><Br>
            <input type="submit" value="Отправить заказ" style="background-color: #D7544F; padding: 10px; border: 0px; border-radius: 10px; color: white; font-size: 24px;">
        </form>

    <? } ?>
<? if ($page=='main') {?>
    <p style="text-indent: 25px;">
Наша компания занимается выпуском и доставкой учебных материалов, а также других многостраничных изделий любыми тиражами от 1 экземпляра.
Работаем как с частными лицами, так и с организациями.

<p style="text-indent: 25px;">Для рассчета стоимости и оформления заказа - воспользуйтесь калькулятором на нашем сайте.</p>
<p style="text-indent: 25px;">Если вы компания, родительский комитет или центр дополнительного образования и вам необходимо более одного вида продукции - перейдите в раздел контакты и выберите наиболее удобный способ связаться с нами.
Наши менеджеры выберут оптимальные для вас условия сотрудничества. При возникновении любых вопросов - пишите нам, менеджеры помогут с оформлением, либо окажут необходимую консультацию</p>
<p style="text-indent: 25px;">При оформлении крупных заказов предоставляются значительные скидки.</p>
</p>
<? } ?>

<? if ($page=='contacts') {?>
<p style="text-indent: 25px;">
Контактная информация
<p style="text-indent: 25px; font-family: FuturaLightC;" style="">тел. <a href="tel:+79232401020">+7 (923) 240-10-20</a> (звонки / Whatsapp / Telegram)</p>
<p style="text-indent: 25px; font-family: FuturaLightC;">email: <a>tetradkapro@yandex.ru</a></p>
<p style="text-indent: 25px;"></a>
</p>
<? } ?>

<?
if ($page=='calc') {

if ($_FILES && $_FILES["filename"]["error"]== UPLOAD_ERR_OK)
{    
    $color='bnw';
    $bound='glue';
    $colorbnw='clicked';
    $boundglue='clicked';
    $name = $_FILES["filename"]["name"];
    $f_name_nopath = rand(100000,999999);
    $new_file_name = './upload/'.$f_name_nopath.'.pdf';
    move_uploaded_file($_FILES["filename"]["tmp_name"], $new_file_name);
    $pdf_num_pages = getNumPagesPdf($new_file_name);
    $pagecount = $pdf_num_pages;
    
    
 
} 

if ($pagecount>0) {
    $inner_page_count = $pagecount-4;
    if ($inner_page_count<=0) {$inner_page_count = 0;}
    $color_price = ceil($inner_page_count/4)*36;
    $bnw_price = ceil($inner_page_count/4)*13;
    $skrepka_price = 5;
    $termoklei_price = 40;
    $spring_price = 20;
    $cover_price = 52;
    if ($color == 'color') {$printPrice = $color_price;}
    if ($color == 'bnw') {$printPrice = $bnw_price;}
    
    if ($bound == 'clip') {$boundPrice = $skrepka_price;}
    if ($bound == 'glue') {$boundPrice = $termoklei_price;}
    if ($bound == 'spring') {$boundPrice = $spring_price;}
    
    $itog_price = $printPrice + $boundPrice+$cover_price;
    $pagecount = $pagecount;

    echo '<h2>Количество страниц в загруженном файле: '.$pagecount."</h2>";
    ?>
    
    <div class="calc_interfacePage">
        <div class="calc_interfacePage__left">    
            <div class="calc_interfacePage__color">
                
                <h2>Цветность печати</h2>
                 
                <a href="?filename=<?echo $f_name_nopath;?>&pagecount=<? echo $pagecount;?>&page=calc&color=color&bound=<?echo $bound;?>">
                    <div class="option_box <? echo $colorColor; ?>">
                        <div class="option_box__logo"><? echo ceil($color_price); ?>р.</div>
                        <div class="option_box__label">Цветная</div>
                    </div>
                </a>
                <a href="?filename=<?echo $f_name_nopath;?>&pagecount=<? echo $pagecount;?>&page=calc&color=bnw&bound=<?echo $bound;?>">
                    <div class="option_box <? echo $colorBnw; ?>">
                        <div class="option_box__logo"><? echo ceil($bnw_price); ?>р.</div>
                        <div class="option_box__label">Черно-белая</div>
                    </div>
                </a>
            </div>
            <div class="calc_interfacePage__bounding">
                
                <h2>Способ сборки</h2>
                <a href="?filename=<?echo $f_name_nopath;?>&pagecount=<? echo $pagecount;?>&page=calc&color=<?echo $color;?>&bound=clip">
                    <div class="option_box skrepka      <? echo $boundclip; ?>   ">
                        <div class="option_box__logo"><? echo $skrepka_price; ?>р.</div>
                        <div class="option_box__label">Скрепка</div>
                    </div>
                </a>
                <a href="?filename=<?echo $f_name_nopath;?>&pagecount=<? echo $pagecount;?>&page=calc&color=<?echo $color;?>&bound=glue">
                <div class="option_box termoklei    <? echo $boundglue; ?>   ">
                    <div class="option_box__logo"><? echo $termoklei_price; ?>р.</div>
                    <div class="option_box__label">Термоклеевая</div>
                </div>
                </a>
                <a href="?filename=<?echo $f_name_nopath;?>&pagecount=<? echo $pagecount;?>&page=calc&color=<?echo $color;?>&bound=spring">
                <div class="option_box spring       <? echo $boundspring; ?> ">
                    <div class="option_box__logo"><? echo $spring_price; ?>р.</div>
                    <div class="option_box__label">Пружина</div>
                </div>
                </a>
            </div>
            <div class="calc_interfacePage__add">
                
                
                
            </div>
        </div><div class="calc_interfacePage__right">
            <h2>Итоговая стоимость: <? echo $itog_price; ?>р. </h2>
            <hr>
            Стоимость изделия включает в себя:<br>
            -обложка мелованная 200г/м2 с гляцевым покрытием: <? echo $cover_price;?>р. <br>
            -печать внутреннего блока <? if ($color=='color') {echo 'цветная';} else {echo 'черно-белая';} ?> двусторонняя : <? echo $printPrice; ?>р.<Br>
            -сборка <?
            switch ($bound) {
                case 'clip':
                    echo 'на скрпку';
                    break;
                case 'glue':
                    echo 'на темоклей';
                    break;
                case 'spring':
                    echo 'на металлическую пружину';
                    break;
            }
            ?>: <?echo $boundPrice; ?>р.
            <br>&nbsp;<br>&nbsp;<br>&nbsp;
            <a href="?filename=<?echo $f_name_nopath;?>&pagecount=<? echo $pagecount;?>&page=order&color=<?echo $color;?>&bound=<?echo $bound;?>" style="background-color: #D7544F; padding: 10px; border-radius: 10px; color: white; font-size: 24px;">Оформить заказ</a>
        </div>
        <!--
            <div class="calc_interfacePage__bot">
            <h2>В стоимость печати также включено:</h2>
            <hr>

        </div> --!>
    </div>
    <?
}  
if (!$pagecount) { 
    if (!isset($_GET['file']) and !isset($_GET['manual'])) {?>
        <div class="calc_interfacePage" style="text-align: center">
            <a href="?page=calc&file">
                <div class="option_box">
                    <div class="option_box__logo"><img src="pdf.png" width="85" height="85" style="margin-top: 10px"></div>
                    <div class="option_box__label">указать PDF файл</div>
                </div>
            </a>
            <a href="?page=calc&manual">
            <div class="option_box">
                <div class="option_box__logo"><img src="idealogo.jpg" width="85" height="85" style="margin-top: 10px"></div>
                <div class="option_box__label">ручной расчет</div>
            </div>
            </a>
        </div>
    <? } ?>

<? if (isset($_GET['file'])) { ?>
<div class="content_wrapper">
    <h2>Загрузка файла</h2>
        <form method="post" enctype="multipart/form-data">
            Выберите файл: <input accept=".pdf" style="background-color: ; padding: 10px; border: 0px; border-radius: 10px; font-size: 24px;" type="file" name="filename" size="10" /><br /><br />

            <input class="redbutton" type="submit" value="Загрузить" />
            <Br><Br><Br><Br>
            *на данный момент автоматический расчет работает только для PDF файлов.<Br>
            Если у вас файл в другом формате - <a href="index.php?page=contacts" class="redbutton" style="padding: 3px; font-size: 14px;">обратитесь к менеджеру</a> для оформления заказа, либо воспользуйтесь <a href="http://192.168.1.221/tetradka_pro_upload/?page=calc&manual" class="redbutton" style="font-size: 14px; padding: 4px"> ручным режимом.</a><Br>

        </form>
</div>
<? } ?>
<? if (isset($_GET['manual'])) { ?>
    <div class="content_wrapper">
        <form method="get">
            <h2>Укажите количество страниц</h2>
            <input type="hidden" name="page" value="calc">
            <input type="hidden" name="bound" value="glue">
            <input type="text" name="pagecount" style="padding: 10px; border-radius:5px; font-size: 24px; width: 90px">
            <br><br>
            <button type="submit" style="padding: 10px; border-radius:5px; font-size: 24px; width: 90px">Далее</button>
        </form>
    </div>
<? } ?>



<? } ?>
<?  //end of IF
    } ?>
</div>



</body>
</html>