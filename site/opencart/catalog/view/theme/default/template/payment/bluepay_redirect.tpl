<form class="form-horizontal" action="https://secure.bluepay.com/interfaces/bp10emu" method=POST>    
<h2><?php echo $text_credit_card; ?></h2>
<div class="content" id="payment">
<table class="form">
<?php if (!empty($existing_cards)) { ?>
	<tr>
	  <td><?php echo $entry_card; ?></td>
	  <td><input type="radio" name="new-existing" value="existing" checked="checked"/>
						<?php echo $entry_card_existing; ?>
	  </td>
	  <td><input type="radio" name="new-existing" value="existing" checked="checked"/>
						<?php echo $entry_card_existing; ?>
	  </td>
	</tr>
	<tr id="card-existing">
		  <td><?php echo $entry_cc_choice; ?></td>
		  <td colspan="2"><select name="RRNO" class="form-control">
			<?php foreach ($existing_cards as $existing_card) { ?>
				<option value="<?php echo $existing_card['token']; ?>"><?php echo $text_card_type . ' ' . $existing_card['type']; ?>, <?php echo $text_card_digits . ' ' . $existing_card['digits']; ?>, <?php echo $text_card_expiry . ' ' . $existing_card['expiry']; ?></option>   
			<?php } ?>
		</select></td>
	</tr>
	<tr id="card-existingtwo">
		  <td><?php echo $entry_cc_cvv2; ?></td>
		  <td colspan="2">
		  <input type="text" name="CVCCVV2" value="" placeholder="<?php echo $entry_cc_cvv2; ?>" id="input-cc-cvv2" class="form-control" />
		  </td>
	</tr>
	<tr style="display: none" id="card-new"></tr>	
		<?php } else { ?>
	<tr id="card-new"></tr>	
		<?php } ?>   
	<tr>
		  <td><?php echo $entry_cc_number; ?></td>
		  <td colspan="2"><input type="text" name="CC_NUM" value="" placeholder="<?php echo $entry_cc_number; ?>" id="input-cc-number" class="form-control" /></td>
	</tr>
	<tr>
		  <td><?php echo $entry_cc_expire_date; ?></td>
		  <td colspan="2">
			<select name="CC_EXPIRES_MONTH" id="input-cc-expire-date" class="form-control">
			<?php foreach ($months as $month) { ?>
				<option value="<?php echo $month['value']; ?>"><?php echo $month['text']; ?></option>
			<?php } ?>
			</select>
			&nbsp;&nbsp;&nbsp;
			<select name="CC_EXPIRES_YEAR" class="form-control">
			<?php foreach ($year_expire as $year) { ?>
				<option value="<?php echo $year['value']; ?>"><?php echo $year['text']; ?></option>
			<?php } ?>
			</select>
		</td>
	</tr>	
	<tr>
		  <td><?php echo $entry_cc_cvv2; ?></td>
		  <td colspan="2"><input type="text" name="CVCCVV2" value="" placeholder="<?php echo $entry_cc_cvv2; ?>" id="input-cc-cvv2" class="form-control" /></td>
	</tr>	
<?php if ($bluepay_redirect_card) { ?>
	<tr>
		  <td><?php echo $entry_card_save; ?></td>
		  <td colspan="2"><input id="input-cc-save" type="checkbox" name="CreateToken" value="1" /></td>
	</tr>
<?php } ?>
	<tr>
		  <td></td>
		  <td colspan="2"></td>
	</tr>
  </table>
</div>
<div class="buttons">
  <div class="right">
	<input type="button" value="<?php echo $button_confirm; ?>" id="button-confirm" data-loading-text="<?php echo "loading"; ?>" class="<?php echo MiwoShop::getButton(); ?>" />
  </div>
</div>
</form>
<script type="text/javascript"><!--
    $(document).ready(function() {
<?php if (!empty($existing_cards)) { ?>
			$('#card-new input').prop('disabled', true);
			$('#card-new input').prop('disabled', true);
			$('#card-new select').prop('disabled', true);
<?php } ?>
	});
//--></script>
<script type="text/javascript"><!--
	$('input[name=\'new-existing\']').on('change', function() {
		if (this.value === 'existing') {
			$('#card-existing').show();
			$('#card-existingtwo').show();
			$('#card-new').hide();
			$('#card-new input').prop('disabled', true);
			$('#card-new select').prop('disabled', true);
			$('#card-existing select').prop('disabled', false);
			$('#card-existingtwo select').prop('disabled', false);
			$('#input-cc-cvv2').prop('disabled', false);
		} else {
			$('#card-existing').hide();
			$('#card-existingtwo').hide();
			$('#card-new').show();
			$('#card-new input').prop('disabled', false);
			$('#card-new select').prop('disabled', false);
			$('#card-existing select').prop('disabled', true);
			$('#card-existingtwo select').prop('disabled', true);
			$('#card-existing input').prop('disabled', true);
			$('#card-existingtwo input').prop('disabled', true);
		}
	});
//--></script>
<script type="text/javascript">
	$('#button-confirm').bind('click', function() {
		$.ajax({
			url: 'index.php?route=payment/bluepay_redirect/send',
			type: 'post',
			data: $('#card-new :input[type=\'text\']:enabled, #card-new select:enabled, #card-new :input[type=\'checkbox\']:checked:enabled, #payment select:enabled, #card-existing :input:enabled, #card-existingtwo :input:enabled'),
			dataType: 'json',
			cache: false,
			beforeSend: function() {
				$('#button-confirm').button('loading');
			},
			complete: function() {
				$('#button-confirm').button('reset');
			},
			success: function(json) {


				if (json['error']) {
					alert(json['error']);
				}

				if (json['redirect']) {
					location = json['redirect'];
				}
			}
		});
	});
//</script>
