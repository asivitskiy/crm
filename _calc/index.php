
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
<title></title>
<head>
    <link rel="stylesheet" href="style.css">
    <SCRIPT type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></SCRIPT>
    <script>
        function bookCalc(){
            console.clear();
            /*var _element = $(_el).parents('.bookCalcClass');*/
            var _bnwCount = 1*$("input[name$='bnwPageCount']").val();
            var _colorCount = 1*$("input[name$='colorPageCount']").val();
            var _bound =        $("select[name$='bound'] option:selected").val();
            var _colorDensity = $("select[name$='colorDensity'] option:selected").val();
            var _coverColor =   $("select[name$='coverColor'] option:selected").val();
            var _coverMedia =   $("select[name$='coverMedia'] option:selected").val();
            var _duplexMode =   $("select[name$='duplexMode'] option:selected").val();
            var _format =       $("select[name$='sizeOfBook'] option:selected").val();
            var _coverLam =     $("select[name$='coverLam'] option:selected").val();
            console.log(_bnwCount);
            console.log(_coverLam);
            console.log(_colorCount);
            console.log(_bound);
            console.log(_format);
            console.log(_coverColor);
            console.log(_coverMedia);
            console.log(_duplexMode);
            console.log(_colorDensity);

            //ПРАЙС (константы) в пересчете в А4
            _colorLowPrice = 6;
            _colorMidPrice = 7;
            _colorHighPrice = 7.75;

            _bnwPagePrice = 2.1;

            _paperPrice = 2;

            _sra3PrintPrice = 21;
            _sra3BnwPrintPrice = 12;

            _media300g = 20;
            _media200g = 13;
            _media150g = 9;
            _media80g = 4;

            _lam32mkm = 25;

            _skrepkaA4 = 3;
            _metalSpringBase = 15;
            _metalSpringOneSheet = 0.5;
            _plastCover = 40;
            _klei = 45;

            _coverPrice40_200 = 61;
            _coverPrice44_200 = 82;
            _coverPrice41_200 = 72;
            _coverPrice11_200 = 62;
            _coverPrice10_200 = 51;

            _coverPrice40_300 = 100;
            _coverPrice44_300 = 120;
            _coverPrice41_300 = 110;
            _coverPrice11_300 = 100;
            _coverPrice10_300 = 90;


            pageSum = _colorCount + _bnwCount;


            //считаем листы внутреннего блока
            //if (_coverSource == "Листы из общего блока") {
            //    if ((_coverColor == "4+4") or (_coverColor == "1+1") or (_coverColor == "4+1")) {
             //       innerColorPages = _colorCount - 4;
            //    }
            //    if ((_coverColor == "4+0") or (_coverColor == "1+0")) {
            //
             //   }
            //}

            switch(_format) {
                case 'А4':
                    koeff = 1;
                    break;

                case 'А5':
                    koeff = 0.52;
                    break;

                case 'А6':
                    koeff = 0.3;
                    break;


            }
       //считаем бумагу исходя из дуплекса печати внутреннего блока
                if ((_duplexMode == "Односторонняя")) {
                    innerPaperCount = pageSum;
                    $("option:contains('Скрепка')").remove();
                }
                if  (
                    (_duplexMode == "Двусторонняя")
                    )
                {
                    innerPaperCount = Math.ceil(pageSum/2);
                    if (($("option:contains('Скрепка')").size() < 1)) {
                        $("select[name$='bound']").append(new Option("Скрепка"));
                    }
                }

            if ((innerPaperCount > 50)) {
                $("option:contains('Скрепка')").remove();
            }
            if  (
                ((innerPaperCount <= 50))
            )
            {
                innerPaperCount = Math.ceil(pageSum/2);
                if (($("option:contains('Скрепка')").size() < 1)) {
                    $("select[name$='bound']").append(new Option("Скрепка"));
                }
            }






       //определяем прайс цветного отпечатка
            switch(_colorDensity) {
                case 'Низкая':

                    colorPagePrice = _colorLowPrice;
                    break;

                case 'Средняя':
                    colorPagePrice = _colorMidPrice;
                    break;

                case 'Высокая':
                    colorPagePrice = _colorHighPrice;
                    break;
            }

            fullPRICE = 0;

            //БЛОК========================================


            blockprice = 0;
            //считаем цветные отпечатки
            blockprice += _colorCount * colorPagePrice;
            //считаем чернобелые отпечатки
            blockprice += _bnwCount * _bnwPagePrice;
            //считаем бумагу (уже с учетом односторонние двусторонних
            blockprice += _paperPrice * innerPaperCount;

            blockprice = Math.ceil(blockprice * koeff);
            fullPRICE += blockprice;

            //ОБЛОЖКА========================================
            //
            switch(_coverMedia) {
                case '200г/м2':
                    coveMediaPrice = _media200g;
                    break;

                case '300г/м2':
                    coveMediaPrice = _media300g;
                    break;

                case '150г/м2':
                    coveMediaPrice = _media150g;
                    break;

                case '80г/м2':
                    coveMediaPrice = _media80g;
                    break;

                    case '---Нет---':
                    coveMediaPrice = 0;
                    break;
            }

            coveMediaPrice = Math.ceil(koeff * coveMediaPrice);

            switch(_coverColor) {
                case '4+0':
                    coverPrintPrice = _sra3PrintPrice;
                    break;
                case '---Нет---':
                    coverPrintPrice = 0;
                    break;

                case '4+4':
                    coverPrintPrice = _sra3PrintPrice + _sra3PrintPrice;
                    break;

                case '4+1':
                    coverPrintPrice = _sra3PrintPrice + _sra3BnwPrintPrice;
                    break;

                case '1+1':
                    coverPrintPrice = _sra3BnwPrintPrice + _sra3BnwPrintPrice;
                    break;

                case '1+0':
                    coverPrintPrice = _sra3BnwPrintPrice;
                    break;
            }

            coverPrintPrice = Math.ceil(coverPrintPrice * koeff);

            switch(_coverLam) {
                case '---Нет---':
                    coverLamPrice = 0;
                    break;

                case '32мкм глянец':
                    coverLamPrice = 25;
                    break;

            }
            coverLamPrice = Math.ceil(koeff * coverLamPrice);

            //СБОРКА========================================

            switch(_bound) {
                case '---Нет---':
                    boundPrice = 0;
                    console.log(boundPrice);
                    break;
                case 'Пружина':
                    boundPrice = 15 + 0.5*innerPaperCount;
                    console.log(boundPrice);
                    break;

                case 'Скрепка':
                    boundPrice = 3;
                    console.log(boundPrice);
                    break;

                case 'Клей':
                    boundPrice = 45;
                    console.log(boundPrice);
                    break;
                    
                case 'Пластик+прозрачка':
                    boundPrice = 40;
                    console.log(boundPrice);
                    break;

            }
            boundPrice = Math.ceil(koeff * boundPrice);


            coverFullPrice = coverLamPrice + coverPrintPrice + coveMediaPrice;


            console.log("coverFullPrice -> " + coverFullPrice);

            fullPRICE += coverFullPrice;

            fullPRICE += boundPrice;

            fullPRICE = Math.ceil(fullPRICE);
            //console.log("pagesum -> " + pageSum);
            //console.log("fulprice -> " + fullPRICE);

            $(".resultprice").text("");
            $(".resultprice").text(fullPRICE);

            $(".blockprice").text("");
            $(".blockprice").text(blockprice);

            $(".coverprice").text("");
            $(".coverprice").text(coverFullPrice);

            $(".boundprice").text("");
            $(".boundprice").text(boundPrice);

        }
    </script>
