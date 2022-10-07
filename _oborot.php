<html>
<head>
    <style>

        .oborot-maintable td{
           min-width: 100px;
            text-align: right;
            padding: 5px;
        }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>

    <meta charset="utf-8">
</head>
<body style="padding-left: 10px;">
<?php
require_once './inc/global_functions.php';
include 'inc/dbconnect.php';
include '_oborot_functions.php';
for ($yr=2022; $yr >= 2020; $yr--) {
    $year = $yr.'';
    echo '<table class="oborot-maintable table-bordered">';
    echo '<tr>';
    echo '<td colspan="13" style="text-align: left!important;">'.$year.' - Обороты без учета оплат</td>';
    echo '</tr>';
    echo '<tr>';
    echo '<td>';
    echo 'МЕСЯЦ -> ';
    echo '</td>';

    echo '<td>';
    echo 'январь[01]';
    echo '</td>';

    echo '<td>';
    echo 'февраль[02]';
    echo '</td>';

    echo '<td>';
    echo 'март[03]';
    echo '</td>';

    echo '<td>';
    echo 'апрель[04]';
    echo '</td>';

    echo '<td>';
    echo 'май[05]';
    echo '</td>';

    echo '<td>';
    echo 'июнь[06]';
    echo '</td>';

    echo '<td>';
    echo 'июль[07]';
    echo '</td>';

    echo '<td>';
    echo 'август[08]';
    echo '</td>';

    echo '<td>';
    echo 'сентябрь[09]';
    echo '</td>';

    echo '<td>';
    echo 'октябрь[10]';
    echo '</td>';

    echo '<td>';
    echo 'ноябрь[11]';
    echo '</td>';

    echo '<td>';
    echo 'декабрь[12]';
    echo '</td>';

    echo '</tr>';

    echo '<tr>';

    echo '<td>';
    echo 'Общий оборот';
    echo '</td>';

    for ($i = 01; $i <= 12; $i++) {
        echo '<td>';
        $month_formatted_start = str_pad($i, 2, '0', STR_PAD_LEFT);
        $month_formatted_end = str_pad($i + 1, 2, '0', STR_PAD_LEFT);
        $period_start = $year . $month_formatted_start . '000000';
        $period_end = $year . $month_formatted_end . '000000';
        $obsh_oborot[$i] = obsh_oborot($period_start, $period_end);
        echo '<b>';
        echo number_format($obsh_oborot[$i], 2, '.', ' ');
        echo '</b>';
        echo '</td>';
    }
    echo '</tr>';
    ob_flush();
    echo '<tr>';

    echo '<td>';
    echo 'Общий оборот(пров)';
    echo '</td>';

    for ($i = 01; $i <= 12; $i++) {
        echo '<td>';
        $month_formatted_start = str_pad($i, 2, '0', STR_PAD_LEFT);
        $month_formatted_end = str_pad($i + 1, 2, '0', STR_PAD_LEFT);
        $period_start = $year . $month_formatted_start . '000000';
        $period_end = $year . $month_formatted_end . '000000';
        $obsh_oborot[$i] = obsh_oborot2($period_start, $period_end);
        echo '<b>';
        echo number_format($obsh_oborot[$i], 2, '.', ' ');
        echo '</b>';
        echo '</td>';
    }
    echo '</tr>';
    ob_flush();
    echo '<tr>';

    echo '<td>';
    echo 'Прогноз оборота';
    echo '</td>';

    for ($i = 01; $i <= 12; $i++) {
        echo '<td>';
        $cur_day = dig_to_d(date("YmdHi"));
        $cur_month = dig_to_m(date("YmdHi"));
        $cur_year = dig_to_y(date("YmdHi"));
        $working_days_complete = getWorkingDays($cur_year.$cur_month."01",$cur_year.$cur_month.$cur_day,array());
        $working_days_amount = getWorkingDays($cur_year.$cur_month."01",$cur_year.$cur_month.date('t', time()),array());
        //echo "<Br>".$working_days_amount." всего<br>";
        //средний оборот TODO
        if (($i == $cur_month) and ($yr == $cur_year)) {
            $prognoz = $working_days_amount * $obsh_oborot[$i] / $working_days_complete;
            echo number_format($prognoz, 2, '.', ' ');
        } else echo 'n/a';
        echo '</td>';
    }
    echo '</tr>';
    ob_flush();
    echo '<tr>';

    echo '<td>';
    echo 'Цифра/книги/дизайн';
    echo '</td>';

    for ($i = 01; $i <= 12; $i++) {
        echo '<td>';
        $month_formatted_start = str_pad($i, 2, '0', STR_PAD_LEFT);
        $month_formatted_end = str_pad($i + 1, 2, '0', STR_PAD_LEFT);
        $period_start = $year . $month_formatted_start . '000000';
        $period_end = $year . $month_formatted_end . '000000';
        $obsh_cifra[$i] = obsh_cifra($period_start, $period_end);
        echo number_format($obsh_cifra[$i], 2, '.', ' ');
        echo '</td>';
    }
    echo '</tr>';
    ob_flush();


    echo '<tr>';

    echo '<td>';
    echo 'Роланд';
    echo '</td>';

    for ($i = 01; $i <= 12; $i++) {
        echo '<td>';
        $month_formatted_start = str_pad($i, 2, '0', STR_PAD_LEFT);
        $month_formatted_end = str_pad($i + 1, 2, '0', STR_PAD_LEFT);
        $period_start = $year . $month_formatted_start . '000000';
        $period_end = $year . $month_formatted_end . '000000';
        //echo $period_start."<br>".$period_end;

        $obsh_roland[$i] = obsh_roland($period_start, $period_end);
        echo number_format($obsh_roland[$i], 2, '.', ' ');
        echo '</td>';
    }
    echo '</tr>';
    ob_flush();




    echo '<tr>';

    echo '<td>';
    echo 'Перезаказы';
    echo '</td>';

    for ($i = 01; $i <= 12; $i++) {
        echo '<td>';
        $month_formatted_start = str_pad($i, 2, '0', STR_PAD_LEFT);
        $month_formatted_end = str_pad($i + 1, 2, '0', STR_PAD_LEFT);
        $period_start = $year . $month_formatted_start . '000000';
        $period_end = $year . $month_formatted_end . '000000';
        $obsh_calc_perezakaz[$i] = obsh_perezakaz($period_start, $period_end);
        echo $obsh_calc_perezakaz[$i];
        echo '</td>';
    }
    echo '</tr>';
    ob_flush();
    echo '<tr>';

    echo '<td>';
    echo 'Без изготовителя';
    echo '</td>';

    for ($i = 01; $i <= 12; $i++) {
        echo '<td>';
        $month_formatted_start = str_pad($i, 2, '0', STR_PAD_LEFT);
        $month_formatted_end = str_pad($i + 1, 2, '0', STR_PAD_LEFT);
        $period_start = $year . $month_formatted_start . '000000';
        $period_end = $year . $month_formatted_end . '000000';
        $obsh_mistakes[$i] = obsh_mistakes($period_start, $period_end);
        echo $obsh_mistakes[$i];

        echo '</td>';
    }
    echo '</tr>';
    ob_flush();
    echo '<tr>';

    echo '<td>';
    echo 'Расход на пз';
    echo '</td>';

    for ($i = 01; $i <= 12; $i++) {
        echo '<td>';
        $month_formatted_start = str_pad($i, 2, '0', STR_PAD_LEFT);
        $month_formatted_end = str_pad($i + 1, 2, '0', STR_PAD_LEFT);
        $period_start = $year . $month_formatted_start . '000000';
        $period_end = $year . $month_formatted_end . '000000';
        $obsh_calc_rashod[$i] = obsh_perezakaz_rashod($period_start, $period_end);
        echo $obsh_calc_rashod[$i];
        echo '</td>';
    }
    echo '</tr>';
    ob_flush();
    echo '<tr>';

    echo '<td>';
    echo 'Общая наценка';
    echo '</td>';

    for ($i = 01; $i <= 12; $i++) {
        echo '<td>';
        if ($obsh_calc_rashod[$i] <> 0) {
            $clac_temp1 = 100 * (($obsh_calc_perezakaz[$i] * 1 / $obsh_calc_rashod[$i] * 1) - 1);
            echo number_format($clac_temp1, 2, '.', ' ') . ' %';
        } else echo 'мяу';
        echo '</td>';
    }
    echo '</tr>';

    echo '<tr>';
    echo '<td colspan="13" style="text-align: left!important;">Обороты по готовности и оплатам</td>';
    echo '</tr>';

    echo '<tr>';
    echo '<td>';
    echo 'Завершенные заказы';
    echo '</td>';
    for ($i = 01; $i <= 12; $i++) {
        echo '<td>';
        $month_formatted_start = str_pad($i, 2, '0', STR_PAD_LEFT);
        $month_formatted_end = str_pad($i + 1, 2, '0', STR_PAD_LEFT);
        $period_start = $year . $month_formatted_start . '000000';
        $period_end = $year . $month_formatted_end . '000000';
        $obsh_completed[$i] = obsh_completed($period_start, $period_end);
        echo number_format($obsh_completed[$i], 2, '.', ' ');

        echo '</td>';
    }
    echo '</tr>';
    ob_flush();
    //всего оплачено
    echo '<tr>';
    echo '<td>';
    echo 'Всего оплачено';
    echo '</td>';
    for ($i = 01; $i <= 12; $i++) {
        echo '<td>';
        $month_formatted_start = str_pad($i, 2, '0', STR_PAD_LEFT);
        $month_formatted_end = str_pad($i + 1, 2, '0', STR_PAD_LEFT);
        $period_start = $year . $month_formatted_start . '000000';
        $period_end = $year . $month_formatted_end . '000000';
        $obsh_paid[$i] = obsh_paid($period_start, $period_end);
        echo number_format($obsh_paid[$i], 2, '.', ' ');

        echo '</td>';
    }
    echo '</tr>';
    ob_flush();
    //заказы в работе
    echo '<tr>';
    echo '<td>';
    echo 'В работе (техдолг)';
    echo '</td>';
    for ($i = 01; $i <= 12; $i++) {
        echo '<td>';
        $month_formatted_start = str_pad($i, 2, '0', STR_PAD_LEFT);
        $month_formatted_end = str_pad($i + 1, 2, '0', STR_PAD_LEFT);
        $period_start = $year . $month_formatted_start . '000000';
        $period_end = $year . $month_formatted_end . '000000';
        $obsh_inwork[$i] = obsh_inwork($period_start, $period_end);
        echo number_format($obsh_inwork[$i], 2, '.', ' ');

        echo '</td>';
    }
    echo '</tr>';
    ob_flush();
    echo '<tr>';
    echo '<td>';
    echo 'Закрытие месяца';
    echo '</td>';
    for ($i = 01; $i <= 12; $i++) {
        echo '<td>';
        if ($obsh_oborot[$i] <> 0) {
            $qqq = $obsh_completed[$i] * 1;
            $qqq2 = $obsh_oborot[$i] * 1;
            $clac_temp2 = 100 * $qqq / $qqq2;
            echo number_format($clac_temp2, 2, '.', ' ') . ' %';
        } else echo 'мяу';
        echo '</td>';
    }
    echo '</tr>';
    ob_flush();
    echo '<tr>';
    echo '<td>';
    echo 'Долг в деньгах';
    echo '</td>';
    for ($i = 01; $i <= 12; $i++) {
        echo '<td>';
        if ($obsh_oborot[$i] <> 0) {
            $qqq = $obsh_paid[$i] * 1;
            $qqq2 = $obsh_oborot[$i] * 1;
            $clac_temp3 = $qqq2 - $qqq;
            echo number_format($clac_temp3, 2, '.', ' ');
        } else echo 'мяу';
        echo '</td>';
    }
    echo '</tr>';
    ob_flush();
    echo '<tr>';
    echo '<td>';
    echo 'Долг в деньгах (%)';
    echo '</td>';
    for ($i = 01; $i <= 12; $i++) {
        echo '<td>';
        if ($obsh_oborot[$i] <> 0) {
            $qqq = $obsh_paid[$i] * 1;
            $qqq2 = $obsh_oborot[$i] * 1;
            $clac_temp4 = 100 * (($obsh_oborot[$i] - $obsh_paid[$i]) / $obsh_oborot[$i]);
            echo number_format($clac_temp4, 2, '.', ' ') . ' %';
        } else echo 'мяу';
        echo '</td>';
    }
    echo '</tr>';
    ob_flush();
    echo '<tr>';
    echo '<td colspan="13" style="text-align: left!important;">Долги с разбивкой по менеджерам</td>';
    echo '</tr>';

    echo '<tr>';
    echo '<td>';
    echo 'Долг -> Юля';
    echo '</td>';
    for ($i = 01; $i <= 12; $i++) {
        echo '<td>';
        echo '<a target=blank href=index.php?action=showlist&filter=dolg&mnth=' . $i . '&mng=Ю>';
        $month_formatted_start = str_pad($i, 2, '0', STR_PAD_LEFT);
        $month_formatted_end = str_pad($i + 1, 2, '0', STR_PAD_LEFT);
        $period_start = $year . $month_formatted_start . '000000';
        $period_end = $year . $month_formatted_end . '000000';

        $obsh_paid_manager[$i] = obsh_paid_manager($period_start, $period_end, 'Ю');
        $obsh_oborot_manager[$i] = obsh_oborot_manager($period_start, $period_end, 'Ю');
        echo number_format(($obsh_oborot_manager[$i] - $obsh_paid_manager[$i]), 2, '.', ' ');
        echo '</a>';
        echo '</td>';
    }
    echo '</tr>';
    ob_flush();
    echo '<tr>';
    echo '<td>';
    echo 'Долг -> Натале';
    echo '</td>';
    for ($i = 01; $i <= 12; $i++) {
        echo '<td>';
        echo '<a target=blank href=index.php?action=showlist&filter=dolg&mnth=' . $i . '&mng=Н>';
        $month_formatted_start = str_pad($i, 2, '0', STR_PAD_LEFT);
        $month_formatted_end = str_pad($i + 1, 2, '0', STR_PAD_LEFT);
        $period_start = $year . $month_formatted_start . '000000';
        $period_end = $year . $month_formatted_end . '000000';

        $obsh_paid_manager[$i] = obsh_paid_manager($period_start, $period_end, 'Н');
        $obsh_oborot_manager[$i] = obsh_oborot_manager($period_start, $period_end, 'Н');
        echo number_format(($obsh_oborot_manager[$i] - $obsh_paid_manager[$i]), 2, '.', ' ');
        echo '</a>';
        echo '</td>';
    }
    echo '</tr>';
    ob_flush();
    echo '<tr>';
    echo '<td>';
    echo 'Долг -> Аня';
    echo '</td>';
    for ($i = 01; $i <= 12; $i++) {
        echo '<td>';
        echo '<a target=blank href=index.php?action=showlist&filter=dolg&mnth=' . $i . '&mng=А>';
        $month_formatted_start = str_pad($i, 2, '0', STR_PAD_LEFT);
        $month_formatted_end = str_pad($i + 1, 2, '0', STR_PAD_LEFT);
        $period_start = $year . $month_formatted_start . '000000';
        $period_end = $year . $month_formatted_end . '000000';

        $obsh_paid_manager[$i] = obsh_paid_manager($period_start, $period_end, 'А');
        $obsh_oborot_manager[$i] = obsh_oborot_manager($period_start, $period_end, 'А');
        echo number_format(($obsh_oborot_manager[$i] - $obsh_paid_manager[$i]), 2, '.', ' ');
        echo '</a>';
        echo '</td>';
    }
    echo '</tr>';


    echo '</table>';
} ?>


</body>


