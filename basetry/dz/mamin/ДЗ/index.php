<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Личный сайт студента GeekBrains</title>
	<link rel="stylesheet" href="style.css"> 
</head>
<body>

<div class="content">
	<?php
		include "menu.php";
	?>

	<h1>Личный сайт студента GeekBrains</h1>

	<div class="center">
	<img src="img/Its me.jpg">
		<div class="box_text">
			<p><b>Добрый день</b>. Меня зовут <i>Алексей Мамин</i>. Я  недавно начал заниматься программированием, до сих пор обучаюсь данной профессии, однако уже написал свой первый сайт.</p>

			<p>В этом мне помог IT-портал <a href="https://geekbrains.ru">GeekBrains</a></p>

			<p>На этом сайте вы сможете сыграть в несколько игр, которые я написал: <br>
			?php
				include "menu.php";
			?>
			</p>
		</div>
	</div>
</div>
<div class="footer">
	Copyright &copy;<?php echo date ("Y");? Aleksey Mamin
<div>


</body>
</html>