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
   <div class="buttons"><a onclick="save('save');" class="button"><?php echo $button_save; ?></a><a onclick="$('#form').submit();" class="button"><?php echo $button_saveclose; ?></a><a href="<?php echo $cancel; ?>" class="button"><?php echo $button_cancel; ?></a></div>
   </div>
	<div class="content">
	  <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
		<div id="tabs" class="htabs">
			<a href="#tab-account"><?php echo $tab_account; ?></a>
			<a href="#tab-order-status"><?php echo $tab_order_status; ?></a>
			<a href="#tab-payment"><?php echo $tab_payment; ?></a>
		</div>
          <div class="tab-content">
            <div class="tab-pane active" id="tab-account">
				<table class="form"> 
					<tr>
						<td><span class="required">* </span><?php echo $entry_merchant_id; ?></td>
						<td><input type="text" name="firstdata_remote_merchant_id" value="<?php echo $firstdata_remote_merchant_id; ?>" placeholder="<?php echo $entry_merchant_id; ?>" id="input-merchant-id" class="form-control"/>
						<?php if ($error_merchant_id) { ?>
						<div class="error"><?php echo $error_merchant_id; ?></div>
						<?php } ?></td>
				   </tr>
				   <tr>
						<td><span class="required">* </span><?php echo $entry_user_id; ?></td>
						<td><input type="text" name="firstdata_remote_user_id" value="<?php echo $firstdata_remote_user_id; ?>" placeholder="<?php echo $entry_user_id; ?>" id="input-user-id" class="form-control"/>
						<?php if ($error_user_id) { ?>
						<div class="error"><?php echo $error_user_id; ?></div>
						<?php } ?></td>
				   </tr>
				   <tr>
						<td><span class="required">* </span><?php echo $entry_password; ?></td>
						<td><input type="password" name="firstdata_remote_password" value="<?php echo $firstdata_remote_password; ?>" placeholder="<?php echo $entry_password; ?>" id="input-password" class="form-control"/>
						<?php if ($error_password) { ?>
						<div class="error"><?php echo $error_password; ?></div>
						<?php } ?></td>
				   </tr>
				   <tr>
						<td><span class="required">* </span><?php echo $entry_certificate_path; ?>
						<span class="help"><?php echo $help_certificate; ?></span></td>
						<td><input type="text" name="firstdata_remote_certificate" value="<?php echo $firstdata_remote_certificate; ?>" placeholder="<?php echo $entry_certificate_path; ?>" id="input-certificate-path" class="form-control"/>
						<?php if ($error_certificate) { ?>
						<div class="error"><?php echo $error_certificate; ?></div>
						<?php } ?></td>
				   </tr>
				   <tr>
						<td><span class="required">* </span><?php echo $entry_certificate_key_path; ?></td>
						<td><input type="text" name="firstdata_remote_key" value="<?php echo $firstdata_remote_key; ?>" placeholder="<?php echo $entry_certificate_key_path; ?>" id="input-key-path" class="form-control"/>
						<?php if ($error_key) { ?>
						<div class="error"><?php echo $error_key; ?></div>
						<?php } ?></td>
				   </tr>
				   <tr>
						<td><span class="required">* </span><?php echo $entry_certificate_key_pw; ?></td>
						<td><input type="text" name="firstdata_remote_key_pw" value="<?php echo $firstdata_remote_key_pw; ?>" placeholder="<?php echo $entry_certificate_key_pw; ?>" id="input-key-pw" class="form-control"/>
						<?php if ($error_key_pw) { ?>
						<div class="error"><?php echo $error_key_pw; ?></div>
						<?php } ?></td>
				   </tr>
				   <tr>
						<td><span class="required">* </span><?php echo $entry_certificate_ca_path; ?></td>
						<td><input type="text" name="firstdata_remote_ca" value="<?php echo $firstdata_remote_ca; ?>" placeholder="<?php echo $entry_certificate_ca_path; ?>" id="input-ca-path" class="form-control"/>
						<?php if ($error_ca) { ?>
						<div class="error"><?php echo $error_ca; ?></div>
						<?php } ?></td>
				   </tr>
				   <tr>
						<td><?php echo $entry_debug; ?><span class="help"><?php echo $help_debug; ?></span></td>
						<td><select name="firstdata_remote_debug" id="input-debug" class="form-control">
						<?php if ($firstdata_remote_debug) { ?>
						<option value="1" selected="selected"><?php echo $text_enabled; ?></option>
						<option value="0"><?php echo $text_disabled; ?></option>
						<?php } else { ?>
						<option value="1"><?php echo $text_enabled; ?></option>
						<option value="0" selected="selected"><?php echo $text_disabled; ?></option>
						<?php } ?>
					  </select></td>
				   </tr>
				   <tr>
						<td><?php echo $entry_total; ?><span class="help"><?php echo $help_total; ?></span></td>
						<td><input type="text" name="firstdata_remote_total" value="<?php echo $firstdata_remote_total; ?>" placeholder="<?php echo $entry_total; ?>" id="input-total" class="form-control"/></td>
				   </tr>
				   <tr>
						<td><?php echo $entry_geo_zone; ?></td>
						<td><select name="firstdata_remote_geo_zone_id" id="input-geo-zone" class="form-control">
						<option value="0"><?php echo $text_all_zones; ?></option>
						<?php foreach ($geo_zones as $geo_zone) { ?>
						<?php if ($geo_zone['geo_zone_id'] == $firstdata_remote_geo_zone_id) { ?>
						<option value="<?php echo $geo_zone['geo_zone_id']; ?>" selected="selected"><?php echo $geo_zone['name']; ?></option>
						<?php } else { ?>
						<option value="<?php echo $geo_zone['geo_zone_id']; ?>"><?php echo $geo_zone['name']; ?></option>
						<?php } ?>
						<?php } ?>
					  </select></td>
				   </tr>
				   <tr>
						<td><?php echo $entry_status; ?></td>
						<td><select name="firstdata_remote_status" id="input-status" class="form-control">
						<?php if ($firstdata_remote_status) { ?>
						<option value="1" selected="selected"><?php echo $text_enabled; ?></option>
						<option value="0"><?php echo $text_disabled; ?></option>
						<?php } else { ?>
						<option value="1"><?php echo $text_enabled; ?></option>
						<option value="0" selected="selected"><?php echo $text_disabled; ?></option>
						<?php } ?>
					  </select></td>
				   </tr>
				   <tr>
						<td><?php echo $entry_sort_order; ?></td>
						<td><input type="text" name="firstdata_remote_sort_order" value="<?php echo $firstdata_remote_sort_order; ?>" placeholder="<?php echo $entry_sort_order; ?>" id="input-sort-order" class="form-control"/></td>
				   </tr>
			 </table>
			</div>
			<div class="tab-pane" id="tab-order-status">
				<table class="form"> 
					<tr>
						<td><?php echo $entry_status_success_settled; ?></td>
						<td><select name="firstdata_remote_order_status_success_settled_id" id="input-order-status-success-settled" class="form-control">
						<?php foreach ($order_statuses as $order_status) { ?>
						<?php if ($order_status['order_status_id'] == $firstdata_remote_order_status_success_settled_id) { ?>
						<option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
						<?php } else { ?>
						<option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
						<?php } ?>
						<?php } ?>
					  </select></td>
				   </tr>
				   <tr>
						<td><?php echo $entry_status_success_unsettled; ?></td>
						<td><select name="firstdata_remote_order_status_success_unsettled_id" id="input-order-status-success-unsettled" class="form-control">
						<?php foreach ($order_statuses as $order_status) { ?>
						<?php if ($order_status['order_status_id'] == $firstdata_remote_order_status_success_unsettled_id) { ?>
						<option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
						<?php } else { ?>
						<option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
						<?php } ?>
						<?php } ?>
					  </select></td>
				   </tr>
				   <tr>
						<td><?php echo $entry_status_decline; ?></td>
						<td><select name="firstdata_remote_order_status_decline_id" id="input-order-status-decline" class="form-control">
						<?php foreach ($order_statuses as $order_status) { ?>
						<?php if ($order_status['order_status_id'] == $firstdata_remote_order_status_decline_id) { ?>
						<option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
						<?php } else { ?>
						<option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
						<?php } ?>
						<?php } ?>
					  </select></td>
				   </tr>
				</table>
            </div>
            <div class="tab-pane" id="tab-payment">
				<table class="form"> 
					<tr>
						<td><?php echo $entry_auto_settle; ?>
						<span class="help"><?php echo $help_settle; ?></span></td>
						<td><select name="firstdata_remote_auto_settle" id="input-auto-settle" class="form-control">
						<?php if (!$firstdata_remote_auto_settle) { ?>
						<option value="0"><?php echo $text_settle_delayed; ?></option>
						<option value="1" selected="selected"><?php echo $text_settle_auto; ?></option>
						<?php } ?>
						<?php if ($firstdata_remote_auto_settle) { ?>
						<option value="0" selected="selected"><?php echo $text_settle_delayed; ?></option>
						<option value="1"><?php echo $text_settle_auto; ?></option>
						<?php } ?>
					  </select></td>
				   </tr>
				   <tr>
						<td><?php echo $entry_enable_card_store; ?></td>
						<td><select name="firstdata_remote_card_storage" id="input-card-store" class="form-control">
						<?php if ($firstdata_remote_card_storage) { ?>
						<option value="1" selected="selected"><?php echo $text_enabled; ?></option>
						<option value="0"><?php echo $text_disabled; ?></option>
						<?php } else { ?>
						<option value="1"><?php echo $text_enabled; ?></option>
						<option value="0" selected="selected"><?php echo $text_disabled; ?></option>
						<?php } ?>
					  </select></td>
				   </tr>
				   <?php $say=0; foreach ($cards as $card) { ?>
				   <tr>
				   <?php if(empty($say)){ ?>
						<td><?php echo $entry_cards_accepted; ?></td>
					<?php $say++;} else {  $say++;?>
						<td></td>
					<?php } ?>
						<td>
						<?php if (in_array($card['value'], $firstdata_remote_cards_accepted)) { ?>
						<input type="checkbox" name="firstdata_remote_cards_accepted[]" value="<?php echo $card['value']; ?>" checked="checked" />
						<?php echo $card['text']; ?>
						<?php } else { ?>
						<input type="checkbox" name="firstdata_remote_cards_accepted[]" value="<?php echo $card['value']; ?>" />
						<?php echo $card['text']; ?>
						<?php } ?></td>
				   </tr>
				   <?php } ?>
				</table>
            </div>
          </div>
        </form>
      </div>
    </div>
</div>
<script type="text/javascript"><!--
$('#tabs a').tabs(); 
//--></script>
<?php echo $footer; ?>