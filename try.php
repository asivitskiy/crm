<?
include 'dbconnect.php';
/*session_start();*/
$current_manager = $_GET['m'];
include '_oborot_functions.php';
include 'inc/global_functions.php';


echo '<tr>';
    echo '<td>';
        echo 'Долги >>  ';
        echo '</td>';
    echo '<td>';
        echo '</td>';
    for ($i = 01; $i <= 12; $i++) {
    echo '<td>';
        if ($current_manager == 'Марина') {$mngs = 'Ю,Н,А';} else {$mngs = $current_manager;}
        echo '<a target=_blank href=index.php?action=showlist&filter=dolg&mnth='.$i.'&mng='.$mngs.'>';
            echo ''; echo month_name_short($i); echo '>';
            $month_formatted_start =  str_pad($i,2,'0', STR_PAD_LEFT);
            $bb = $i+1;
            $month_formatted_end =  str_pad($bb,2,'0', STR_PAD_LEFT);
            $period_start =  '2020'.$month_formatted_start.'000000';
            $period_end =  '2020'.$month_formatted_end.'000000';

            $obsh_paid_manager[$i] = obsh_paid_manager($period_start,$period_end,$mngs);
            $obsh_oborot_manager[$i] = obsh_oborot_manager($period_start,$period_end,$mngs);
            echo number_format(($obsh_oborot_manager[$i] - $obsh_paid_manager[$i]), 2, '.', ' ');
            echo '</a>';
        echo '</td>';
    }
    echo '</tr>';

    ?>