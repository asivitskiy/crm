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



function disp(form)     {
    if (form.style.display == "none") {
    form.style.display = "";
                        } else {
                            form.style.display = "none";
                        }
    }
