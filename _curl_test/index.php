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
<div id="qrSender"></div><br>

<script type="text/javascript">
function whatsappLoader()       { $('#whatsappLoader').load('../_whatsapp.php');console.log('whatsappLoader start at ' + Date());}
function ipCheckerLoader()      { $('#ipCheckerLoader').load('../_mailer_inc_ip_checker.php');console.log('ipCheckerLoader start at ' + Date());}
function demandMailerLoader()   { $('#demandMailer').load('../_mailer_inc_demand_mailer.php');console.log('demandMailer start at ' + Date());}
function paylistLoader()        { $('#paylistLoader').load('../_mailer_inc_paylist_mailer.php');console.log('paylistLoader start at ' + Date());}
function whatsappStatusLoader() { $('#whatsappStatusLoader').load('../_whatsapp_status.php');console.log('whatsappStatusLoader start at ' + Date());}
function dbdumpLoader()         { $('#dbdumpLoader').load('../dbdump.php');console.log('dbdumpLoader start at ' + Date());}
function mailerLoader()         { $('#mailerLoader').load('../_mailer.php');console.log('mailerLoader start at ' + Date());}
function orderCheckerLoader()   { $('#orderCheckerLoader').load('../_mailer_inc_order_checker.php');console.log('orderCheckerLoader start at ' + Date());}
function clientCheckerLoader()  { $('#clientCheckerLoader').load('../_mailer_inc_client_checker.php');console.log('clientCheckerLoader start at ' + Date());}
function digitalCheckerLoader() { $('#digitalCheckerLoader').load('../_mailer_inc_digital_checker.php');console.log('digitalCheckerLoader start at ' + Date());}
//function qrGenerator()          { $('#qrGenerator').load('../_qr_autogenerator.php')}
function printEngine()          { $('#printEngine').load('../_printengine_processor.php');console.log('printEngine start at ' + Date());}
function printerOnlineStatusLoader()    { $('#printerOnlineStatusLoader').load('../_printer_status.php?setonline=1');console.log('printerOnlineStatusLoader start at ' + Date());}
function printerOfflineStatusLoader()   { $('#printerOfflineStatusLoader').load('../_printer_status.php?setoffline=1');console.log('printerOfflineStatusLoader start at ' + Date());}
function qrSender()             { $('#qrSender').load('../sbbol_qr_sender.php');console.log('qrSender start at ' + Date());}


whatsappLoader();               setInterval(whatsappLoader,           2000);
ipCheckerLoader();              setInterval(ipCheckerLoader,        290000);
demandMailerLoader();           setInterval(demandMailerLoader,     290000);
paylistLoader();                setInterval(paylistLoader,          290000);
whatsappStatusLoader();         setInterval(whatsappStatusLoader,    10000);
dbdumpLoader();                 //setInterval(dbdumpLoader,           550000);
orderCheckerLoader();           setInterval(orderCheckerLoader,      29000);
clientCheckerLoader();          setInterval(clientCheckerLoader,     400000);
digitalCheckerLoader();         setInterval(digitalCheckerLoader,    350000);
printerOnlineStatusLoader();    setInterval(printerOnlineStatusLoader,     35000);
printerOfflineStatusLoader();   setInterval(printerOfflineStatusLoader,     5000);
//qrGenerator();                  setInterval(qrGenerator,     1500);
printEngine();                  setInterval(printEngine,     500);
qrSender();                  setInterval(qrSender,     5000);

</script>
</body>
