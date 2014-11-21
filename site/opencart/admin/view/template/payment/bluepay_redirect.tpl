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
            <td><span class="required">*</span> <?php echo $entry_vendor; ?></td>
            <td><input type="text" name="bluepay_redirect_account_id" value="<?php echo $bluepay_redirect_account_id; ?>" placeholder="<?php echo $entry_vendor; ?>" id="input-vendor" class="form-control" />
              <?php if (error_account_id) { ?>
              <span class="error"><?php echo $error_account_id; ?></span>
              <?php } ?></td>
          </tr>
		  <tr>
            <td><span class="required">*</span> <?php echo $entry_secret_key; ?></td>
            <td><input type="text" name="bluepay_redirect_secret_key" value="<?php echo $bluepay_redirect_secret_key; ?>" placeholder="<?php echo $entry_secret_key; ?>" id="bluepay_redirect_secret_key" class="form-control" />
              <?php if (error_secret_key) { ?>
              <span class="error"><?php echo $error_secret_key; ?></span>
              <?php } ?></td>
          </tr>
		  <tr>
            <td><?php echo $entry_test; ?></td>
            <td><select name="bluepay_redirect_test" id="input-test" class="form-control">
                <?php if ($bluepay_redirect_test == 'test') { ?>
                <option value="test" selected="selected"><?php echo $text_test; ?></option>
                <?php } else { ?>
                <option value="test"><?php echo $text_test; ?></option>
                <?php } ?>
                <?php if ($bluepay_redirect_test == 'live') { ?>
                <option value="live" selected="selected"><?php echo $text_live; ?></option>
                <?php } else { ?>
                <option value="live"><?php echo $text_live; ?></option>
                <?php } ?>
              </select></td>
          </tr>
		  <tr>
            <td><?php echo $entry_transaction; ?>
			<span class="help"><?php echo $help_transaction; ?></span>
			</td>
            <td><select name="bluepay_redirect_transaction" id="input-transaction" class="form-control">
                <?php if ($bluepay_redirect_transaction == 'SALE') { ?>
                <option value="SALE" selected="selected"><?php echo $text_sale; ?></option>
                <?php } else { ?>
                <option value="SALE"><?php echo $text_sale; ?></option>
                <?php } ?>
                <?php if ($bluepay_redirect_transaction == 'AUTH') { ?>
                <option value="AUTH" selected="selected"><?php echo $text_authenticate; ?></option>
                <?php } else { ?>
                <option value="AUTH"><?php echo $text_authenticate; ?></option>
                <?php } ?>
              </select></td>
          </tr>
		  <tr>
            <td><?php echo $entry_total; ?>
			<span class="help"><?php echo $help_total; ?></span>
			</td>
            <td>
			<input type="text" name="bluepay_redirect_total" value="<?php echo $bluepay_redirect_total; ?>" placeholder="<?php echo $entry_total; ?>" id="input-total" class="form-control" />
			</td>
          </tr>
		  <tr>
            <td><?php echo $entry_card; ?></td>
            <td><select name="bluepay_redirect_card" id="input-card" class="form-control">
                <?php if ($bluepay_redirect_card) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select></td>
          </tr>
		  <tr>
            <td><?php echo $entry_order_status; ?></td>
            <td><select name="bluepay_redirect_order_status_id" id="input-order-status" class="form-control">
                <?php foreach ($order_statuses as $order_status) { ?>
                <?php if ($order_status['order_status_id'] == $bluepay_redirect_order_status_id) { ?>
                <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                <?php } ?>
                <?php } ?>
              </select></td>
          </tr>
		  <tr>
            <td><?php echo $entry_geo_zone; ?></td>
            <td><select name="bluepay_redirect_geo_zone_id" id="input-geo-zone" class="form-control">
                <option value="0"><?php echo $text_all_zones; ?></option>
                <?php foreach ($geo_zones as $geo_zone) { ?>
                <?php if ($geo_zone['geo_zone_id'] == $bluepay_redirect_geo_zone_id) { ?>
                <option value="<?php echo $geo_zone['geo_zone_id']; ?>" selected="selected"><?php echo $geo_zone['name']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $geo_zone['geo_zone_id']; ?>"><?php echo $geo_zone['name']; ?></option>
                <?php } ?>
                <?php } ?>
              </select></td>
          </tr>
		  <tr>
            <td><?php echo $entry_debug; ?>
			<span class="help"><?php echo $help_debug; ?></span>
			</td>
            <td><select name="bluepay_redirect_debug" id="input-debug" class="form-control">
                <?php if ($bluepay_redirect_debug) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select></td>
          </tr>
		  <tr>
            <td><?php echo $entry_status; ?></td>
            <td><select name="bluepay_redirect_status" id="input-status" class="form-control">
                <?php if ($bluepay_redirect_status) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select></td>
          </tr>
        </table>
      </form>
    </div>
  </div>
</div>
<?php echo $footer; ?> 