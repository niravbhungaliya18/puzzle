<!DOCTYPE html>
<html>
<head>
	<title>Puzzle</title>
	<script src="<?php echo e(URL('js/jquery.min.js')); ?>"></script>
	<style type="text/css">
		td{
			width: 250px;
			height: 50px;
		}
		input{
			width: 200px;
		}
	</style>
</head>
<body>
	<form method="POST" action="" align="center" id="form">
		<?php echo e(csrf_field()); ?>

		<table class="table" border="1" align="center">
			<h4>Puzzel</h4>
			<span id="form_output_error"></span>
			<tr>
				<td>
					Number of Player 1
				</td>
				<td>
					<input type="number" name="player1" id="player1" placeholder="Input Number of Player 1" required="">
				</td>
			</tr>
			<tr>
				<td>
					Number of Player 2
				</td>
				<td>
					<input type="number" name="player2" id="player2" placeholder="Input Number of Player 2" required="">
				</td>
			</tr>
			<tr>
				<td>
					Number of Coins
				</td>
				<td>
					<input type="number" name="coins" id="coins" placeholder="Total number of coins" required="">
				</td>
			</tr>
			<tr>
				<td>
					Please enter the value of coins saperated by ',' in proper sequence. Sequence matters.
				</td>
				<td>
					<input type="text" name="coin_values" id="coin_values" placeholder="Value of coins" required="">
				</td>
			</tr>
			<tr>
				<td colspan="2"><input type="submit" name="submit"></td>
			</tr>
			<tr id="success_tr">
				<td id="form_output_succes" colspan="2">
				</td>
			</tr>
		</table>
	</form>
</body>
<script type="text/javascript">
	$('#success_tr').hide();
	$('#form').on('submit', function(event){
        event.preventDefault();
        //var form_data = $(this).serialize();
        $.ajax({
            url:"<?php echo e(route('puzzle.postdata')); ?>",
            method:"POST",
            data:new FormData(this),      
            dataType:"json",
            contentType: false,
            cache: false,
            processData: false,
            success:function(data)
            {
                if(data.error.length > 0)
                {
                    var error_html = '';
                    for(var count = 0; count < data.error.length; count++)
                    {
                        error_html += '<div class="alert alert-danger">'+data.error[count]+'</div>';
                    }
                    $('#form_output').html(error_html);
                }
                else
                {
                	$('#success_tr').show();
                    $('#form_output_succes').html(data.success);
                }
            }
        })
    });
</script>
</html><?php /**PATH /Applications/MAMP/htdocs/Puzzle/resources/views/puzzle.blade.php ENDPATH**/ ?>