<button name="neworder" class="neworderbutton">НОВЫЙ ЗАКАЗ</button>
	    			<script language="javascript" type="text/javascript">
    					$('.neworderbutton').click( function() {
						$.ajax({
          				type: 'POST',
						url: 'blank_zakaz.php?action=neworder',
          				<? // data: '', ?>
          				success: function(data){
            			$('.right-col').html(data);
          				}
        			});
					});
				</script>