</head>

<body>
<br>
<a href="./../?&myorder=0&noready=1&showlist=&delivery=1&manager=current" style="background-color: #D7544F; padding: 10px; border-radius: 10px; color: white; font-size: 24px;">Вернуться в базу</a>
<div class="content">
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
    <div class="content_wrapper" class="bookCalcClass">
        <form method="get" action="index.php">
            <h2>Готовый формат</h2>
                <select name="sizeOfBook" onkeyup="bookCalc(this)" onClick="bookCalc(this)">
                    <option>А4</option>
                    <option>А5</option>
                    <option>А6</option>
                </select>
            <Br>



            <h2>Двусторнняя печать блока</h2>
            <select name="duplexMode" onkeyup="bookCalc(this)" onClick="bookCalc(this)">
                <option selected>Двусторонняя</option>
                <option>Односторонняя</option>
            </select>

            <h2>Чернобелых страниц в блоке</h2>
            <input name="bnwPageCount" onkeyup="bookCalc()" onClick="bookCalc()" type="text" style="padding: 10px; border-radius:5px; font-size: 24px; width: 90px">

            <h2>Цветных страниц в блоке</h2>
            <input type="text" name="colorPageCount" onkeyup="bookCalc(this)" onClick="bookCalc(this)" style="padding: 10px; border-radius:5px; font-size: 24px; width: 90px">

            <h2>Плотность цветных страниц</h2>
            <select name="colorDensity"  onkeyup="bookCalc(this)" onClick="bookCalc(this)">
                <option >Низкая</option>
                <option selected>Средняя</option>
                <option>Высокая</option>
            </select>

            <h2>Сборка</h2>
            <select name="bound"  onkeyup="bookCalc(this)" onClick="bookCalc(this)">
                <option>---Нет---</option>
                <option selected>Пружина</option>
                <option>Клей</option>
                <option>Скрепка</option>
                <option>Пластик+прозрачка</option>
            </select>


            <h2>Обложка цвет</h2>
            <select name="coverColor" onkeyup="bookCalc(this)" onClick="bookCalc(this)">
                <option>---Нет---</option>
                <option selected >4+0</option>
                <option>4+4</option>
                <option>4+1</option>
                <option>1+0</option>
                <option>1+1</option>
            </select>


            <h2>Обложка бумага</h2>
            <select name="coverMedia" onkeyup="bookCalc(this)" onClick="bookCalc(this)">
                <option>---Нет---</option>
                <option>300г/м2</option>
                <option selected >200г/м2</option>
                <option>150г/м2</option>
                <option> 80г/м2</option>
            </select>

            <h2>Обложка ламинация</h2>
            <select name="coverLam" onkeyup="bookCalc(this)" onClick="bookCalc(this)">
                <option>---Нет---</option>
                <option selected >32мкм глянец</option>
            </select>

            <Br> <Br>
                <button type="submit" style="padding: 10px; border-radius:5px; font-size: 24px; width: 90px">Далее</button>
        </form>
    </div>
        <div class="content_wrapper">
            <div class="innercontent">
                <h1>Результат расчета:</h1>
                Общая:
                <div class="resultprice"></div>
                Блок:
                <div class="blockprice"></div>
                Обложка:
                <div class="coverprice"></div>
                Сборка:
                <div class="boundprice"></div>

            </div>
        </div>
<? } ?>



<? } ?>
<?  //end of IF
    } ?>
</div>



</body>
</html>