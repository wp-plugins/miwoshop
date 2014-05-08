<h2><?php echo $text_credit_card; ?></h2>
<div class="content" id="payment">
<table class="form">
    <tr>
      <td><?php echo $entry_cc_type; ?></td>
      <td><select name="cc_type" id="input-cc-type">
          <?php foreach ($cards as $card) { ?>
            <option value="<?php echo $card['code']; ?>"><?php echo $card['text']; ?></option>
          <?php } ?>
        </select></td>
    </tr>

	<tr>
      <td><?php echo $entry_cc_name; ?></td>
      <td> 
	 <input type="text" name="cc_name" value="" placeholder="<?php echo $entry_cc_name; ?>" id="input-cc-name" />
	  </td>
    </tr>
	
	<tr>
      <td><?php echo $entry_cc_number; ?></td>
      <td> 
       <input type="text" name="cc_number" value="" placeholder="<?php echo $entry_cc_number; ?>" id="input-cc-number" />
	  </td>
    </tr>

	<tr>
      <td><?php echo $entry_cc_expire_date; ?></td>
      <td> <select name="cc_expire_date_month" id="input-cc-expire-date" class="form-control">
          <?php foreach ($months as $month) { ?>
          <option value="<?php echo $month['value']; ?>"><?php echo $month['text']; ?></option>
          <?php } ?>
        </select>	
		&nbsp;&nbsp;
		 <select name="cc_expire_date_year" class="form-control">
          <?php foreach ($year_expire as $year) { ?>
            <option value="<?php echo $year['value']; ?>"><?php echo $year['text']; ?></option>
          <?php } ?>
        </select>
		</td>
    </tr>
	
	<tr>
      <td><?php echo $entry_cc_cvv2; ?></td>
      <td> 
       <input type="text" name="cc_cvv2" value="" placeholder="<?php echo $entry_cc_cvv2; ?>" id="input-cc-cvv2" />
	  </td>
    </tr>

	<tr>
      <td><?php echo $entry_cc_issue; ?></td>
      <td> 
       <input type="text" name="cc_issue" value="" placeholder="<?php echo $entry_cc_issue; ?>" id="input-cc-issue" />
       <span><?php echo $help_issue; ?></span>	  
	   </td>
    </tr>
  </table>
</div>
<div class="buttons">
  <div class="right">
    <input type="button" value="<?php echo $button_confirm; ?>" id="button-confirm" class="<?php echo MiwoShop::getButton(); ?>" />
  </div>
</div>
<script type="text/javascript"><!--
$('#button-confirm').bind('click', function() {
  $.ajax({
    url: 'index.php?route=payment/realex_remote/send',
    type: 'post',
    data: $('#payment :input'),
    dataType: 'json',
    beforeSend: function() {
      $('#realex_message_error').remove();
      $('#button-confirm').attr('disabled', true);
      $('#payment').before('<div id="realex_message_wait" class="success"><?php echo $text_wait; ?></div>');
    },
    complete: function() {
      $('#button-confirm').attr('disabled', false);
      $('#realex_message_wait').remove();
    },
    success: function(json) {
      // if 3ds redirect instruction
      if (json['ACSURL']) {
        $('#3dauth').remove();

        html  = '<form action="' + json['ACSURL'] + '" method="post" id="3dauth">';
        html += '  <input type="hidden" name="MD" value="' + json['MD'] + '" />';
        html += '  <input type="hidden" name="PaReq" value="' + json['PaReq'] + '" />';
        html += '  <input type="hidden" name="TermUrl" value="' + json['TermUrl'] + '" />';
        html += '</form>';

        $('#payment').after(html);

        $('#3dauth').submit();
      }

      // if error
      if (json['error']) {
        $('#payment').before('<div id="realex_message_error" class="warning"> '+json['error']+'</div>');
      }

      // if success
      if (json['success']) {
        location = json['success'];
      }
    }
  });
});
//--></script>