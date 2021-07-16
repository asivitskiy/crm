<?  require_once  'dbconnect.php'; 
    session_start(); 

 require_once  './inc/global_functions.php'; 
 require_once  './_oborot_functions.php'; 
 require_once  './inc/cfg.php'; 
 $action = $_GET['action']; 
 $current_manager = $_SESSION['manager']; 
 if (strlen($current_manager) > 0 ) {  
    //обработчик событий добавления редактирования и прочего
    //вот тут процессорный блок (тот что пишет данные в базу и делает переадресацию)
        
        //добавляет реквизиты поставщику(принимает инн и полные реквизиты)
        if (isset($_POST['addreq'])) {
            
                    $addreq_inn = $_POST['outcontragent_inn'];
                    $addreq_req = $_POST['outcontragent_req_full'];
                    $addreq_outcontragent = $_POST['addreq_outcontragent_id'];
            if ($_POST['addreq'] == 'new') { 
                    $sssql = "INSERT INTO `outcontragent_req` (

                    `outcontragent_id` ,
                    `outcontragent_req_inn` ,
                    `outcontragent_req_full`
                    )
                    VALUES (
                        '$addreq_outcontragent', 
                        '$addreq_inn', 
                        '$addreq_req'
                    )";echo $sssql;
            } else {
                $req_id = $_POST['addreq'];
                $sssql = "UPDATE `outcontragent_req` 
                SET     `outcontragent_req_inn` = '$addreq_inn' , 
                        `outcontragent_req_full` = '$addreq_req' 
                WHERE `outcontragent_req_id` ='$req_id'";
            }
                    mysql_query($sssql);
            header('Location: http://'.$_SERVER['SERVER_NAME'].'/index.php?action=paydemands');
        }

        //добавляет нового поставщика
        if (isset($_POST['addOutcontragent'])) {

            $outcontragent_fullname = $_POST['outcontragent_fullname'];
            $outcontragent_alias = $_POST['alias'];
            $outcontragent_blank_visible = $_POST['outcontragent_blank_visible'];
            if (($outcontragent_blank_visible == 'on')or($outcontragent_blank_visible == 1)) {
                $outcontragent_blank_visible = 1;
            }
            if (($outcontragent_blank_visible == 'off')or($outcontragent_blank_visible == 0)) {
                $outcontragent_blank_visible == 0;
            }
            
            $sssql = "INSERT INTO `outcontragent` (
        
                `outcontragent_fullname` ,
                `outcontragent_alias` ,
                `outcontragent_blank_visible`,
                `outcontragent_group`
                )
                VALUES (
                    '$outcontragent_fullname', 
                    '$outcontragent_alias', 
                    '$outcontragent_blank_visible',
                    'outer'
                )";
                mysql_query($sssql);
                header('Location: http://'.$_SERVER['SERVER_NAME'].'/index.php?action=paydemands');
            
            }

            //удаление реквизитов
            if (isset($_GET['req_del'])) {
                $req_del = $_GET['req_del'];
                mysql_query("UPDATE `outcontragent_req` SET `outcontragent_req_deleted` = 1 WHERE `outcontragent_req_id` ='$req_del'");
                header('Location: http://'.$_SERVER['SERVER_NAME'].'/_new_paydemands_red.php?outcontragentList');
            }
            //восстановление реквизитов
            if (isset($_GET['req_restore'])) {
                $req_restore = $_GET['req_restore'];
                mysql_query("UPDATE `outcontragent_req` SET `outcontragent_req_deleted` = NULL WHERE `outcontragent_req_id` ='$req_restore'");
                header('Location: http://'.$_SERVER['SERVER_NAME'].'/_new_paydemands_red.php?outcontragentList');
            }

             //переключение видимости
            if (isset($_GET['setinvisible'])) {
                $idd = $_GET['setinvisible'];
                mysql_query("UPDATE `outcontragent` SET `outcontragent_blank_visible` = 0 WHERE `outcontragent_id` ='$idd'");
                header('Location: http://'.$_SERVER['SERVER_NAME'].'/_new_paydemands_red.php?outcontragentList');
            }
            if (isset($_GET['setvisible'])) {
                $idd = $_GET['setvisible'];
                mysql_query("UPDATE `outcontragent` SET `outcontragent_blank_visible` = 1 WHERE `outcontragent_id` ='$idd'");
                header('Location: http://'.$_SERVER['SERVER_NAME'].'/_new_paydemands_red.php?outcontragentList');
            }



?>
<html>
<head>

<SCRIPT type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></SCRIPT>
<SCRIPT type="text/javascript" src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></SCRIPT>
<link rel="stylesheet" href="jquery-ui.css">
<link rel="stylesheet" href="_workrow.css">
<link rel="stylesheet" type="text/css" href="truestyle.css?<? echo rand();?>" />
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;300;700&display=swap" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="./inc/jquery.timepicker.css" />
<SCRIPT type="text/javascript" src="./inc/jquery.timepicker.js"></SCRIPT>
</head>
<body>
    <a href="index.php?action=paydemands"><div style="margin: 10px; margin-top:10px; width:100px; height:25px; display:inline-block; line-height:25px;text-align:center; border:1px solid gray;"><<Возврат</div></a>
