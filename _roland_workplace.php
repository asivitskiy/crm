<?
include "./dbconnect.php";
include "./inc/global_functions.php";
//список заказов на роланд
$main_sql = "SELECT *,works.id as `works_id`,contragents.name as cname FROM `order`
             LEFT JOIN `works` ON works.work_order_number = order.order_number
             LEFT JOIN `contragents` ON contragents.id = order.contragent
             WHERE (((works.work_roland_status = '') or (works.work_roland_status = '0')) and (works.work_tech = 'ROLAND') and (`deleted` <> '1') and (`date_of_end` = '') and ((order.preprint >200000000) or (order.preprint ='Нет')))
";
?>
<head>
    <style>
        a {
            text-decoration: none;
            font-size: 22px;
            color: white;
            background-color: gray;
            padding: 3px;
            border-radius: 3px;
            margin: 5px 5px 5px 5px;
        }
        td {
            outline: 1px solid black;
            padding: 3px;
            font-family: "DejaVu Sans Mono", monospace;
        }
    </style>
</head>
<table>

        <?php
        $main_array = mysql_query($main_sql);
        $prev_order_number = '';
        while ($main_data = mysql_fetch_array($main_array)) {
            //echo $main_data['order_number'];
            $cur_order_number = $main_data['order_number'];
            if ($cur_order_number <> $prev_order_number) {
                echo '<tr><td colspan="9" style="background-color: #ffe8c4"><b><a target="_blank" href=http://192.168.1.221/?action=redact&order_number='.$main_data['order_number'].'>'.$main_data['order_manager'].'-'.$main_data['order_number'].'</a><a target="_blank" class="a_orderrow" style="line-height: 25px; width:70px; margin-left:15px; padding-left:10px;" href = "'.creataPathForApp($main_data['order_number'],$main_data['order_manager']).'">папка</a> - '.$main_data['cname'].'</b>  - '.$main_data['order_description'].' --> ';

                echo '';

                echo '</td></tr>';
                //echo '<tr>
                //<td>Название</td>
                //<td>Высота</td>
                //<td>Ширина</td>
                //<td>Формат</td>
                //<td>Количество</td>
                //<td width="300">Описание</td>
                //<td width="300">Постпечать</td>
                //<td width="40">Готовность</td>
                //</tr>';
            }



            echo '<tr>';
            echo '<td width="200">'.$main_data['work_name'].'</td>';
            echo '<td width="50">'.$main_data['work_media'].'</td>';
            echo '<td width="50">'.$main_data['work_vis'].'</td>';
            echo '<td width="50">'.$main_data['work_shir'].'</td>';
            echo '<td width="50">'.$main_data['work_size'].'</td>';
            echo '<td width="50">'.$main_data['work_count'].' шт. </td>';
            echo '<td width="300">'.$main_data['work_description'].'</td>';
            echo '<td width="300">'.$main_data['work_postprint'].'</td>';
            echo '<td width="40"><a href="_roland_workplace_processor.php?work_id='.$main_data['works_id'].'">ГОТ!</a></td>';
            echo '</tr>';
            $prev_order_number = $cur_order_number;
        }
        ?>

</table>