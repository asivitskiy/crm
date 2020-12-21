<?
$current_manager = 'Ю';
include('web_inc/dbconnect.php');
include 'web_inc/global_functions.php';
?><!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Время экспериментов</title>
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
<link rel="stylesheet" href="web_inc/__css.css">
<script language="javascript" src="web_inc/__scripts.js"></script>
</head>

<body>

    
<nav class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0" style="height: 50px">
  <a class="navbar-brand col-md-1 col-lg-1 mr-0 px-3 mt-1" href="#"><h6>AdmixCRM</h6></a>
  <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-toggle="collapse" data-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <form action="" class="w-50 pl-4" method="get">
  <input class="form-control form-control w-100" style="border-radius: 0px;" type="text" placeholder="Поиск по клиентам" aria-label="Поиск по клиентам" onkeyup="searchClient(this, event);searchClient2(this, event)" autocomplete="off" id="omnisearch" name="searchstring">
  <!--<input type="hidden" name="fulltextfilter">-->
  <input type="hidden" name="showlist">
  <?  foreach($_GET as $key => $value){
					if($key == 'searchstring') { continue; }
					echo "<input type='hidden' name=".$key;
						if ($value<>'') {echo " value=".$value;}
				  	echo ">";} ?>
  </form>
  
   <div class="w-50"></div>
          
  <ul class="navbar-nav px-3">
    <li class="nav-item text-nowrap">
      <a class="nav-link" href="#">Sign out</a>
    </li>
  </ul>
</nav>

 

 <div class="searchResults"></div>

 <div class="container-fluid">
  <div class="row">
   
<!--LEFT MENU-------------------------------------------> 
<div id="sidebarMenu" class="col-1 p-0 mt-3" style="position: fixed; height: 100%;">
<? include("web_inc/_left_menu.php"); ?>
</div>
<!--LEFT MENU-------------------------------------------> 
    
    

    <main role="main" class="col-md-11 ml-sm-auto col-lg-11 px-md-4 mt-0"><div class="chartjs-size-monitor" style="position: absolute; left: 0px; top: 0px; right: 0px; bottom: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;"><div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div></div><div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:200%;height:200%;left:0; top:0"></div></div></div>
	
<!--ПОЛЕ ПОД КОНТЕНТ-->


<? 		if (isset($_GET['showlist'])) {
			include("web_inc/new_main_list_template.php");
		}
?>
<!--ПОЛЕ ПОД КОНТЕНТ-->
   
    </main>
  </div>
</div>
</body>


</body>
</html>