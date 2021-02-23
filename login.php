<? include 'dbconnect.php'; ?>
<? session_start();

	if (isset($_POST['login'])) {
	$lgn = $_POST['login'];
	$psw = $_POST['password'];
	$auth_q = "SELECT * FROM `users` WHERE ((`login`='$lgn') AND (`password`='$psw'))"; 
		
	$auth_arr = mysql_query($auth_q);
	while($auth_data = mysql_fetch_array($auth_arr)){
	$_SESSION['name'] = $auth_data['a3'];
	$_SESSION['manager'] = $auth_data['word'];
	$_SESSION['type'] = $auth_data['type'];
	$_SESSION['supervisor'] = $auth_data['supervisor'];
	}	
	
	header('Location: index.php?&myorder=0&noready=1&showlist=&delivery=1');
								}

	if ($_GET['quit'] == 1) {session_destroy();header('Location: index.php');}
?>