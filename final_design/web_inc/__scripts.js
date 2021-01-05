
$(document).keyup(function(e) {
	if (e.key === "Escape" || e.keyCode === 27) {
		$("#omnisearch").val('');
		$('.searchResults_showlist').empty();
		$('.searchResults_showlist').html('').hide();

	}
});
/*$(document).on('mouseenter','.read-more',function(e){
	e.preventDefault();
	var id = $(this).data('id') || 0;
	// Вставляем полученный контент в HTML блок с id="content"
	$("#order-content"+id).load("./adddata.php",{action:"getContent", id:id});
	$(this).removeClass('read-more').addClass('read-less');

});*/
window._timeout = {};
window.results = {};

function searchClient(_element, _event)
{
	if (_event.key == 'ArrowDown' || _event.key == 'ArrowUp'|| _event.key == 'Enter'){
		if (_event.key == 'Enter'){
			$('.searchResults_showlist').html('').hide();
			return false;
		}
		selectSearchRow(_event.key == 'ArrowDown');
	} else {
		clearTimeout(window._timeout);
		window._timeout = setTimeout(function(){
			const searchString = $(_element).val();
			$.ajax({
				url:'_workrow_processor.php',
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


function renderResults(_results)
{
	$('.searchResults_showlist').html('');
	var _resultsHtml = '';
	_resultsHtml += '<div class="search-col">';
	$.each(_results, function(_index, _element){
		var _html = '';
		var uri_current =  $(location).attr('search');
		if(_element['name']/* || _element['address']*/){
			$.each(['name'/*, 'address'*/], function(_a, _col){
				/*http://192.168.1.221/?action=showlist&filter=client&argument=396*/
				_html += _html?', ':'<div class="searchRow" onclick="clickSearchRow(' + _index + ')" onmouseover="hoverSearchRow(' + _index + ')">';
				_html += '<a href=' + uri_current + '&clientstring=' + _element['id'] + '>';
				_html += '<span>' + _element[_col] + '</span>';
				_html += '</a>';
			});
		} else {
			_html += '<div class="searchRow" onclick="clickSearchRow(' + _index + ')" onmouseover="hoverSearchRow(' + _index + ')">';
			_html += '<a href=?showlist>';
			_html += '<span>Сброс</span>';
			_html += '</a>';
		}

		_html += '</div>';
		_resultsHtml += _html;
	});
	_resultsHtml += '</div>';
	$('.searchResults_showlist').html(_resultsHtml).show('slow');
}



function selectSearchRow(_next) {
	var _active = $('.searchResults_showlist').find('.active').length ? $('.searchResults_showlist').find('.active').index() : -1;
	var _math = _next ? 1: -1;
	var _index = _active + _math;
	_index = _index < 0 ? $('.searchResults_showlist').find('.searchRow').length-1 : _index;
	_index = _index == $('.searchResults_showlist').find('.searchRow').length ? 0 : _index;
	$('.searchResults_showlist').find('.active').removeClass('active');
	$($('.searchResults_showlist').find('.searchRow')[_index]).addClass('active');
	$.each(window.results[_index], function(_index, _element){
		$('body').find('[data-column="' + _index + '"]').val(_element);
	});
}

/*function hoverSearchRow(_index) {
	$.each(window.results[_index], function(_index, _element){
		$('body').find('[data-column="' + _index + '"]').val(_element);
	});
}*/

/*function hoverSearchRow(_index) {
	$.each(window.results[_index], function(_index, _element){
		$('body').find('[data-column="' + _index + '"]').val(_element);
	});
}*/


/*function clickSearchRow(_index) {
	$.each(window.results[_index], function(_index, _element){
		$('body').find('#omnisearch').val(_element).addClass('read-less');
		$('.searchResults_showlist').html('').hide();
	});
}*/


$(document).on('click','.read-more',function(e){
	e.preventDefault();
	var id = $(this).data('id') || 0;
	var contragent = $(this).data('contragent') || 0;
	// Вставляем полученный контент в HTML блок с id="content"
	$("#order-content"+id).load("final_design/web_inc/ajax2.php",{action:"getContent", id:id,aaa:contragent});
	$(this).removeClass('read-more').addClass('read-less active_details_top_part');
	$('.details_bottom'+id).addClass('active_details_bottom_part');

});

$(document).on('click','.read-less',function(e){
	e.preventDefault();
	var id = $(this).data('id') || 0;
	// Вставляем полученный контент в HTML блок с id="content"
	$("#order-content"+id).empty();
	$(this).removeClass('read-less active_details_top_part').addClass('read-more');
	$('.details_bottom'+id).removeClass('active_details_bottom_part');

});