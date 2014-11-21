<form class="form-horizontal">
<h2><?php echo $text_card_details; ?></h2>
<div class="content" id="payment">
<table class="form">
	<tr>
	  <td><?php echo $entry_type; ?></td>
	  <td><select name="type" id="input-type" class="form-control">
	  <?php foreach ($cards as $key => $title) { ?>
		<option value="<?php echo $key ?>"><?php echo $title; ?></option>
	  <?php } ?>
	  </select></td>
	</tr>
	<tr>
	  <td><?php echo $entry_number; ?></td>
	  <td><input type="text" name="number" value="" placeholder="<?php echo $entry_number; ?>" id="input-number" /></td>
	</tr>
	<tr>
	  <td><?php echo $entry_expire_date; ?></td>
	  <td><select name="expire_month" id="expire-date" class="form-control">
      <?php foreach ($months as $month) { ?>
		<option value="<?php echo $month['value']; ?>"><?php echo $month['text']; ?></option>
      <?php } ?>
	  </select> &nbsp;&nbsp;&nbsp;
	  <select name="expire_year" class="form-control">
	  <?php foreach ($year_expire as $year) { ?>
		<option value="<?php echo $year['value']; ?>"><?php echo $year['text']; ?></option>
	  <?php } ?>
	  </select></td>
	</tr>
	<tr>
	  <td><?php echo $entry_cvv2; ?></td>
	  <td><input type="text" name="cvv2" value="" placeholder="<?php echo $entry_cvv2; ?>" id="input-cvv2" /></td>
	</tr>
  </table>
</div>
<div class="buttons">
  <div class="right">
	<input type="submit" value="<?php echo $button_confirm; ?>" id="button-confirm" class="<?php echo MiwoShop::getButton(); ?>" />
  </div>
</div>
</form>
<script type="text/javascript">
$('#button-confirm').bind('click', function() {    
    $.ajax({  
        url: 'index.php?route=payment/securetrading_ws/process',
        type: 'post',
        data: $('#payment :input'),
        dataType: 'json',
    
    beforeSend: function() {
        $('#button-confirm').attr('disabled', true);
        $('form.form-horizontal .alert').remove();
        $('#payment').before('<div class="alert alert-info"><i class="fa fa-info-circle"></i> <?php echo $text_wait; ?></div>');
    },
    
    complete: function() {
        $('#button-confirm').attr('disabled', false);
    },
    success: function(json) {
        $('form.form-horizontal .alert').remove();
        
        if (json['status']) {
            if (json['redirect']) {
                location = json['redirect'];
            } else {
                $('#payment').before('<form id="threed-form" action="' + json['acs_url'] + '" method="POST"><input type="hidden" name="PaReq" value="' + json['pareq'] + '" /><input type="hidden" name="MD" value="' + json['md'] + '" /><input type="hidden" name="TermUrl" value="' + json['term_url'] + '" /></form>');
                $('#threed-form').submit();
            }
        } else {
            $('#payment').before('<div class="alert alert-danger"><i class="fa fa-info-circle"></i> ' + json['message'] + '</div>');
        }
    }
  });
});
</script>