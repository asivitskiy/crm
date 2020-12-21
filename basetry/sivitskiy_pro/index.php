<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Первое изменение в файле index.php для проверки работы механизмов GIT</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
<script>
 $( document ).ready(function() {
	 $('.card-header').click(function(){
        
        var hidcont = $(this).next('.card-body');
        
        if (hidcont.hasClass('hidcont')){
         
            
         	
            $(this).next('.card-body').toggle();   
        
        }
    });
 } );

</script>
<style>
	.clientcard p {
		font-size: 14px;
	}
	
	.hidcont { display: none; }
</style>
</head>

<body class="">

<? 
	
	?>

<div class="row p-3 border-dark" style="width: 1500px;">
<div class="col-sm-4">
		<div class="card">
			<div class="card-header text-dark">
				<h4 class="mb-0">Скай ГРУПП (все в одном)</h4>
			</div>
			
		</div>
		
		<div class="card text-white bg-secondary mt-2 clientcard">
		  <div class="card-header text-white font-weight-bold p-2" style="cursor: pointer">
			<h6 class="mb-0">Контакты</h6>
		  </div>
		  <div class="card-body p-2 text-dark bg-white hidcont" style="display: block">
			<blockquote class="blockquote mb-0">
			  <p class=" mb-0">Менеджеры:<br>
					89139139139 (Клава)<br>
					89139139139 (Маша)<br>
					89139139139 (Кеша)</p>
			 <!-- <footer class="blockquote-footer">Someone famous in <cite title="Source Title">Source Title</cite></footer>-->
			</blockquote>
		  </div>
		</div>
		<div class="card text-white bg-secondary mt-2 clientcard">
		  <div class="card-header text-white font-weight-bold p-2" style="cursor: pointer">
			<h6 class="mb-0">Адреса доставки:</h6>
		  </div>
		  <div class="card-body p-2 text-dark bg-white hidcont" style="display: block">
			<blockquote class="blockquote mb-0">
			  <p class=" mb-0">
					Жопа мира 182-22<br>
					Ростов на дону - за сарай<br>
					Еще куданить, где никто не живет 177</p>
			 <!-- <footer class="blockquote-footer">Someone famous in <cite title="Source Title">Source Title</cite></footer>-->
			</blockquote>
		  </div>
		</div>
		
	<!--реквизиты-->
<div class="row clientcard pl-3 pr-3">

	
	<div class="col-sm-12 p-0 mt-2">
		<div class="card">
		  <div class="card-header text-white bg-secondary p-2" style="cursor: pointer" id=div_click>
			<h6 class="mb-0">ООО АН "СКАЙ ГРУП" (НДС)</h6>
		  </div>
		  <div class="card-body p-3 hidcont" id=modal_close>
			<blockquote class="blockquote mb-0">
			  <p class="mb-0">ООО АН "СКАЙ СИТИ" договор 20-127 Адмикс-Скай Сити - на подписании <br>ИНН 5403018017 <br>КПП 540401001 ОГРН 1165476114110 630054, Новосибирская обл, Новосибирск г., Крашенинникова 3-й пер, дом № 3 <br>Новосибирское отделение № 8047 ПАО Сбербанк <br>р/сч 40702810044050018159 <br>БИК 045004641 <br>к/сч 30101810500000000641 Директор Литвинов Владимир Германович</p>
			  <!--<footer class="blockquote-footer">Someone famous in <cite title="Source Title">Source Title</cite></footer>-->
			</blockquote>
		  </div>
		</div>
	
	</div>
	
	<div class="col-sm-12 p-0 mt-2">
		<div class="card">
		  <div class="card-header text-white bg-secondary p-2" style="cursor: pointer">
			<h6 class="mb-0">УК "СКАЙ БЭЙ" (НДС)</h6>
		  </div>
		  <div class="card-body p-3 hidcont">
			<blockquote class="blockquote mb-0">
			  <p class="mb-0">ООО АН "СКАЙ СИТИ" договор 20-127 Адмикс-Скай Сити - на подписании <br>ИНН 5403018017 <br>КПП 540401001 ОГРН 1165476114110 630054, Новосибирская обл, Новосибирск г., Крашенинникова 3-й пер, дом № 3 <br>Новосибирское отделение № 8047 ПАО Сбербанк <br>р/сч 40702810044050018159 <br>БИК 045004641 <br>к/сч 30101810500000000641 Директор Литвинов Владимир Германович</p>
			  <!--<footer class="blockquote-footer">Someone famous in <cite title="Source Title">Source Title</cite></footer>-->
			</blockquote>
		  </div>
		</div>
	
	</div>
	
	<div class="col-sm-12 p-0 mt-2">
		<div class="card">
		  <div class="card-header text-white bg-secondary p-2" style="cursor: pointer">
			<h6 class="mb-0">ГК "СКАЙ СИТИ" (НДС)</h6>
		  </div>
		  <div class="card-body p-3 hidcont">
			<blockquote class="blockquote mb-0">
			  <p class="mb-0">ООО АН "СКАЙ СИТИ" договор 20-127 Адмикс-Скай Сити - на подписании <br>ИНН 5403018017 <br>КПП 540401001 ОГРН 1165476114110 630054, Новосибирская обл, Новосибирск г., Крашенинникова 3-й пер, дом № 3 <br>Новосибирское отделение № 8047 ПАО Сбербанк <br>р/сч 40702810044050018159 <br>БИК 045004641 <br>к/сч 30101810500000000641 Директор Литвинов Владимир Германович</p>
			  <!--<footer class="blockquote-footer">Someone famous in <cite title="Source Title">Source Title</cite></footer>-->
			</blockquote>
		  </div>
		</div>
	
	</div>
	
	
	
</div>
	
</div>
<div class="col-sm-8">	
  	<div class="row p-0">
			<div class="col-sm-3 pr-2 pl-2">
				<div class="card">
					<div class="card-header">
						<h6>Общие обороты:</h6>
					</div>
					<div class="card-body">
						325'014.00 руб.

					</div>
				</div>
			</div>

			<div class="col-sm-3 pr-2 pl-2">
				<div class="card">
					<div class="card-header">
						<h6>Общий долг:</h6>
					</div>
					<div class="card-body">
						133'246.00 руб.

					</div>
				</div>
			</div>
			<div class="col-sm-3 pr-2 pl-2">
				<div class="card">
					<div class="card-header">
						<h6>Общий долг:</h6>
					</div>
					<div class="card-body">
						133'246.00 руб.

					</div>
				</div>
			</div>

			<div class="col-sm-3 pr-2 pl-2">
				<div class="card">
					<div class="card-header">
						<h6>Сновной менеджер:</h6>
					</div>
					<div class="card-body">
						Наташа

					</div>
				</div>
			</div>
	</div>
</div>

</div>



</body>
</html>