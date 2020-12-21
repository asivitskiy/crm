<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
	<title>Страница</title>

	<SCRIPT type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></SCRIPT>

</head>
<body>
		<div class="calc"  style="display: inline-block; width: 90px;">
           			
            			<input style="width: 80px;" onkeyup="raskladka(this)"  type="text" name="dl[]" placeholder="длина">
            			<input style="width: 80px;" onkeyup="raskladka(this)"  type="text" name="shir[]" placeholder="ширина"><br><br>
            			На лист
            			<input style="width: 80px;" type="text" value="" name="bezlam[]" readonly>
            			Под лам.
            			<input style="width: 80px;" type="text" value="" name="lam[]" readonly>            			
            			
Расклад - ><input style="width: 80px; display: inline-block; width: 35px;" type="text" value="" name="shirina[]" readonly>Х<input style="width: 80px;display: inline-block; width: 35px;" type="text" value="" name="visota[]" readonly>
            		
<script>
        function raskladka(_el){
            var _element = $(_el).parents('.calc');
            var _counts = $(_element).find('[name="shir[]"]').val();
			_counts *=1;
            var _price = $(_element).find('[name="dl[]"]').val();
			_price *=1;
            var _col11 = Math.trunc(440/ (_counts + 3));
			var _col12 = Math.trunc(312/ (_price + 3));
			var _col21 = Math.trunc(440/ (_price + 3));
			var _col22 = Math.trunc(312/ (_counts + 3));
			var _cnt1 = _col11*_col12;
			var _cnt2 = _col21*_col22;
			var _col = Math.max(_cnt1,_cnt2);
			if (_cnt1>_cnt2) {_col=_cnt1; var _shirina = _col11; var _visota=_col12;} else {_col=_cnt2; var _shirina = _col21; var _visota=_col22;}
            $(_element).find('[name="bezlam[]"]').val((_col));
         	$(_element).find('[name="shirina[]"]').val((_shirina));
         	$(_element).find('[name="visota[]"]').val((_visota));
         	
			var _lam11 = Math.trunc(415/ (_counts + 3));
			var _lam12 = Math.trunc(300/ (_price + 3));
			var _lam21 = Math.trunc(415/ (_price + 3));
			var _lam22 = Math.trunc(300/ (_counts + 3));
			var _cntlam1 = _lam11*_lam12;
			var _cntlam2 = _lam21*_lam22;
			var _lamcol = Math.max(_cntlam1,_cntlam2);
			
			var _textcol = _col + " / " +_lamcol;
			$(_element).find('[name="lam[]"]').val((_textcol));
         	
        }
      
	
	</script>		


</div>
</body>
</html>
</body>
</html>
