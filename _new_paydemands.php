<br>
<h2>Регистрация счета расхода от поставщика:</h2>
<br>
<a href="./_new_paydemands_red.php?outcontragentList">Редактирование списка</a>
<br>
<a href="./_new_paydemands_red.php?newOutcontragent">Добавить поставщика</a>
<br>

<br>


<div class="paydemand_col_wrapper">
    <!--левый столбец-->
<?php
$work_types_list_sql = "SELECT * FROM `outcontragent` WHERE outcontragent.outcontragent_group = 'outer' ORDER BY `outcontragent_id` ASC";
$work_types_list_array = mysql_query($work_types_list_sql);
while ($work_types_list_data = mysql_fetch_array($work_types_list_array)) {
    ?>

    <div class="paydemand_contragent_list_element paydemand_contragent_list_element_not_clicked pd_contragent_block"
         onclick="paydemand_req_list_generator('<? echo $work_types_list_data['outcontragent_id'];?>',this)">
         <? echo $work_types_list_data['outcontragent_fullname'];?>
    </div>
    <?
}?> 
    <br><br>
     <a href=_new_paydemands_red.php?newOutcontragent>
        <div class="paydemand_contragent_list_element paydemand_contragent_list_element_not_clicked pd_req_block">
            Добавить нового поставщика
        </div> 
    </a>

</div>

<div class="paydemand_col_wrapper" id = "req_show">
    <!--средний столбец-->
</div>

<div class="paydemand_col_wrapper" id = "form_show">
    <!--правый столбец с формой ввода данных счета расхода-->
</div>



<div style="float: left; width: 400px; margin-left: 15px;" id="showme"></div>
