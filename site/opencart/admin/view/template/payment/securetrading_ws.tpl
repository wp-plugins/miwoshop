<?php echo $header; ?>
<div id="content">
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
    <?php if ($error_warning) { ?>
  <div class="warning"><?php echo $error_warning; ?></div>
  <?php } ?>
  <div class="box">
    <div class="heading">
      <h1><img src="view/image/payment.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons"><a onclick="$('#form').submit();" class="button"><?php echo $button_save; ?></a><a href="<?php echo $cancel; ?>" class="button"><?php echo $button_cancel; ?></a></div>
    </div>
    <div class="content">
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
		<table class="form">
		  <tr>
            <td><span class="required">*</span> <?php echo $entry_site_reference; ?></td>
			<td><input type="text" name="securetrading_ws_site_reference" value="<?php echo $securetrading_ws_site_reference; ?>" placeholder="<?php echo $entry_site_reference; ?>" id="securetrading_ws_site_reference" class="form-control" />
			<?php if ($error_site_reference) { ?>
			<div class="error"><?php echo $error_site_reference; ?></div>
			<?php } ?></td>
          </tr>
		  <tr>
            <td><span class="required">*</span> <?php echo $entry_username; ?></td>
			<td><input type="text" name="securetrading_ws_username" value="<?php echo $securetrading_ws_username; ?>" placeholder="<?php echo $entry_username; ?>" id="securetrading_ws_username" class="form-control" />
			<?php if ($error_username) { ?>
			<div class="error"><?php echo $error_username; ?></div>
			<?php } ?></td>
          </tr>
		  <tr>
            <td><span class="required">*</span> <?php echo $entry_password; ?></td>
			<td><input type="text" name="securetrading_ws_password" value="<?php echo $securetrading_ws_password; ?>" placeholder="<?php echo $entry_password; ?>" id="securetrading_ws_password" class="form-control" />
			<?php if ($error_password) { ?>
			<div class="error"><?php echo $error_password; ?></div>
			<?php } ?></td>
          </tr>
		  <tr>
            <td><?php echo $entry_csv_username; ?></td>
			<td><input type="text" name="securetrading_ws_csv_username" value="<?php echo $securetrading_ws_csv_username; ?>" placeholder="<?php echo $entry_csv_username; ?>" id="securetrading_ws_csv_username" class="form-control" />
			<span class="help"><?php echo $help_csv_username; ?></span></td>
          </tr>
		  <tr>
            <td><?php echo $entry_csv_password; ?></td>
			<td><input type="text" name="securetrading_ws_csv_password" value="<?php echo $securetrading_ws_csv_password; ?>" placeholder="<?php echo $entry_csv_password; ?>" id="securetrading_ws_csv_password" class="form-control" />
			<span class="help"><?php echo $help_csv_password; ?></span></td>
          </tr>
		  <tr>
            <td><span class="required">*</span> <?php echo $entry_cards_accepted; ?></td>
			<td><?php foreach ($cards as $key => $value) { ?>
			<div class="checkbox">
				<label>
					<?php if (in_array($key, $securetrading_ws_cards_accepted)) { ?>
						<input type="checkbox" checked="checked" name="securetrading_ws_cards_accepted[]" value="<?php echo $key ?>" />
					<?php } else { ?>
						<input type="checkbox" name="securetrading_ws_cards_accepted[]" value="<?php echo $key ?>" />
					<?php } ?>
					<?php echo $value ?>
				</label>
			</div>
			<?php } ?>
			<?php if ($error_cards_accepted) { ?>
				<div class="error"><?php echo $error_cards_accepted; ?></div>
			<?php } ?></td>
          </tr>
		  <tr>
            <td><?php echo $entry_settle_status; ?></td>
			<td><select name="securetrading_ws_settle_status" id="securetrading_ws_settle_status" class="form-control">
			<?php foreach ($settlement_statuses as $key => $value) { ?>
				<?php if ($key == $securetrading_ws_settle_status) { ?>
					<option value="<?php echo $key; ?>" selected="selected"><?php echo $value; ?></option>
				<?php } else { ?>
					<option value="<?php echo $key; ?>"><?php echo $value; ?></option>
				<?php } ?>
			<?php } ?>
			</select></td>
          </tr>
		  <tr>
            <td><?php echo $entry_settle_due_date; ?></td>
			<td><select name="securetrading_ws_settle_due_date" id="securetrading_ws_settle_due_date" class="form-control">
			<?php if ($securetrading_ws_settle_due_date == 0) { ?>
				<option value="0" selected="selected"><?php echo $text_process_immediately; ?></option>
			<?php } else { ?>
				<option value="0"><?php echo $text_process_immediately; ?></option>
			<?php } ?>
			<?php for ($i = 1; $i < 8; $i++) { ?>
				<?php if ($i == $securetrading_ws_settle_due_date) { ?>
					<option value="<?php echo $i ?>" selected="selected"><?php echo sprintf($text_wait_x_days, $i) ?></option>
				<?php } else { ?>
					<option value="<?php echo $i ?>"><?php echo sprintf($text_wait_x_days, $i) ?></option>
				<?php } ?>
			<?php } ?>
			</select></td>
          </tr>
		  <tr>
            <td><?php echo $entry_total; ?></td>
			<td><input type="text" name="securetrading_ws_total" value="<?php echo $securetrading_ws_total; ?>" placeholder="<?php echo $entry_total; ?>" id="securetrading_ws_total" class="form-control" />
			<span class="help"><?php echo $help_total; ?></span></td>
          </tr>
		  <tr>
            <td><?php echo $entry_order_status; ?></td>
			<td><select name="securetrading_ws_order_status_id" id="securetrading_ws_order_status_id" class="form-control">
			<?php foreach ($order_statuses as $order_status) { ?>
				<?php if ($order_status['order_status_id'] == $securetrading_ws_order_status_id) { ?>
					<option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
				<?php } else { ?>
					<option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
				<?php } ?>
			<?php } ?>
			</select></td>
          </tr>
		  <tr>
            <td><?php echo $entry_failed_order_status; ?></td>
			<td><select name="securetrading_ws_failed_order_status_id" id="securetrading_ws_failed_order_status_id" class="form-control">
			<?php foreach ($order_statuses as $order_status) { ?>
				<?php if ($order_status['order_status_id'] == $securetrading_ws_failed_order_status_id) { ?>
					<option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
				<?php } else { ?>
					<option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
				<?php } ?>
			<?php } ?>
			</select></td>
          </tr>
		  <tr>
            <td><?php echo $entry_declined_order_status; ?></td>
			<td><select name="securetrading_ws_declined_order_status_id" id="securetrading_ws_declined_order_status_id" class="form-control">
			<?php foreach ($order_statuses as $order_status) { ?>
				<?php if ($order_status['order_status_id'] == $securetrading_ws_declined_order_status_id) { ?>
					<option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
				<?php } else { ?>
					<option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
				<?php } ?>
			<?php } ?>
			</select></td>
          </tr>
		  <tr>
            <td><?php echo $entry_refunded_order_status; ?></td>
			<td><select name="securetrading_ws_refunded_order_status_id" id="securetrading_ws_refunded_order_status_id" class="form-control">
			<?php foreach ($order_statuses as $order_status) { ?>
				<?php if ($order_status['order_status_id'] == $securetrading_ws_refunded_order_status_id) { ?>
					<option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
				<?php } else { ?>
					<option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
				<?php } ?>
			<?php } ?>
			</select></td>
          </tr>
		  <tr>
            <td><?php echo $entry_authorisation_reversed_order_status; ?></td>
			<td><select name="securetrading_ws_authorisation_reversed_order_status_id" id="securetrading_ws_authorisation_reversed_order_status_id" class="form-control">
			<?php foreach ($order_statuses as $order_status) { ?>
				<?php if ($order_status['order_status_id'] == $securetrading_ws_authorisation_reversed_order_status_id) { ?>
					<option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
				<?php } else { ?>
					<option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
				<?php } ?>
			<?php } ?>
			</select></td>
          </tr>
		  <tr>
            <td><?php echo $entry_geo_zone; ?></td>
			<td><select name="securetrading_ws_geo_zone_id" id="securetrading_ws_geo_zone_id" class="form-control">
			<?php if ($securetrading_ws_geo_zone_id == 0) { ?>
				<option value="0" selected="selected"><?php echo $text_all_geo_zones; ?></option>
			<?php } else { ?>
				<option value="0"><?php echo $text_all_geo_zones; ?></option>
			<?php } ?>
			<?php foreach ($geo_zones as $geo_zone) { ?>
				<?php if ($securetrading_ws_geo_zone_id == $geo_zone['geo_zone_id']) { ?>
					<option value="<?php echo $geo_zone['geo_zone_id']; ?>" selected="selected"><?php echo $geo_zone['name']; ?></option>
				<?php } else { ?>
					<option value="<?php echo $geo_zone['geo_zone_id']; ?>"><?php echo $geo_zone['name']; ?></option>
				<?php } ?>
			<?php } ?>
			</select></td>
          </tr>
		  <tr>
            <td><?php echo $entry_status; ?></td>
			<td><select name="securetrading_ws_status" id="securetrading_ws_status" class="form-control">
			<?php if ($securetrading_ws_status == 1) { ?>
				<option value="1" selected="selected"><?php echo $text_enabled; ?></option>
			<?php } else { ?>
				<option value="1"><?php echo $text_enabled; ?></option>
			<?php } ?>
			<?php if ($securetrading_ws_status == 0) { ?>
				<option value="0" selected="selected"><?php echo $text_disabled; ?></option>
			<?php } else { ?>
				<option value="0"><?php echo $text_disabled; ?></option>
			<?php } ?>
			</select></td>
          </tr>
		  <tr>
            <td><?php echo $entry_sort_order; ?></td>
			<td><input type="text" name="securetrading_ws_sort_order" value="<?php echo $securetrading_ws_sort_order; ?>" placeholder="<?php echo $entry_sort_order; ?>" id="securetrading_ws_sort_order" class="form-control" /></td>
          </tr>
        </table>
      </form>
	</div>
