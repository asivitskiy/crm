<script>
        function raskladka(_el){
            var _element = $(_el).parents('.workrow');
            var _counts = $(_element).find('[name="work_shir[]"]').val();
            var _kol = $(_element).find('[name="work_count[]"]').val();
			_counts *=1;
            _kol *=1;
            var _price = $(_element).find('[name="work_vis[]"]').val();
			_price *=1;
            var _col11 = Math.trunc(440/ (_counts + 2));
			var _col12 = Math.trunc(312/ (_price + 2));
			var _col21 = Math.trunc(440/ (_price + 2));
			var _col22 = Math.trunc(312/ (_counts + 2));
			var _cnt1 = _col11*_col12;
			var _cnt2 = _col21*_col22;
			var _col = Math.max(_cnt1,_cnt2);
			if (_cnt1>_cnt2) {_col=_cnt1; var _shirina = _col11; var _visota=_col12;} else {_col=_cnt2; var _shirina = _col21; var _visota=_col22;}
			//$(_element).find('[name="bezlam"]').val((_col));
         	//$(_element).find('[name="shirina"]').val((_shirina));
         	//$(_element).find('[name="visota"]').val((_visota));
         	
			var _lam11 = Math.trunc(415/ (_counts + 3));
			var _lam12 = Math.trunc(300/ (_price + 3));
			var _lam21 = Math.trunc(415/ (_price + 3));
			var _lam22 = Math.trunc(300/ (_counts + 3));
			var _cntlam1 = _lam11*_lam12;
			var _cntlam2 = _lam21*_lam22;
			var _lamcol = Math.max(_cntlam1,_cntlam2);
			if (_cntlam1>_cntlam2) {var _shirinalam = _lam11; var _visotalam=_lam12;} else {var _shirinalam = _lam21; var _visotalam=_lam22;}
			//\n[" + _shirina +"x" +_visota + " / "+_shirinalam+"x"+_visotalam+"]
			    var _textcol333 = "[" + _col + " / " +_lamcol + "]";
            /*Math.max(10, 20);*/
			    var _textcol = "[" + Math.round(_col) + "]налист\n";
			    var _textcol = _textcol  + "[" + Math.round(_kol/_col) + "]лст";
			$(_element).find('[name="work_rasklad[]"]').val((_textcol));
			$(_element).find('[name="work_sheets[]"]').val((_kol/_col));

        }
      
	function matchformat(_el2){
            var _element = $(_el2).parents('.workrow');
            var _formatname = $(_element).find('[name="work_format[]"]').val();
			//var _formatval = _formatname.options[_formatname.selectedIndex].value;
			//let _formats =["А4","А5","А6","А7","90х50","85Х55","евро"];
			//let _widths =["297","210","148","105","90","85","210"];
			//let _heights =["210","148","105","74","50","55","100"];
			var _shirina = "1000";
			var _visota = "1000";
			if (_formatname != "none") {
			if (_formatname == "А3") {var _shirina = "420";var _visota = "297";}
			if (_formatname == "А4") {var _shirina = "297";var _visota = "210";}
			if (_formatname == "А5") {var _shirina = "210";var _visota = "148";}
			if (_formatname == "А6") {var _shirina = "148";var _visota = "105";}
			if (_formatname == "А1") {var _shirina = "841";var _visota = "594";}
			if (_formatname == "А2") {var _shirina = "594";var _visota = "420";}
			$(_element).find('[name="work_shir[]"]').val((_shirina));
			$(_element).find('[name="work_vis[]"]').val((_visota));
			}
        document.getElementById('mainform').submit();

		}
      
	
	</script>	
		<script>
	
		$( document ).ready(function() {
			/*onclick(document.getElementById("delete_button").remove());*/
			
			$('.click').on('click', function(){
			$('.delete_button').remove();
			$(this).before($(".workrow:last").clone());
			$(".workrow:last .autoClear").find('input').val("");
			/*$(".delete_button").find('a').remove();*/
			autocompleteRun();
			
			/*document.getElementById("delete_button").remove();*/
			});		
		
		});
		$( document ).ready(function() {
			$('.click2').on('click', function(){
			$('.workrow:last').remove();
			autocompleteRun();
			});
					
		});
		
		
		
      function checkRow(_el){
           var _element = $(_el).parents('.workrow');
           var _counts = $(_element).find('[name="work_count[]"]').val();
           var _price = $(_element).find('[name="work_price[]"]').val();
		_price = _price.replace(/,/g, '.');
            $(_element).find('[name="result[]"]').val((_counts * _price).toFixed(2));
            var _itog = 0;
            $('.workrow').each(function(){
                _itog += $(this).find('[name="result[]"]').val()*1;
            });
            $('#itog').val(_itog.toFixed(2));
			document.getElementById('txtSecond').innerHTML = _itog.toFixed(2);
        }
			$('[name="item_counts[]"]').each(function(){
            checkRow(this);
        });
