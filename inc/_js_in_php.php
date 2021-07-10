<script>
function autocompleteRun() {
    var availableTags = [
    <?
    $query_4 = "SELECT `workname` FROM `worknames`";
    $res_4 = mysql_query($query_4);
    while($row_4 = mysql_fetch_array($res_4))
    {?> "<? echo mb_ereg_replace('[\n]', '\n', $row_4['workname']);?>",
    <? } ?> ""];
    $( ".tags2" ).autocomplete({
    source: availableTags
});
    }
    $(document).ready(function(){
    autocompleteRun();
});
</script>

<script>
function disp(form)     {
    if (form.style.display == "none") {
    form.style.display = "";
                        } else {
                            form.style.display = "none";
                        }
    }
</script>

<script type="text/javascript">
    function paydemand_req_list_generator(outerContragentId,el){
        var loaderImg = '<div style="text-align:center"></div>';
        console.log(el);
        var lll = document.getElementsByClassName('pd_contragent_block');
        /* const cards = document.querySelectorAll('.crs-card-big');*/
        for(let i = 0; i < lll.length; i++ ){
            lll[i].classList.remove('paydemand_contragent_list_element_clicked');
            lll[i].classList.add('paydemand_contragent_list_element_not_clicked');
        }
        el.classList.add('paydemand_contragent_list_element_clicked');
        $.ajax({

            url: '_paydemand_defendant.php?outerContragentId=' + outerContragentId + '&req',
            cache: false,
            beforeSend: function() { $('#req_show').html(loaderImg); },
            success: function(res) { $('#req_show').html(res);}
        });
        $("#form_show").html("");
    };
</script>

<script type="text/javascript">
    function paydemand_form_generator(outerContragentId,el){
        console.log(this);
        var loaderImg = '<div style="text-align:center"></div>';
        console.log(el);
        var lll = document.getElementsByClassName('pd_req_block');
        /* const cards = document.querySelectorAll('.crs-card-big');*/
        for(let i = 0; i < lll.length; i++ ){
            lll[i].classList.remove('paydemand_contragent_list_element_clicked');
            lll[i].classList.add('paydemand_contragent_list_element_not_clicked');
        }
        el.classList.add('paydemand_contragent_list_element_clicked');
        $.ajax({

            url: '_paydemand_defendant.php?outerContragentId=' + outerContragentId + '&form',
            cache: false,
            beforeSend: function() { $('#form_show').html(loaderImg); },
            success: function(res) { $('#form_show').html(res);}
        });

    };
</script>