<?
if (isset($_GET['outcontragent_id'])) {
    if ($_GET['red_req'] == 'new') {
            $outcontragent_to_add_req = $_GET['outcontragent_id'];
            $outcontragent_to_add_req_data = mysql_fetch_array(mysql_query("SELECT * FROM `outcontragent` WHERE `outcontragent_id` ='$outcontragent_to_add_req' LIMIT 1"));
            echo "Добавление реквизитов для: ".$outcontragent_to_add_req_data['outcontragent_fullname'];
            echo "<br>";
            ?>
                <form method=post action="_new_paydemands_red.php">
                    <input type="hidden" name="addreq" value="new">
                    <input type="hidden" name="addreq_outcontragent_id" value="<? echo $outcontragent_to_add_req; ?>">
                    Юрлицо (как в карточке)<br><input type=text name=outcontragent_inn><br>
                    Полные реквизиты<br>
                    <textarea name=outcontragent_req_full rows="10" cols="50"></textarea>
                    <br><br>
                    <input type=submit  value="Добавить">
                </form>    

            <?
    } else {
        //редактирование реквизитов конкретных каких то
        $current_req = $_GET['red_req'];
        $outcontragent_to_red_req = $_GET['outcontragent_id'];
        $outcontragent_to_red_req_data = mysql_fetch_array(mysql_query("SELECT * FROM `outcontragent` WHERE `outcontragent_id` ='$outcontragent_to_red_req' LIMIT 1"));
        
        $req_data = mysql_fetch_array(mysql_query("SELECT * FROM `outcontragent_req` WHERE `outcontragent_req_id` ='$current_req' LIMIT 1"));
        
        
        echo "Редактирвоание реквизитов для: ".$outcontragent_to_red_req_data['outcontragent_fullname'];
        echo "<br>";
        ?>
            <form method=post action="_new_paydemands_red.php">
                <input type="hidden" name="addreq" value="<? echo $req_data['outcontragent_req_id']; ?>">
                <input type="hidden" name="addreq_outcontragent_id" value="<? echo $outcontragent_to_red_req; ?>">
                Юрлицо (как в карточке)<br><input type=text name=outcontragent_inn value="<? echo $req_data['outcontragent_req_inn'];?>"><br>
                Полные реквизиты<br>
                <textarea name=outcontragent_req_full rows="10" cols="50"><? echo $req_data['outcontragent_req_full'];?></textarea>
                <br><br>
                <input type=submit  value="обновить данные">
            </form>    
    <?
    }
}




if (isset($_GET['newOutcontragent'])) {
?>
        <form method=post action="_new_paydemands_red.php">
            <input type="hidden" name="addOutcontragent" value="1">
            Название (для выпадающего списка в редакторе бланков)
            <br>
            <input type=text name=outcontragent_fullname><br><br>
       
            Синоним<br>
            <select name="alias">
                <option value="ШФ">Широкоформат</option>
                <option value="ОФСЕТ">Офсет</option>
                <option value="СУВЕНИР">Сувениры</option>
                <option value="РАСХ">Расходка</option>
            </select>
            <br><br>
            <input name="outcontragent_blank_visible" type="checkbox" checked>Виден в редакторе бланков
            <br><br>
            <input type=submit  value="Добавить">
        </form>   

<?
}




    if (isset($_GET['outcontragentList'])) {
        //вывод всего списка и редактирование его
        $outListSql = "SELECT * FROM `outcontragent` WHERE `outcontragent_id`>1 AND `outcontragent_group`='outer'";
        $outListArray = mysql_query($outListSql);
        while($outListData = mysql_fetch_array($outListArray)) {
            
            $cur_outcontragent_id = $outListData['outcontragent_id'];
            echo "<div class=outcontragent_red_wrapper>";
            echo "<div class=outcontragent_red_card_head>";
            echo $outListData['outcontragent_fullname'];
            if ($outListData['outcontragent_blank_visible'] == '1') {
                echo "&nbsp;&nbsp;<a class='addreq_href outcontragent_visible' href=_new_paydemands_red.php?setinvisible=".$cur_outcontragent_id.">ОТОБРАЖАЕТСЯ В БЛАНКЕ</a>"."";  }
            if ($outListData['outcontragent_blank_visible'] <> '1') {
                echo "&nbsp;&nbsp;<a class='addreq_href outcontragent_invisible' href=_new_paydemands_red.php?setvisible=".$cur_outcontragent_id.">НЕ ОТОБРАЖАЕТСЯ В БЛАНКЕ</a>"."";  }
                            
            echo "&nbsp;&nbsp;<a class=addreq_href href=_new_paydemands_red.php?red_req=new&outcontragent_id=".$cur_outcontragent_id.">+реквизиты</a>"."";  
            echo "</div>";
             

            $req_sql = "SELECT * FROM `outcontragent_req` WHERE `outcontragent_id` = '$cur_outcontragent_id'";
            $req_array = mysql_query($req_sql);
            while ($req_data = mysql_fetch_array($req_array)) {
                if ($req_data['outcontragent_req_deleted'] == 1) {
                    $req_del_flag = "outcontragent_red_req_wrapper_deleted";
                }   else {$req_del_flag = "";}
                echo "<div class='outcontragent_red_req_wrapper ".$req_del_flag."'>";
                echo "<div class=outcontragent_red_req_inn>Юрлицо (как в карточке):".$req_data['outcontragent_req_inn']." </div>";
                echo $req_data['outcontragent_req_full']."<br>";
                echo "<a class='req_button req_button_redact' href=_new_paydemands_red.php?outcontragent_id=".$req_data['outcontragent_id']."&red_req=".$req_data['outcontragent_req_id'].">Изменить</a>";
                        
                    if($req_data['outcontragent_req_deleted'] == 1) {
                        echo "<a class='req_button req_button_delete' href=_new_paydemands_red.php?req_restore=".$req_data['outcontragent_req_id'].">Восстановить</a>";
                    } else {
                        echo "<a class='req_button req_button_delete' href=_new_paydemands_red.php?req_del=".$req_data['outcontragent_req_id'].">Удалить</a>";
                    }
                
                echo "</div>";
            }
            echo "</div>";
        }
        
        }
    
    
    
}


?>
</body>