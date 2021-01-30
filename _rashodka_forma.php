<div class="zarplata-table" style="display: flex">
    <div style="width: 300px;">
        <?php
        echo 'hi';

            function rashodka_dropmenu() {
                $sql = "SELECT * FROM `rashod_contragent`";
                $array = mysql_query($sql);
                echo '<select name=contragent>';
                    while ($data = mysql_fetch_array($array)) {
                        echo '<option value='.$data['rashod_contragent_id'].'>';
                        echo $data['rashod_contragent_name'];
                        echo '</option>';
                    }
                echo '</select>';
            }


           function rashodka_list($type) {
                $sql = "SELECT * FROM `rashod_items`
                        LEFT JOIN `rashod_contragent` ON rashod_contragent.rashod_contragent_id = rashod_items.rashod_items_contragent_id
                        ORDER BY `rashod_items_date_in` DESC";
                $array = mysql_query($sql);


                    while ($data = mysql_fetch_array($array)) {
                        echo '<div style="display:block; border-bottom: 1px dotted gray; width: 500px">';
                        echo '<div style="display: inline-block;height:18px; width:80px; font-size: 13px;">';
                        echo dig_to_y($data['rashod_items_date_in']).'/'.dig_to_m($data['rashod_items_date_in']).'/'.dig_to_d($data['rashod_items_date_in']).'  ';
                        echo '</div>';
                        echo '<div style="display: inline-block;height:18px; width:120px; font-size: 13px; font-weight: 500;">';
                        echo $data['rashod_contragent_name'];
                        echo '</div>';
                        echo '<div style="display: inline-block;height:18px;width:70px; font-size: 13px; font-weight: 700; text-align: right; padding-right: 15px;">';
                        echo $data['rashod_items_summ'];
                        echo '</div>';
                        echo '<div style="display: inline-block;height:18px;width:170px; font-size: 13px; font-weight: 300;">';
                        echo '   № платежки > '.$data['rashod_items_demand_name'];
                        echo '</div>';
                        echo '</div>';
                    }


            }

            function rashodka_contragent_summ() {
                $sql = "SELECT * FROM `rashod_contragent`";
                $array = mysql_query($sql);

                    while ($data = mysql_fetch_array($array)) {
                        echo '<div style="display:block; height: 25px; font-size: 12px">';
                        $cont_id = $data['rashod_contragent_id'];
                        echo '<div style="width: 100px; display: inline-block; height: 100%; border: 0px solid gray;">';
                        echo $data['rashod_contragent_name'];
                        echo '</div>';
                            echo '<div style="width: 100px; display: inline-block; height: 100%; border: 0px solid gray;">';
                            $c_data = mysql_fetch_array(mysql_query("SELECT SUM(rashod_items.rashod_items_summ) as smm FROM `rashod_items` WHERE `rashod_items_contragent_id` = '$cont_id'"));
                            if ($c_data['smm'] > 0) {echo $c_data['smm'];} else { echo '0.00';}
                            echo '</div>';
                        echo '</div>';
                    }

            }


        ?>
            <form action="_rashodka_processor.php" method="post">

                <? //вывод меню на экран
                    rashodka_dropmenu(); ?>
                <br><br>
                <input type="date" name="date_in" placeholder="Дата">
                <br><br>
                <input type="text" name="demand_name" placeholder="Номер счета">
                <br><br>
                <input type="text" name="summ" placeholder="Сумма">
                <br><br>
                <input type="submit">



            </form>
            <br><br>
        * расходка ведется 05 / 2020 года<br><br>
        <? rashodka_contragent_summ(); ?>
    </div>

    <div style="width: 800px">
        <? rashodka_list(''); ?>


    </div>

</div>