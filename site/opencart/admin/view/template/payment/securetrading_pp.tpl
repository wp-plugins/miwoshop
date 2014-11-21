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
			<td><input type="text" name="securetrading_pp_site_reference" value="<?php echo $securetrading_pp_site_reference; ?>" placeholder="<?php echo $entry_site_reference; ?>" id="securetrading_pp_site_reference" />
			<?php if ($error_site_reference) { ?>
			<div class="error"><?php echo $error_site_reference; ?></div>
			<?php } ?></td>
          </tr>
		  <tr>
            <td><?php echo $entry_username; ?></td>
			<td><input type="text" name="securetrading_pp_username" value="<?php echo $securetrading_pp_username; ?>" placeholder="<?php echo $entry_username; ?>" id="securetrading_pp_username" /></td>
          </tr>
		  <tr>
            <td><?php echo $entry_password; ?></td>
			<td><input type="text" name="securetrading_pp_password" value="<?php echo $securetrading_pp_password; ?>" placeholder="<?php echo $entry_password; ?>" id="securetrading_pp_password" /></td>
          </tr>
		  <tr>
            <td><?php echo $entry_site_security_status; ?></td>
			<td><select name="securetrading_pp_site_security_status" id="securetrading_pp_status" class="form-control">
			<?php if ($securetrading_pp_site_security_status == 1) { ?>
			<option value="1" selected="selected"><?php echo $text_enabled; ?></option>
			<?php } else { ?>
			<option value="1"><?php echo $text_enabled; ?></option>
			<?php } ?>
			<?php if ($securetrading_pp_site_security_status == 0) { ?>
			<option value="0" selected="selected"><?php echo $text_disabled; ?></option>
			<?php } else { ?>
			<option value="0"><?php echo $text_disabled; ?></option>
			<?php } ?>
			</select></td>
          </tr>
		  <tr>
            <td><?php echo $entry_site_security_password; ?></td>
			<td><input type="text" name="securetrading_pp_site_security_password" value="<?php echo $securetrading_pp_site_security_password; ?>" placeholder="<?php echo $entry_site_security_password; ?>" id="securetrading_pp_site_security_password" /></td>
          </tr>
		  <tr>
            <td><span class="required">*</span> <?php echo $entry_notification_password; ?></td>
			<td><input type="text" name="securetrading_pp_notification_password" value="<?php echo $securetrading_pp_notification_password; ?>" placeholder="<?php echo $entry_notification_password; ?>" id="securetrading_pp_site_security_password" />
			<?php if ($error_notification_password) { ?>
			<div class="error"><?php echo $error_notification_password; ?></div>
			<?php } ?></td>
          </tr>
		  <tr>
            <td><?php echo $entry_username; ?></td>
			<td><input type="text" name="securetrading_pp_webservice_username" value="<?php echo $securetrading_pp_webservice_username; ?>" placeholder="<?php echo $entry_username; ?>" id="securetrading_pp_webservice_username" />
			<span class="help"><?php echo $help_username; ?></span></td>
          </tr>
		  <tr>
            <td><?php echo $entry_password; ?></td>
			<td><input type="text" name="securetrading_pp_webservice_password" value="<?php echo $securetrading_pp_webservice_password; ?>" placeholder="<?php echo $entry_password; ?>" id="securetrading_pp_webservice_username" />
			<span class="help"><?php echo $help_password; ?></span></td>
          </tr>
		  <tr>
            <td><?php echo $entry_cards_accepted; ?></td>
			<td><?php foreach ($cards as $key => $value) { ?>
			<div class="checkbox">
				<label>
					<?php if (in_array($key, $securetrading_pp_cards_accepted)) { ?>
						<input type="checkbox" checked="checked" name="securetrading_pp_cards_accepted[]" value="<?php echo $key ?>" />
					<?php } else { ?>
						<input type="checkbox" name="securetrading_pp_cards_accepted[]" value="<?php echo $key ?>" />
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
			<td><select name="securetrading_pp_settle_status" id="securetrading_pp_settle_status" class="form-control">
			<?php foreach ($settlement_statuses as $key => $value) { ?>
				<?php if ($key == $securetrading_pp_settle_status) { ?>
					<option value="<?php echo $key; ?>" selected="selected"><?php echo $value; ?></option>
				<?php } else { ?>
					<option value="<?php echo $key; ?>"><?php echo $value; ?></option>
				<?php } ?>
			<?php } ?>
			</select></td>
          </tr>
		  <tr>
            <td><?php echo $entry_settle_due_date; ?></td>
			<td><select name="securetrading_pp_settle_due_date" id="securetrading_pp_settle_due_date" class="form-control">
			<?php if ($securetrading_pp_settle_due_date == 0) { ?>
				<option value="0" selected="selected"><?php echo $text_process_immediately; ?></option>
			<?php } else { ?>
				<option value="0"><?php echo $text_process_immediately; ?></option>
			<?php } ?>
			<?php for ($i = 1; $i < 8; $i++) { ?>
				<?php if ($i == $securetrading_pp_settle_due_date) { ?>
					<option value="<?php echo $i ?>" selected="selected"><?php echo sprintf($text_wait_x_days, $i) ?></option>
				<?php } else { ?>
					<option value="<?php echo $i ?>"><?php echo sprintf($text_wait_x_days, $i) ?></option>
				<?php } ?>
			<?php } ?>
			</select></td>
          </tr>
		  <tr>
            <td><?php echo $entry_total; ?></td>
			<td><input type="text" name="securetrading_pp_total" value="<?php echo $securetrading_pp_total; ?>" placeholder="<?php echo $entry_total; ?>" id="securetrading_pp_total" />
			<span class="help"><?php echo $help_total; ?></span></td>
          </tr>
		  <tr>
            <td><?php echo $entry_order_status; ?></td>
			<td><select name="securetrading_pp_order_status_id" id="securetrading_pp_order_status_id" class="form-control">
			<?php foreach ($order_statuses as $order_status) { ?>
				<?php if ($order_status['order_status_id'] == $securetrading_pp_order_status_id) { ?>
					<option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
				<?php } else { ?>
					<option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
				<?php } ?>
			<?php } ?>
			</select></td>
          </tr>
		  <tr>
            <td><?php echo $entry_declined_order_status; ?></td>
			<td><select name="securetrading_pp_declined_order_status_id" id="securetrading_pp_declined_order_status_id" class="form-control">
			<?php foreach ($order_statuses as $order_status) { ?>
				<?php if ($order_status['order_status_id'] == $securetrading_pp_declined_order_status_id) { ?>
					<option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
				<?php } else { ?>
					<option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
				<?php } ?>
			<?php } ?>
			</select></td>
          </tr>
		  <tr>
            <td><?php echo $entry_refunded_order_status; ?></td>
			<td><select name="securetrading_pp_refunded_order_status_id" id="securetrading_pp_refunded_order_status_id" class="form-control">
			<?php foreach ($order_statuses as $order_status) { ?>
				<?php if ($order_status['order_status_id'] == $securetrading_pp_refunded_order_status_id) { ?>
					<option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
				<?php } else { ?>
					<option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
				<?php } ?>
			<?php } ?>
			</select></td>
          </tr>
		  <tr>
            <td><?php echo $entry_authorisation_reversed_order_status; ?></td>
			<td><select name="securetrading_pp_authorisation_reversed_order_status_id" id="securetrading_pp_authorisation_reversed_order_status_id" class="form-control">
			<?php foreach ($order_statuses as $order_status) { ?>
				<?php if ($order_status['order_status_id'] == $securetrading_pp_authorisation_reversed_order_status_id) { ?>
					<option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
				<?php } else { ?>
					<option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
				<?php } ?>
			<?php } ?>
			</select></td>
          </tr>
		  <tr>
            <td><?php echo $entry_geo_zone; ?></td>
			<td><select name="securetrading_pp_geo_zone_id" id="securetrading_pp_geo_zone_id" class="form-control">
			<?php if ($securetrading_pp_geo_zone_id == 0) { ?>
				<option value="0" selected="selected"><?php echo $text_all_geo_zones; ?></option>
			<?php } else { ?>
				<option value="0"><?php echo $text_all_geo_zones; ?></option>
			<?php } ?>
			<?php foreach ($geo_zones as $geo_zone) { ?>
				<?php if ($securetrading_pp_geo_zone_id == $geo_zone['geo_zone_id']) { ?>
					<option value="<?php echo $geo_zone['geo_zone_id']; ?>" selected="selected"><?php echo $geo_zone['name']; ?></option>
				<?php } else { ?>
					<option value="<?php echo $geo_zone['geo_zone_id']; ?>"><?php echo $geo_zone['name']; ?></option>
				<?php } ?>
			<?php } ?>
			</select></td>
          </tr>
		  <tr>
            <td><?php echo $entry_status; ?></td>
			<td><select name="securetrading_pp_status" id="securetrading_pp_status" class="form-control">
			<?php if ($securetrading_pp_status == 1) { ?>
				<option value="1" selected="selected"><?php echo $text_enabled; ?></option>
			<?php } else { ?>
				<option value="1"><?php echo $text_enabled; ?></option>
			<?php } ?>
			<?php if ($securetrading_pp_status == 0) { ?>
				<option value="0" selected="selected"><?php echo $text_disabled; ?></option>
			<?php } else { ?>
				<option value="0"><?php echo $text_disabled; ?></option>
			<?php } ?>
			</select></td>
          </tr>
		  <tr>
            <td><?php echo $entry_sort_order; ?></td>
			<td><input type="text" name="securetrading_pp_sort_order" value="<?php echo $securetrading_pp_sort_order; ?>" placeholder="<?php echo $entry_sort_order; ?>" id="securetrading_pp_sort_order" /></td>
          </tr>
		  <tr>
            <td><?php echo $entry_parent_css; ?></td>
			<td><input type="text" name="securetrading_pp_parent_css" value="<?php echo $securetrading_pp_parent_css; ?>" placeholder="<?php echo $entry_parent_css; ?>" id="securetrading_pp_parent_css" /></td>
          </tr>
		  <tr>
            <td><?php echo $entry_child_css; ?></td>
			<td><input type="text" name="securetrading_pp_child_css" value="<?php echo $securetrading_pp_child_css; ?>" placeholder="<?php echo $entry_child_css; ?>" id="securetrading_pp_child_css" /></td>
          </tr>
        </table>
      </form>
    </div>
  </div>
</div>
<?php echo $footer; ?> 