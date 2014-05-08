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
		<div id="tabs" class="htabs">
	  <a href="#tab-account"><?php echo $tab_account; ?></a>
	  <a href="#tab-sub-account"><?php echo $tab_sub_account; ?></a>
	  <a href="#tab-order-status"><?php echo $tab_order_status; ?></a>
	  <a href="#tab-payment"><?php echo $tab_payment; ?></a>
	</div>
          <div class="tab-content">
            <div class="tab-pane active" id="tab-account">
				<table class="form"> 
					<tr>
						<td><span class="required">* </span><?php echo $entry_merchant_id; ?></td>
						<td><input type="text" name="realex_remote_merchant_id" value="<?php echo $realex_remote_merchant_id; ?>" placeholder="<?php echo $entry_merchant_id; ?>" id="input-merchant-id" />
						 <?php if ($error_merchant_id) { ?>
						  <span class="error"><?php echo $error_merchant_id; ?></span>
						<?php } ?></td>
				   </tr>
				   <tr>
						<td><span class="required">* </span><?php echo $entry_secret; ?></td>
						<td><input type="password" name="realex_remote_secret" value="<?php echo $realex_remote_secret; ?>" placeholder="<?php echo $entry_secret; ?>" id="input-secret" />
						 <?php if ($error_secret) { ?>
						  <span class="error"><?php echo $error_secret; ?></span>
						<?php } ?></td>
				   </tr>
				   <tr>
						<td><?php echo $entry_rebate_password; ?></td>
						<td><input type="password" name="realex_remote_rebate_password" value="<?php echo $realex_remote_rebate_password; ?>" placeholder="<?php echo $entry_rebate_password; ?>" id="input-rebate-password" />
						 </td>
				   </tr>
				   <tr>
						<td><?php echo $entry_geo_zone; ?></td>
						<td> <select name="realex_remote_geo_zone_id" id="input-geo-zone" class="form-control">
							  <option value="0"><?php echo $text_all_zones; ?></option>
							  <?php foreach ($geo_zones as $geo_zone) { ?>
							  <?php if ($geo_zone['geo_zone_id'] == $realex_remote_geo_zone_id) { ?>
							  <option value="<?php echo $geo_zone['geo_zone_id']; ?>" selected="selected"><?php echo $geo_zone['name']; ?></option>
							  <?php } else { ?>
							  <option value="<?php echo $geo_zone['geo_zone_id']; ?>"><?php echo $geo_zone['name']; ?></option>
							  <?php } ?>
							  <?php } ?>
							</select>
						</td>
				   </tr>
				   <tr>
						<td><?php echo $entry_debug; ?></td>
						<td> <select name="realex_remote_debug" id="input-debug" class="form-control">
							  <?php if ($realex_remote_debug) { ?>
							  <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
							  <option value="0"><?php echo $text_disabled; ?></option>
							  <?php } else { ?>
							  <option value="1"><?php echo $text_enabled; ?></option>
							  <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
							  <?php } ?>
							</select>
							<span><?php echo $text_help_debug; ?></span>
						</td>
				   </tr>
				   <tr>
						<td><?php echo $entry_status; ?></td>
						<td> <select name="realex_remote_status" id="input-status" class="form-control">
							  <?php if ($realex_remote_status) { ?>
								<option value="1" selected="selected"><?php echo $text_enabled; ?></option>
								<option value="0"><?php echo $text_disabled; ?></option>
							  <?php } else { ?>
								<option value="1"><?php echo $text_enabled; ?></option>
								<option value="0" selected="selected"><?php echo $text_disabled; ?></option>
							  <?php } ?>
							</select>
						</td>
				   </tr>
				   <tr>
						<td><?php echo $entry_card_data_status; ?></td>
						<td> <select name="realex_remote_card_data_status" id="input-status" class="form-control">
							  <?php if ($realex_remote_card_data_status) { ?>
								<option value="1" selected="selected"><?php echo $text_enabled; ?></option>
								<option value="0"><?php echo $text_disabled; ?></option>
							  <?php } else { ?>
								<option value="1"><?php echo $text_enabled; ?></option>
								<option value="0" selected="selected"><?php echo $text_disabled; ?></option>
							  <?php } ?>
							</select>
							<span><?php echo $text_help_card_data_status; ?></span>
						</td>
				   </tr>
				   <tr>
						<td><?php echo $entry_total; ?></td>
						<td><input type="text" name="realex_remote_total" value="<?php echo $realex_remote_total; ?>" placeholder="<?php echo $entry_total; ?>" id="input-total" />
						 </td>
				   </tr>
				   <tr>
						<td><?php echo $entry_sort_order; ?></td>
						<td><input type="text" name="realex_remote_sort_order" value="<?php echo $realex_remote_sort_order; ?>" placeholder="<?php echo $entry_sort_order; ?>" id="input-sort-order" />
						 </td>
				   </tr>
			    </table>
            </div>
            <div class="tab-pane" id="tab-sub-account">
				<div class="warning"> <?php echo $error_use_select_card; ?>
                </div>
              <div class="table-responsive">
                <table class="form">
                  <thead>
                  <tr>
                    <td class="text-left"><?php echo $text_card_type; ?></td>
                    <td class="text-center"><?php echo $text_enabled; ?></td>
                    <td class="text-center"><?php echo $text_use_default; ?></td>
                    <td class="text-left"><?php echo $text_subaccount; ?></td>
                  </tr>
                  </thead>
                  <tbody>
                  <tr>
                    <td class="text-left"><?php echo $text_card_visa; ?></td>
                    <td class="text-center"><input type="checkbox" name="realex_remote_account[visa][enabled]" value="1" <?php if (isset($realex_remote_account['visa']['enabled']) && $realex_remote_account['visa']['enabled'] == 1) { echo 'checked="checked" '; } ?>/></td>
                    <td class="text-center"><input type="checkbox" name="realex_remote_account[visa][default]" value="1" <?php if (isset($realex_remote_account['visa']['default']) && $realex_remote_account['visa']['default'] == 1) { echo 'checked="checked" '; } ?>/></td>
                    <td class="text-right"><input type="text" name="realex_remote_account[visa][merchant_id]" value="<?php echo isset($realex_remote_account['visa']['merchant_id']) ? $realex_remote_account['visa']['merchant_id'] : ''; ?>" placeholder="<?php echo $entry_merchant_id; ?>" class="form-control" /></td>
                  </tr>
                  <tr>
                    <td class="text-left"><?php echo $text_card_master; ?></td>
                    <td class="text-center"><input type="checkbox" name="realex_remote_account[mc][enabled]" value="1" <?php if (isset($realex_remote_account['mc']['enabled']) && $realex_remote_account['mc']['enabled'] == 1) { echo 'checked="checked" '; } ?>/></td>
                    <td class="text-center"><input type="checkbox" name="realex_remote_account[mc][default]" value="1" <?php if (isset($realex_remote_account['mc']['default']) && $realex_remote_account['mc']['default'] == 1) { echo 'checked="checked" '; } ?>/></td>
                    <td class="text-right"><input type="text" name="realex_remote_account[mc][merchant_id]" value="<?php echo isset($realex_remote_account['mc']['merchant_id']) ? $realex_remote_account['mc']['merchant_id'] : ''; ?>" placeholder="<?php echo $entry_merchant_id; ?>" class="form-control" /></td>
                  </tr>
                  <tr>
                    <td class="text-left"><?php echo $text_card_amex; ?></td>
                    <td class="text-center"><input type="checkbox" name="realex_remote_account[amex][enabled]" value="1" <?php if (isset($realex_remote_account['amex']['enabled']) && $realex_remote_account['amex']['enabled'] == 1) { echo 'checked="checked" '; } ?>/></td>
                    <td class="text-center"><input type="checkbox" name="realex_remote_account[amex][default]" value="1" <?php if (isset($realex_remote_account['amex']['default']) && $realex_remote_account['amex']['default'] == 1) { echo 'checked="checked" '; } ?>/></td>
                    <td class="text-right"><input type="text" name="realex_remote_account[amex][merchant_id]" value="<?php echo isset($realex_remote_account['amex']['merchant_id']) ? $realex_remote_account['amex']['merchant_id'] : ''; ?>" placeholder="<?php echo $entry_merchant_id; ?>" class="form-control" /></td>
                  </tr>
                  <tr>
                    <td class="text-left"><?php echo $text_card_switch; ?></td>
                    <td class="text-center"><input type="checkbox" name="realex_remote_account[switch][enabled]" value="1" <?php if (isset($realex_remote_account['switch']['enabled']) && $realex_remote_account['switch']['enabled'] == 1) { echo 'checked="checked" '; } ?>/></td>
                    <td class="text-center"><input type="checkbox" name="realex_remote_account[switch][default]" value="1" <?php if (isset($realex_remote_account['switch']['default']) && $realex_remote_account['switch']['default'] == 1) { echo 'checked="checked" '; } ?>/></td>
                    <td class="text-right"><input type="text" name="realex_remote_account[switch][merchant_id]" value="<?php echo isset($realex_remote_account['switch']['merchant_id']) ? $realex_remote_account['switch']['merchant_id'] : ''; ?>" placeholder="<?php echo $entry_merchant_id; ?>" class="form-control" /></td>
                  </tr>
                  <tr>
                    <td class="text-left"><?php echo $text_card_laser; ?></td>
                    <td class="text-center"><input type="checkbox" name="realex_remote_account[laser][enabled]" value="1" <?php if (isset($realex_remote_account['laser']['enabled']) && $realex_remote_account['laser']['enabled'] == 1) { echo 'checked="checked" '; } ?>/></td>
                    <td class="text-center"><input type="checkbox" name="realex_remote_account[laser][default]" value="1" <?php if (isset($realex_remote_account['laser']['default']) && $realex_remote_account['laser']['default'] == 1) { echo 'checked="checked" '; } ?>/></td>
                    <td class="text-right"><input type="text" name="realex_remote_account[laser][merchant_id]" value="<?php echo isset($realex_remote_account['laser']['merchant_id']) ? $realex_remote_account['laser']['merchant_id'] : ''; ?>" placeholder="<?php echo $entry_merchant_id; ?>" class="form-control" /></td>
                  </tr>
                  <tr>
                    <td class="text-left"><?php echo $text_card_diners; ?></td>
                    <td class="text-center"><input type="checkbox" name="realex_remote_account[diners][enabled]" value="1" <?php if (isset($realex_remote_account['diners']['enabled']) && $realex_remote_account['diners']['enabled'] == 1) { echo 'checked="checked" '; } ?>/></td>
                    <td class="text-center"><input type="checkbox" name="realex_remote_account[diners][default]" value="1" <?php if (isset($realex_remote_account['diners']['default']) && $realex_remote_account['diners']['default'] == 1) { echo 'checked="checked" '; } ?>/></td>
                    <td class="text-right"><input type="text" name="realex_remote_account[diners][merchant_id]" value="<?php echo isset($realex_remote_account['diners']['merchant_id']) ? $realex_remote_account['diners']['merchant_id'] : ''; ?>" placeholder="<?php echo $entry_merchant_id; ?>" class="form-control" /></td>
                  </tr>
                  </tbody>
                </table>
              </div>
            </div>
            <div class="tab-pane" id="tab-order-status">
				  <table class="form">
					  <tr>
						<td><?php echo $entry_status_success_settled; ?></td>
						<td>  <select name="realex_remote_order_status_success_settled_id" id="input-order-status-success-settled" class="form-control">
						  <?php foreach ($order_statuses as $order_status) { ?>
						  <?php if ($order_status['order_status_id'] == $realex_remote_order_status_success_settled_id) { ?>
						  <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
						  <?php } else { ?>
						  <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
						  <?php } ?>
						  <?php } ?>
						</select>
						</td>
					  </tr>
                
					  <tr>
						<td><?php echo $entry_status_success_unsettled; ?></td>
						<td>  <select name="realex_remote_order_status_success_unsettled_id" id="input-order-status-success-unsettled" class="form-control">
						  <?php foreach ($order_statuses as $order_status) { ?>
						  <?php if ($order_status['order_status_id'] == $realex_remote_order_status_success_unsettled_id) { ?>
						  <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
						  <?php } else { ?>
						  <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
						  <?php } ?>
						  <?php } ?>
						</select>
						</td>
					  </tr>
					  <tr>
						<td><?php echo $entry_status_decline_pending; ?></td>
						<td>  <select name="realex_remote_order_status_decline_pending_id" id="input-order-status-decline-pending" class="form-control">
						  <?php foreach ($order_statuses as $order_status) { ?>
						  <?php if ($order_status['order_status_id'] == $realex_remote_order_status_decline_pending_id) { ?>
						  <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
						  <?php } else { ?>
						  <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
						  <?php } ?>
						  <?php } ?>
						</select>
						</td>
					  </tr>

					 <tr>
						<td><?php echo $entry_status_decline_stolen; ?></td>
						<td>   <select name="realex_remote_order_status_decline_stolen_id" id="input-order-status-decline-stolen" class="form-control">
						  <?php foreach ($order_statuses as $order_status) { ?>
						  <?php if ($order_status['order_status_id'] == $realex_remote_order_status_decline_stolen_id) { ?>
						  <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
						  <?php } else { ?>
						  <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
						  <?php } ?>
						  <?php } ?>
						</select>
						</td>
					  </tr>
            		
					<tr>
						<td><?php echo $entry_status_decline_bank; ?></td>
						<td>  <select name="realex_remote_order_status_decline_bank_id" id="input-order-status-decline-bank" class="form-control">
						  <?php foreach ($order_statuses as $order_status) { ?>
						  <?php if ($order_status['order_status_id'] == $realex_remote_order_status_decline_bank_id) { ?>
						  <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
						  <?php } else { ?>
						  <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
						  <?php } ?>
						  <?php } ?>
						</select>
						</td>
					  </tr> 

					  <tr>
						<td><?php echo $entry_status_void; ?></td>
						<td>  <select name="realex_remote_order_status_void_id" id="input-order-status-void" class="form-control">
						  <?php foreach ($order_statuses as $order_status) { ?>
						  <?php if ($order_status['order_status_id'] == $realex_remote_order_status_void_id) { ?>
						  <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
						  <?php } else { ?>
						  <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
						  <?php } ?>
						  <?php } ?>
						</select>
						</td>
					  </tr>
					  <tr>
						<td><?php echo $entry_status_rebate; ?></td>
						<td>  <select name="realex_remote_order_status_rebated_id" id="input-order-status-rebate" class="form-control">
						  <?php foreach ($order_statuses as $order_status) { ?>
						  <?php if ($order_status['order_status_id'] == $realex_remote_order_status_rebated_id) { ?>
						  <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
						  <?php } else { ?>
						  <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
						  <?php } ?>
						  <?php } ?>
						</select>
						</td>
					  </tr>
					  
				</table>
            </div>
            <div class="tab-pane" id="tab-payment">
				<table class="form">
				  <tr>
					<td><?php echo $entry_auto_settle; ?></td>
					<td>  <select name="realex_remote_auto_settle" id="input-auto-settle" class="form-control">
                      <option value="0"<?php echo ($realex_remote_auto_settle == 0 ? ' selected' : ''); ?>><?php echo $text_settle_delayed; ?></option>
                      <option value="1"<?php echo ($realex_remote_auto_settle == 1 ? ' selected' : ''); ?>><?php echo $text_settle_auto; ?></option>
                      <option value="2"<?php echo ($realex_remote_auto_settle == 2 ? ' selected' : ''); ?>><?php echo $text_settle_multi; ?></option>
                    </select>
                    <span><?php echo $text_help_dcc_settle; ?></span>
					</td>
				  </tr>            

				 <tr>
					<td><?php echo $entry_tss_check; ?></td>
					<td>  <select name="realex_remote_tss_check" id="input-tss-check" class="form-control">
                      <?php if ($realex_remote_tss_check) { ?>
                      <option value="1" selected="selected"><?php echo $text_yes; ?></option>
                      <option value="0"><?php echo $text_no; ?></option>
                      <?php } else { ?>
                      <option value="1"><?php echo $text_yes; ?></option>
                      <option value="0" selected="selected"><?php echo $text_no; ?></option>
                      <?php } ?>
                    </select>
					</td>
				  </tr>
             
				 <tr>
					<td><?php echo $entry_tss_check; ?></td>
					<td>  <select name="realex_remote_3d" id="input-3d" class="form-control">
                    <?php if ($realex_remote_3d) { ?>
                    <option value="1" selected="selected"><?php echo $text_yes; ?></option>
                    <option value="0"><?php echo $text_no; ?></option>
                    <?php } else { ?>
                    <option value="1"><?php echo $text_yes; ?></option>
                    <option value="0" selected="selected"><?php echo $text_no; ?></option>
                    <?php } ?>
                  </select>
					</td>
				  </tr>	

				 <tr>
					<td><?php echo $entry_3d; ?></td>
					<td>  <select name="realex_remote_3d" id="input-3d" class="form-control">
                    <?php if ($realex_remote_3d) { ?>
                    <option value="1" selected="selected"><?php echo $text_yes; ?></option>
                    <option value="0"><?php echo $text_no; ?></option>
                    <?php } else { ?>
                    <option value="1"><?php echo $text_yes; ?></option>
                    <option value="0" selected="selected"><?php echo $text_no; ?></option>
                    <?php } ?>
                  </select>
					</td>
				  </tr>					  
				 
				 <tr>
					<td><?php echo $entry_liability_shift; ?></td>
					<td>  <select name="realex_remote_liability" id="input-liability" class="form-control">
                    <?php if ($realex_remote_liability) { ?>
                    <option value="1" selected="selected"><?php echo $text_yes; ?></option>
                    <option value="0"><?php echo $text_no; ?></option>
                    <?php } else { ?>
                    <option value="1"><?php echo $text_yes; ?></option>
                    <option value="0" selected="selected"><?php echo $text_no; ?></option>
                    <?php } ?>
                  </select>
					</td>
				  </tr>	
			 </table>
          </div>
        </form>
      </div>
	</div>
  </div>
<script type="text/javascript"><!--
$('#tabs a').tabs(); 
//--></script>
<?php echo $footer; ?>