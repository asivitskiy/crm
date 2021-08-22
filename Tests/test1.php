<?
//file_get_contents('http://192.168.1.221/_pdf_engine_check/index.php?order_number=9433');
?>
<head>
<SCRIPT type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></SCRIPT>
</head>
<body>
    <input type="button" id="btn" value="otpravka" onclick="printblank(9703)">
    <div id="notify_box" style="border: 1px solid black;"></div>
</body>

<script>
function printblank(ordernumber) {
    $.get('http://192.168.1.221/_printengine.php?order_number=' + ordernumber);
    
    
}
</script>