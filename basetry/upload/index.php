<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Документ без названия</title>
<SCRIPT type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></SCRIPT>
<style>
	
	.file-drop {

background:#fff;

margin:auto;

padding:200px 200px;

border:2px solid #333;

}

.file-drop_dragover {

border:2px dashed #333;

}

.file-drop__input {

border:0;

}

.message-div {

background:#fefefe;

border:2px solid #333;

color:#333;

width:350px;

height:150px;

position:fixed;

bottom:25px;

right:25px;

font-size:15px;

padding:5px;

z-index:99999;

box-shadow: 0 0 10px rgba(0,0,0,0.5);

}

.message-div_hidden {

right:-9999999999999999999px;

}
	
	</style>
</head>

<body>


<form method='post' action="upload.php" enctype="multipart/form-data">

<input type="hidden" name="MAX_FILE_SIZE" value="5000000">

<input type='file' name='file[]' class='file-drop' id='file-drop' multiple required><br>

<input type='submit' value='Загрузить' >

</form>

<div class='message-div message-div_hidden' id='message-div'></div>




</body>
</html>