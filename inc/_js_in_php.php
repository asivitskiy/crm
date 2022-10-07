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

<script>
    function unblock(){
       $(".paydemand_button").removeAttr("disabled");
    }
</script>

<script>
function printblank(ordernumber) {
    $.get('http://192.168.1.221/_printengine.php?order_number=' + ordernumber + '&addtoquery=1');
    $("#printBtn").text("...ок...");
    $("#printBtn").val("...ок...");
    $("#printBtn").css("outline" , "1px solid green");
    $("#printBtn").attr("onclick", "").unbind("click");
}
function setHanding(ordernumber) {
    $.get('http://192.168.1.221/_button_processor.php?order_number=' + ordernumber + '&setHanding');
    $("#setHandingBtn").text("...ок...");
    $("#setHandingBtn").val("...ок...");
    $("#setHandingBtn").css("outline" , "1px solid green");
    $("#setHandingBtn").attr("onclick", "").unbind("click");
}

function errorToManager(orderNumber,orderManager,messFrom) {
    stringtogo = 'http://192.168.1.221/_button_processor.php?order_number=' + orderNumber + '&order_manager=' + orderManager + '&author=' + messFrom + '&errorToManager';
    console.log("string:" + stringtogo);
    $.get(stringtogo);
    $("#errorToManagerBtn").text("...ок...");
    $("#errorToManagerBtn").val("...ок...");
    $("#errorToManagerBtn").css("outline" , "1px solid green");
    $("#errorToManagerBtn").attr("onclick", "").unbind("click");
}

function printCopyCheck(ordernumber) {
    $.get('http://192.168.1.221/_printengine.php?order_number=' + ordernumber + '&addtoquery=2');
    $("#printBtnCopy").text("...ок...");
    $("#printBtnCopy").val("...ок...");
    $("#printBtnCopy").css("outline" , "1px solid green");
    $("#printBtnCopy").attr("onclick", "").unbind("click");
    
}

function openLinkList(linkList) {
  for(var i = 0; i < linkList.length; i++) {
    var a = document.createElement("a");
    a.href = "http://<? echo $_SERVER['SERVER_ADDR'];?>/_pdf_engine/filemaker.php?order_number=" + linkList[i];
    a.target="_blank";
    
    a.click();
  }
}


</script>
