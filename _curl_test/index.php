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
<div id="qrGenerator"></div><br>
<div id="printEngine"></div><br>
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
function whatsappLoader()       { $('#whatsappLoader').load('../_whatsapp.php');}
function ipCheckerLoader()      { $('#ipCheckerLoader').load('../_mailer_inc_ip_checker.php');}
function demandMailerLoader()   { $('#demandMailer').load('../_mailer_inc_demand_mailer.php');}
function paylistLoader()        { $('#paylistLoader').load('../_mailer_inc_paylist_mailer.php');}
function whatsappStatusLoader() { $('#whatsappStatusLoader').load('../_whatsapp_status.php');}
function dbdumpLoader()         { $('#dbdumpLoader').load('../dbdump.php');}
function mailerLoader()         { $('#mailerLoader').load('../_mailer.php');}
function orderCheckerLoader()   { $('#orderCheckerLoader').load('../_mailer_inc_order_checker.php');}
function clientCheckerLoader()  { $('#clientCheckerLoader').load('../_mailer_inc_client_checker.php');}
function digitalCheckerLoader() { $('#digitalCheckerLoader').load('../_mailer_inc_digital_checker.php');}
//function qrGenerator()          { $('#qrGenerator').load('../_qr_autogenerator.php')}
function printEngine()          { $('#printEngine').load('../_printengine_processor.php');}
function printerOnlineStatusLoader()    { $('#printerOnlineStatusLoader').load('../_printer_status.php?setonline=1');}
function printerOfflineStatusLoader()   { $('#printerOfflineStatusLoader').load('../_printer_status.php?setoffline=1');}


whatsappLoader();               setInterval(whatsappLoader,           5000);
ipCheckerLoader();              setInterval(ipCheckerLoader,        290000);
demandMailerLoader();           setInterval(demandMailerLoader,     290000);
paylistLoader();                setInterval(paylistLoader,          290000);
whatsappStatusLoader();         setInterval(whatsappStatusLoader,    10000);
dbdumpLoader();                 //setInterval(dbdumpLoader,           550000);
orderCheckerLoader();           setInterval(orderCheckerLoader,      30000);
clientCheckerLoader();          setInterval(clientCheckerLoader,     30000);
digitalCheckerLoader();         setInterval(digitalCheckerLoader,    15000);
printerOnlineStatusLoader();    setInterval(printerOnlineStatusLoader,     35000);
printerOfflineStatusLoader();   setInterval(printerOfflineStatusLoader,     7000);
//qrGenerator();                  setInterval(qrGenerator,     1500);
printEngine();                  setInterval(printEngine,     1500);

</script>
</body>
