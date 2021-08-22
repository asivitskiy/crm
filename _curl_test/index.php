<head>
<SCRIPT type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></SCRIPT>
</head>
<body>
<?
include_once '../inc/global_functions.php';
echo "Start of script ... ok || time - ".dig_to_d(date('YmdHi'))."/".dig_to_m(date('YmdHi'))." (".dig_to_h(date('YmdHi')).":".dig_to_minute(date('YmdHi')).")";
        
?>
<br>
<br>
<div id="printerOnlineStatusLoader"></div><br>
<div id="printerOfflineStatusLoader"></div><br>
<div id="whatsappLoader"></div><br>
<div id="ipCheckerLoader"></div><br>
<div id="demandMailer"></div><br>
<div id="paylistLoader"></div><br>
<div id="whatsappStatusLoader"></div><br>
<div id="orderCheckerLoader"></div><br>
<div id="clientCheckerLoader"></div><br>
<div id="digitalCheckerLoader"></div><br>
<div id="dbdumpLoader"></div><br>
<div id="mailerLoader"></div><br>

<script type="text/javascript">
function whatsappLoader() {
    $('#whatsappLoader').load('http://192.168.1.221/_whatsapp.php');
    console.log('whatsappLoader started ...');
}

function ipCheckerLoader() {
    $('#ipCheckerLoader').load('http://192.168.1.221/_mailer_inc_ip_checker.php');
    console.log('ipChecker started ...');
}

function demandMailerLoader() {
    $('#demandMailer').load('http://192.168.1.221/_mailer_inc_demand_mailer.php');
    console.log('demandMailer started ...');
}

function paylistLoader() {
    $('#paylistLoader').load('http://192.168.1.221/_mailer_inc_paylist_mailer.php');
    console.log('paylistLoader started ...');
}

function whatsappStatusLoader() {
    $('#whatsappStatusLoader').load('http://192.168.1.221/_whatsapp_status.php');
    console.log('whatsappStatusLoader started ...');
}

function dbdumpLoader() {
    $('#dbdumpLoader').load('http://192.168.1.221/dbdump.php');
    console.log('Dbdump started ...');
}

function mailerLoader() {
    $('#mailerLoader').load('http://192.168.1.221/_mailer.php');
    console.log('mailerLoader started ...');
}

function orderCheckerLoader() {
    $('#orderCheckerLoader').load('http://192.168.1.221/_mailer_inc_order_checker.php');
    console.log('orderCheckerLoader started ...');
}

function clientCheckerLoader() {
    $('#clientCheckerLoader').load('http://192.168.1.221/_mailer_inc_client_checker.php');
    console.log('clientCheckerLoader started ...');
}

function digitalCheckerLoader() {
    $('#digitalCheckerLoader').load('http://192.168.1.221/_mailer_inc_digital_checker.php');
    console.log('digitalCheckerLoader started ...');
}

function printerOnlineStatusLoader() {
    $('#printerOnlineStatusLoader').load('http://192.168.1.221/_printer_status.php?setonline=1');
    console.log('printerOnlineStatusLoader started ...');
}

function printerOfflineStatusLoader() {
    $('#printerOfflineStatusLoader').load('http://192.168.1.221/_printer_status.php?setoffline=1');
    console.log('printerOfflineStatusLoader started ...');
}

    console.log('timer start');
    
    whatsappLoader();
    ipCheckerLoader();
    demandMailerLoader();
    paylistLoader();
    whatsappStatusLoader();
    dbdumpLoader();
    orderCheckerLoader();
    clientCheckerLoader();
    digitalCheckerLoader();
    printerOnlineStatusLoader();
    printerOfflineStatusLoader();

    setInterval(whatsappLoader,          10000);
    setInterval(ipCheckerLoader,        290000);
    setInterval(demandMailerLoader,     290000);
    setInterval(paylistLoader,          290000);
    setInterval(whatsappStatusLoader,    10000);
    setInterval(dbdumpLoader,           550000);
    setInterval(orderCheckerLoader,      30000);
    setInterval(clientCheckerLoader,     30000);
    setInterval(digitalCheckerLoader,    15000);
    setInterval(printerOnlineStatusLoader,     35000);
    setInterval(printerOfflineStatusLoader,     7000);

</script>
</body>