<?php if ($myst_status) { ?>
<div class="content" id="tab-myst">
   <div class="well">
      <form id="transaction-form">
		<table class="form">
		  <tr>
            <td><?php echo $entry_hour; ?></td>
			<td><select name="hour_from" id="hour-from" class="form-control">
			<?php foreach ($hours as $hour) { ?>
				<option value="<?php echo $hour ?>"><?php echo $hour ?></option>
			<?php } ?>
			</select></td>
          </tr>
		  <tr>
            <td><?php echo $entry_minute; ?></td>
			<td><select name="minute_from" id="minute-from" class="form-control">
			<?php foreach ($minutes as $minute) { ?>
				<option value="<?php echo $minute ?>"><?php echo $minute ?></option>
			<?php } ?>
			</select></td>
          </tr>
		  <tr>
            <td><?php echo $entry_date_from; ?></td>
			<td><input type="text" class="datetime" name="date_from" value="<?php echo date('Y-m-d'); ?>" placeholder="<?php echo $entry_date_from; ?>" data-format="YYYY-MM-DD" id="date-from" class="form-control" /></td>
          </tr>
		  <tr>
            <td><?php echo $entry_hour; ?></td>
			<td><select name="hour_to" id="hour-to" class="form-control">
			<?php foreach ($hours as $hour) { ?>
				<option value="<?php echo $hour ?>"><?php echo $hour ?></option>
			<?php } ?>
			</select></td>
          </tr>
		  <tr>
            <td><?php echo $entry_minute; ?></td>
			<td><select name="minute_to" id="minute-to" class="form-control">
			<?php foreach ($minutes as $minute) { ?>
				<option value="<?php echo $minute ?>"><?php echo $minute ?></option>
			<?php } ?>
			</select></td>
          </tr>
		  <tr>
            <td><?php echo $entry_date_to; ?></td>
			<td><input type="text" class="datetime" name="date_to" value="<?php echo date('Y-m-d'); ?>" placeholder="<?php echo $entry_date_to; ?>" data-format="YYYY-MM-DD" id="date-to" class="form-control" /></td>
          </tr>
		  <tr>
            <td><?php echo $entry_request; ?></td>
			<td><select style="height: 150px" name="request[]" id="request" multiple class="form-control" >
			<option selected="selected">ACCOUNTCHECK</option>
			<option selected="selected">AUTH</option>
			<option selected="selected">FRAUDSCORE</option>
			<option selected="selected">ORDER</option>
			<option selected="selected">ORDERDETAILS</option>
			<option selected="selected">REFUND</option>
			<option selected="selected">THREEDQUERY</option>
			</select></td>
          </tr>
		  <tr>
            <td><?php echo $entry_currency; ?></td>
			<td><select style="height: 150px" name="currency[]" id="currency" multiple class="form-control">
			<?php foreach ($currencies as $currency) { ?>
			<option selected="selected" value="<?php echo $currency['code'] ?>"><?php echo $currency['title'] ?></option>
			<?php } ?>
			</select></td>
          </tr>
		  <tr>
            <td><?php echo $entry_payment_type; ?></td>
			<td><select style="height: 150px" name="payment_type[]" id="payment-type" multiple class="form-control" >
			<option selected="selected">AMEX</option>
			<option selected="selected">DELTA</option>
			<option selected="selected">ELECTRON</option>
			<option selected="selected">MAESTRO</option>
			<option selected="selected">MASTERCARD</option>
			<option selected="selected">MASTERCARDDEBIT</option>
			<option selected="selected">PAYPAL</option>
			<option selected="selected">PURCHASING</option>
			<option selected="selected">VISA</option>
			<option selected="selected">VPAY</option>
			</select></td>
          </tr>
		  <tr>
            <td><?php echo $entry_status_code; ?></td>
			<td><select style="height: 150px" name="status[]" id="status" multiple class="form-control">
			<option selected="selected" value="0">0 - Ok</option>
			<option selected="selected" value="70000">70000 - Decline</option>
			</select></td>
          </tr>
		  <tr>
            <td><?php echo $entry_settle_status; ?></td>
			<td><select style="height: 150px" name="settle_status[]" id="settle-status" multiple class="form-control" >
			<option selected="selected" value="0">0 - <?php echo $text_pending_settlement ?></option>
			<option selected="selected" value="1">1 - <?php echo $text_manual_settlement ?></option>
			<option selected="selected" value="2">2 - <?php echo $text_suspended ?></option>
			<option selected="selected" value="3">3 - <?php echo $text_cancelled ?></option>
			<option selected="selected" value="10">10 - <?php echo $text_settling ?></option>
			<option selected="selected" value="100">100 - <?php echo $text_settled ?></option>
			</select></td>
          </tr>
		  <tr>
            <td><a class="button button-primary" onclick="showTransactions()"><?php echo $button_show ?></a></td>
			<td><a class="button button-primary" onclick="downloadTransactions()"><?php echo $button_download ?></a></td>
          </tr>
        </table>
      </form>
    </div>
  </div>
<?php } ?>

<script type="text/javascript">
	function downloadTransactions() {
		$('#download-iframe').remove();
		$('#transaction-form').after('<iframe name="download-iframe" id="download-iframe" style="display: none;" src="" />');

		$('#transaction-form').attr('method', 'POST');
		$('#transaction-form').attr('target', 'download-iframe');
		$('#transaction-form').attr('action', 'index.php?route=payment/securetrading_ws/downloadTransactions&token=<?php echo $token ?>');

		$('#transaction-form').submit();

		$('#transaction-form').removeAttr('method');
		$('#transaction-form').removeAttr('target');
		$('#transaction-form').removeAttr('action');
	}

	function showTransactions() {
		$.ajax({
			url: 'index.php?route=payment/securetrading_ws/showTransactions&token=<?php echo $token ?>',
			type: 'post',
			data: $('#transaction-form').serialize(),
			dataType: 'html',
			beforeSend: function() {
				$('.transactions').remove();
			},
			success: function(html) {
				$('.well').after(html);
			}
		});
	}

	$('.datetime').datetimepicker({
		pickTime: false
	});
</script>
<?php echo $footer; ?>