window._timeout = {};
window.results = {};
			
function searchClient(_element, _event)
{
	if (_event.key == 'ArrowDown' || _event.key == 'ArrowUp'|| _event.key == 'Enter'){
		if (_event.key == 'Enter'){
			$('.searchResults').html('').hide();
			return false;
		}
		selectSearchRow(_event.key == 'ArrowDown');
	} else {
		clearTimeout(window._timeout);
		window._timeout = setTimeout(function(){
			const searchString = $(_element).val();
			$.ajax({
				url:'/_workrow_processor.php',
				data: {
					search: searchString
				},
				method: 'get'
			}).done(function(request){
				var new_client = {
					id: 'new'
				};
				$('.contragent_block').find('[data-column]').each(function(){
					if($(this).data('column') != 'id'){
						new_client[$(this).data('column')] = '';
					}
				});
				request.unshift(new_client);
				window.results = request;
				renderResults(request);
			})
		} , 50)
	}
}
			
$('.raskladka').each(function(){
	raskladka(this);
});
$('.checkRow').each(function(){
	checkRow(this);
});
			
$('.final').click(function(){
	$('#mainform').append('<input type="hidden" name="final" value="true">').submit();
	return false;
});
function renderResults(_results)
{
	$('.searchResults').html('');
	var _resultsHtml = '';
	$.each(_results, function(_index, _element){
		var _html = '';
		if(_element['name'] || _element['address']){
			$.each(['name', 'address'], function(_a, _col){
				_html += _html?', ':'<div class="searchRow" onclick="clickSearchRow(' + _index + ')" onmouseover="hoverSearchRow(' + _index + ')">';
				_html += '<span>' + _element[_col] + '</span>';
			});
		} else {
			_html += '<div class="searchRow" onclick="clickSearchRow(' + _index + ')" onmouseover="hoverSearchRow(' + _index + ')">';
			_html += '<span>Новый клиент</span>';
		}
		
		_html += '</div>';
		_resultsHtml += _html;
	});
	$('.searchResults').html(_resultsHtml).show('fast');
}
			
function selectSearchRow(_next) {
	var _active = $('.searchResults').find('.active').length ? $('.searchResults').find('.active').index() : -1;
	var _math = _next ? 1: -1;
	var _index = _active + _math;
	_index = _index < 0 ? $('.searchResults').find('.searchRow').length-1 : _index;
	_index = _index == $('.searchResults').find('.searchRow').length ? 0 : _index;
	$('.searchResults').find('.active').removeClass('active');
	$($('.searchResults').find('.searchRow')[_index]).addClass('active');
	$.each(window.results[_index], function(_index, _element){
		$('body').find('[data-column="' + _index + '"]').val(_element);
	});
}
			
function hoverSearchRow(_index) {
	$.each(window.results[_index], function(_index, _element){
		$('body').find('[data-column="' + _index + '"]').val(_element);
	});
}
			
function clickSearchRow(_index) {
	$.each(window.results[_index], function(_index, _element){
		$('body').find('[data-column="' + _index + '"]').val(_element);
		$('.searchResults').html('').hide();
	});
}
</script>
