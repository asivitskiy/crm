

<script> 
//$( 
function autocompleteRun2() { 
var availableTags = [ 
<? 
$query_1 = "SELECT `contragent_shortcut` FROM `contragents`";
$res_1 = mysql_query($query_1);
while($row_1 = mysql_fetch_array($res_1))
{?>	"<? echo mb_ereg_replace('[\n]', '\n', $row_1['contragent_shortcut'])."";?>",
<? } ?>	""]; 
$( ".tags" ).autocomplete({ 
source: availableTags 
}); 
} 
$(document).ready(function(){ 
autocompleteRun2(); 
}); 
</script>






<script> 
//$( 
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