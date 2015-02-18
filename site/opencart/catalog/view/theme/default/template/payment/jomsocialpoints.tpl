<script type="text/javascript">
    function calculate(convert_val,count,user_points,not_enough_pts_message,success_message) {
        var charge_points = convert_val * count;
        var newRow = "";
        var flag = 0;

        if (user_points == 0 || user_points < charge_points){
            newRow = not_enough_pts_message;
        } else if (user_points >= charge_points) {
            flag = 1;
            newRow = success_message;
        }

        if (flag == 1){
			send();
            return true;
        } else {
            document.getElementById('button-confirm').disabled='disabled';
			$('#warning_jomsocial').html('<div class="warning" style="display: none;">' + newRow + '<img src="catalog/view/theme/default/image/close.png" alt="" class="close" /></div>')
			$('.warning').fadeIn('slow');
			return false;
        }
    }

    function send() {
        $.ajax({
            type: 'post',
            data:{ order_id: <?php echo $order_id; ?>, total:<?php echo $total; ?>, user_id:<?php echo $user_id; ?> },
			url: 'index.php?route=payment/jomsocialpoints/confirm',
            success: function() {
						location = '<?php echo $continue; ?>';
					}
		});
    }
</script>
<div id="warning_jomsocial">
<?php if (!empty($error_warning)) { ?>
<div class="warning"><?php echo $error_warning; ?><img src="catalog/view/theme/default/image/close.png" alt="" class="close" /></div>
<?php } ?>
</div>
<form action="#" class="form-validate form-horizontal"  method="post" id="paymentForm" name="paymentForm">
    <div class="center">
        <?php
	if((!empty($conversion)) and (!empty($currency_code))){
		$jomsocialpoints_conversion_rate_message = str_replace('[replace1]',$conversion,$jomsocialpoints_conversion_rate_message);
		$jomsocialpoints_conversion_rate_message = str_replace('[replace2]',$currency_code,$jomsocialpoints_conversion_rate_message);
	}	
		?>
        <?php echo $jomsocialpoints_conversion_rate_message;?>
<br />
        <?php
			$charge_points = $conversion * $total;
			$jomsocialpoints_total_points_needed_message = str_replace('[replace1]',$charge_points,$jomsocialpoints_total_points_needed_message);
			echo $jomsocialpoints_total_points_needed_message;
			?>
<br />
        <?php
		$jomsocialpoints_current_points_situation = str_replace('[replace1]',$user_points,$jomsocialpoints_current_points_situation);
		?>
        <?php echo $jomsocialpoints_current_points_situation;?>

    </div>
    <div class="buttons">
        <div class="right">
            <?php
		$not_enough_pts_message = "'".$jomsocialpoints_not_enough_points_message."'";
		$jomsocialpoints_total_points_deducted_message = str_replace('[replace1]',$charge_points,$jomsocialpoints_total_points_deducted_message);
		$success_message = "'".$jomsocialpoints_total_points_deducted_message."'";
	?>
            <br />
            <input name="submit" class="<?php echo MiwoShop::getButton(); ?>" id="button-confirm" type="button" value="<?php echo $jomsocialpoints_submit;?>" onclick="calculate(<?php echo $conversion;?>,<?php echo $total;?>,<?php echo $user_points;?>,<?php echo $not_enough_pts_message; ?>,<?php echo $success_message; ?>);">
        </div>
    </div>
</form>