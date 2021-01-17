<div class="header_wrapper_showlist">
    <div class="header-block">
        <form action="" method="get">
            <input class="universal-search-string" type="text" onfocus='$(".header_wrapper_showlist").toggleClass("universal-search-string--focused");'  onblur='$(".header_wrapper_showlist").toggleClass("universal-search-string--focused");' placeholder="универсальный поиск" onkeyup="searchClient(this, event);searchClient2(this, event)" autocomplete="off" id="omnisearch-top" name="searchstring">
            <!--<input type="hidden" name="fulltextfilter">-->

            <?  foreach($_GET as $key => $value){
                if($key == 'searchstring') { continue; }
                if($key == 'noready') { continue; }
                if($key == 'myorder') { continue; }
                if($key == 'showlist') { continue; }
                echo "<input type='hidden' name=".$key;
                if ($value<>'') {echo " value=".$value;}
                echo ">";} ?>
           <!-- ниже - строки для отображения завершенных заказов всех менеджеров (чтобы не тыкать кнопки после поиска)-->
            <input type="hidden" name="myorder" value="1">
            <input type="hidden" name="noready" value="">
            <input type="hidden" name="showlist">
        </form>
    </div>
    <?
    //TEMP - строковые поиски
    //PERMANENT - логические поиски
    //массив кнопок (название, статусы, отображение)
    $button_default['noready'] = '0';    $button_type['noready'] = 'permanent'; $button_placeholder['noready'] = 'Отображать завершенные';
    $button_default['myorder'] = '1';    $button_type['myorder'] = 'permanent'; $button_placeholder['myorder'] = 'Только мои';
    $button_default['delivery'] = '0';    $button_type['delivery'] = 'permanent'; $button_placeholder['delivery'] = 'Доставка';
    $button_default['searchstring'] = '';$button_type['searchstring'] = 'temp'; $button_placeholder['searchstring'] = 'Текст поиска: ';
    $button_default['clientstring'] = '';$button_type['clientstring'] = 'temp'; $button_placeholder['clientstring'] = 'Клиент: ';


    //генератор ссылок, которые отменяют фильтр, который включается по этой ссылке
    foreach($button_type as $key_out => $value_out){
        $this_a_href = '';
        if	(($key_out == 'showlist')) { continue; }

        foreach($_GET as $key => $value){
            if	(($key_out == $key)) { 	if ($button_type[$key] == 'temp') { continue;}
                switch ($value) {
                    case 0: $value = 1; break;
                    case 1: $value = 0; break; }
            }
            $this_a_href = $this_a_href.'&'.$key;
            $this_a_href = $this_a_href.'='.$value;
        }
        $activeflag = '';
        $button_text = '';

        if (($_GET[$key_out]<>'') and ($button_type[$key_out]=='temp')) {
            $activeflag = ' button-active';
            if ($key_out == 'clientstring') {
                /*echo $_GET[$key_out].'asdasdsd';*/
                $attr1 = $_GET[$key_out];
                $butt_sql_data = mysql_fetch_array(mysql_query("SELECT * FROM `contragents` WHERE `id`='$attr1' LIMIT 1"));
                $button_text = "<b>".$butt_sql_data['name']."</b>";
            } else {
                $button_text = "<b>".$_GET[$key_out]."</b>"; }
        }

        //проверка на основные переменные в адресной строке + проверка


        if ((
            ((isset($_GET['showlist']))or(isset($_GET['myorder']))or(isset($_GET['noready'])))
                and
                (!strripos($this_a_href, 'showlist')
                or
                !strripos($this_a_href, 'noready')
                or
                !strripos($this_a_href, 'delivery')
                or
                !strripos($this_a_href, 'myorder'))
            ) or ($_GET['action'] == "showlist")) {
            ?>
            <script>document.location.href = '?&myorder=0&noready=1&showlist=&delivery=1'; </script>
            <?
        }

        if (($_GET[$key_out]<>1) and ($button_type[$key_out]=='permanent')) {$activeflag = ' button-active';}
        echo "<div class='header-block'>";
        echo "<a href=?";echo $this_a_href;
        echo " type=button class='search-button ".$activeflag."'>"; echo $button_placeholder[$key_out].$button_text; echo "</a>";
        echo "</div>";
    }

    if ($_GET['filter'] == 'contragent') {$contragent=' active';$contragent_value = $_GET['argument'];} ?>
</div>
