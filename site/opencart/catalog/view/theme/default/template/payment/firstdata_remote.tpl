<form class="form-horizontal" id="payment_form">
<h2><?php echo $text_credit_card; ?></h2>
<div class="content" id="payment">
<table class="form">
<?php if (!empty($accepted_cards)) { ?>
	<tr>
	  <td><?php echo $text_card_accepted; ?></td>
	  <td colspan="2"><ul>
	  <?php if ($accepted_cards['mastercard'] == 1) { ?><li><?php echo $text_card_type_m; ?></li><?php } ?>
	  <?php if ($accepted_cards['visa'] == 1) { ?><li><?php echo $text_card_type_v; ?></li><?php } ?>
	  <?php if ($accepted_cards['diners'] == 1) { ?><li><?php echo $text_card_type_c; ?></li><?php } ?>
	  <?php if ($accepted_cards['amex'] == 1) { ?><li><?php echo $text_card_type_a; ?></li><?php } ?>
	  <?php if ($accepted_cards['maestro'] == 1) { ?><li><?php echo $text_card_type_ma; ?></li><?php } ?>
	  </ul></td>
	</tr>
<?php } ?>
<?php if ($card_storage == 1 && count($stored_cards) > 0) { ?>
<?php $i = 0; ?>
 <?php foreach ($stored_cards as $card) { ?>
	<tr>
	  <td><?php if(empty($i)){ echo $text_card_accepted;} ?></td>
	  <td> <p><input type="radio" name="cc_choice" value="<?php echo $card['token']; ?>" class="stored_card" <?php echo $i == 0 ? 'checked="checked"' : ''; ?>/> <?php echo $card['card_type'] . ' xxxx ' . $card['digits'] . ', ' . $entry_cc_expire_date . ' ' . $card['expire_month'] . '/' . $card['expire_year']; ?></p></td>
	</tr>
<?php $i++; ?>
 <?php } ?>	
	<tr>
	  <td></td>
	  <td><p><input type="radio" name="cc_choice" value="new" class="stored_card" />New card</p></td>
	</tr>
<?php } ?>
	<tr id="card_info1">
	  <td><?php echo $entry_cc_name; ?></td>
	  <td><input type="text" name="cc_name" value="" placeholder="<?php echo $entry_cc_name; ?>" id="input-cc-name" class="form-control"/></td>
	</tr>
	<tr id="card_info2">
	  <td><?php echo $entry_cc_number; ?></td>
	  <td><input type="text" name="cc_number" value="" placeholder="<?php echo $entry_cc_number; ?>" id="input-cc-number" class="form-control"/></td>
	</tr>
	<tr id="card_info3">
	  <td><?php echo $entry_cc_expire_date; ?></td>
	  <td><select name="cc_expire_date_month" id="input-cc-expire-date" class="form-control">
      <?php foreach ($months as $month) { ?>
      <option value="<?php echo $month['value']; ?>"><?php echo $month['text']; ?></option>
	  <?php } ?>
	  </select> &nbsp;&nbsp;&nbsp;
	  <select name="cc_expire_date_year" class="form-control">
	  <?php foreach ($year_expire as $year) { ?>
	  <option value="<?php echo $year['value']; ?>"><?php echo $year['text']; ?></option>
	  <?php } ?>
	  </select></td>
	</tr>
<?php if ($card_storage == 1) { ?>	
	<tr id="card_info4">
	  <td>Store card details?</td>
	  <td><input type="hidden" name="cc_store" value="0"/> <input type="checkbox" name="cc_store" value="1" checked/></td>
	</tr>
<?php } ?>
	<tr>
	  <td><?php echo $entry_cc_cvv2; ?></td>
	  <td><input type="text" name="cc_cvv2" value="" placeholder="<?php echo $entry_cc_cvv2; ?>" id="input-cc-cvv2" class="form-control"/></td>
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
$('#button-confirm').bind('click', function () {
  $.ajax({
    url: 'index.php?route=payment/firstdata_remote/send',
    type: 'post',
    data: $('#payment_form').serialize(),
    dataType: 'json',
    beforeSend: function () {
      $('#firstdata_message_error').remove();
      $('#button-confirm').attr('disabled', true);
      $('#payment').before('<div id="firstdata_message_wait" class="alert alert-info"><i class="fa fa-info-circle"></i> <?php echo $text_wait; ?></div>');
    },
    complete: function () {
      $('#button-confirm').attr('disabled', false);
      $('#firstdata_message_wait').remove();
    },
    success: function (json) {
      // if error
      if (json['error']) {
        $('#payment').before('<div id="firstdata_message_error" class="alert alert-warning"><i class="fa fa-info-circle"></i> ' + json['error'] + '</div>');
      }

      // if success
      if (json['success']) {
        location = json['success'];
      }
    }
  });
});

$('.stored_card').bind('change', function () {
  if ($(this).val() == 'new') {
    $('#card_info1').slideDown();
    $('#card_info2').slideDown();
    $('#card_info3').slideDown();
    $('#card_info4').slideDown();
  } else {
    $('#card_info1').slideUp();
    $('#card_info2').slideUp();
    $('#card_info3').slideUp();
    $('#card_info4').slideUp();
  }
});

$(document).ready(function(){
  <?php if ($card_storage == 0) { ?>
    $('#card_info1').show();
    $('#card_info2').show();
    $('#card_info3').show();
    $('#card_info4').show();
  <?php } else { ?>
    var stored_cards = <?php echo count($stored_cards); ?>;
    if (stored_cards == 0) {
      $('#card_info1').show();
      $('#card_info2').show();
      $('#card_info3').show();
      $('#card_info4').show();
    }
  <?php } ?>
});
//--></script>