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
  <?php if ($success) { ?>
  <div class="success"><?php echo $success; ?></div>
  <?php } ?>
  <div class="box">
    <div class="heading">
      <h1><img src="view/image/customer.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons"><a href="<?php echo $insert; ?>" class="button"><?php echo $button_insert; ?></a><a onclick="document.getElementById('form').submit();" class="button"><?php echo $button_delete; ?></a><a onclick="changeStatus(1);" class="button"><?php echo $button_enable; ?></a><a onclick="changeStatus(0)" class="button"><?php echo $button_disable; ?></a></div>
    </div>
    <div class="content">
      <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form">
        <table class="list">
          <thead>
            <tr>
              <td width="1" style="text-align: center;"><input type="checkbox" onclick="$('input[name*=\'selected\']').attr('checked', this.checked);" /></td>
              <td class="left"><?php if ($sort == 'cd.name') { ?>
                <a href="<?php echo $sort_name; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_name; ?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_name; ?>"><?php echo $column_name; ?></a>
                <?php } ?></td>
              <td class="left"><?php if ($sort == 'c.code') { ?>
                <a href="<?php echo $sort_code; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_code; ?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_code; ?>"><?php echo $column_code; ?></a>
                <?php } ?></td>
              <td class="right"><?php if ($sort == 'c.discount') { ?>
                <a href="<?php echo $sort_discount; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_discount; ?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_discount; ?>"><?php echo $column_discount; ?></a>
                <?php } ?></td>
              <td class="left"><?php if ($sort == 'c.date_start') { ?>
                <a href="<?php echo $sort_date_start; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_date_start; ?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_date_start; ?>"><?php echo $column_date_start; ?></a>
                <?php } ?></td>
              <td class="left"><?php if ($sort == 'c.date_end') { ?>
                <a href="<?php echo $sort_date_end; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_date_end; ?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_date_end; ?>"><?php echo $column_date_end; ?></a>
                <?php } ?></td>
              <td class="left"><?php if ($sort == 'c.status') { ?>
                <a href="<?php echo $sort_status; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_status; ?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_status; ?>"><?php echo $column_status; ?></a>
                <?php } ?></td>
              <td class="right"><?php echo $column_action; ?></td>
            </tr>
          </thead>
          <tbody>
            <tr class="filter">
                <td></td>
                <td><input type="text" name="filter_name" value="<?php echo $filter_name; ?>" /></td>
                <td><input type="text" name="filter_code" value="<?php echo $filter_code; ?>" /></td>
                <td align="right"><input type="text" name="filter_discount" value="<?php echo $filter_discount; ?>" /></td>
                <td><input type="text" name="filter_date_start" value="<?php echo $filter_date_start; ?>" size="12" class="date" /></td>
                <td><input type="text" name="filter_date_end" value="<?php echo $filter_date_end; ?>" size="12" class="date" /></td>
                <td align="right" width="100">
                  <select name="filter_status">
                    <option value="*"></option>
                    <?php if ($filter_status) { ?>
                    <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                    <?php } else { ?>
                    <option value="1"><?php echo $text_enabled; ?></option>
                    <?php } ?>
                    <?php if (!is_null($filter_status) && !$filter_status) { ?>
                    <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                    <?php } else { ?>
                    <option value="0"><?php echo $text_disabled; ?></option>
                    <?php } ?>
                  </select>
                </td>
                <td align="right" width="100"><a onclick="filter();" class="button"><?php echo $button_filter; ?></a></td>
            </tr>
            <?php if ($coupons) { ?>
            <?php foreach ($coupons as $coupon) { ?>
            <tr>
              <td style="text-align: center;"><?php if ($coupon['selected']) { ?>
                <input type="checkbox" name="selected[]" value="<?php echo $coupon['coupon_id']; ?>" checked="checked" />
                <?php } else { ?>
                <input type="checkbox" name="selected[]" value="<?php echo $coupon['coupon_id']; ?>" />
                <?php } ?></td>
              <td class="left"><?php echo $coupon['name']; ?></td>
              <td class="left"><?php echo $coupon['code']; ?></td>
              <td class="right"><?php echo $coupon['discount']; ?></td>
              <td class="left"><?php echo $coupon['date_start']; ?></td>
              <td class="left"><?php echo $coupon['date_end']; ?></td>
              <td class="left"><?php echo $coupon['status']; ?></td>
              <td class="right"><?php foreach ($coupon['action'] as $action) { ?>
                [ <a href="<?php echo $action['href']; ?>"><?php echo $action['text']; ?></a> ]
                <?php } ?></td>
            </tr>
            <?php } ?>
            <?php } else { ?>
            <tr>
              <td class="center" colspan="8"><?php echo $text_no_results; ?></td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
      </form>
      <div class="pagination"><?php echo $pagination; ?></div>
    </div>
  </div>
</div>
<?php echo $footer; ?>


<script type="text/javascript"><!--
function filter() {
    url = 'index.php?route=sale/coupon&token=<?php echo $token; ?>';

    var filter_name = $('input[name=\'filter_name\']').attr('value');
    if (filter_name) {
        url += '&filter_name=' + encodeURIComponent(filter_name);
    }

    var filter_code = $('input[name=\'filter_code\']').attr('value');
    if (filter_code) {
        url += '&filter_code=' + encodeURIComponent(filter_code);
    }

    var filter_discount = $('input[name=\'filter_discount\']').attr('value');
    if (filter_discount) {
        url += '&filter_discount=' + encodeURIComponent(filter_discount);
    }

    var filter_date_start = $('input[name=\'filter_date_start\']').attr('value');
    if (filter_date_start) {
        url += '&filter_date_start=' + encodeURIComponent(filter_date_start);
    }

    var filter_date_end = $('input[name=\'filter_date_end\']').attr('value');
    if (filter_date_end) {
        url += '&filter_date_end=' + encodeURIComponent(filter_date_end);
    }

    var filter_status = $('select[name=\'filter_status\']').attr('value');
    if (filter_status != '*') {
        url += '&filter_status=' + encodeURIComponent(filter_status);
    }

    location = url;
}

$(document).ready(function() {
    $('.date').datepicker({dateFormat: 'yy-mm-dd'});
});

function changeStatus(status){
    $.ajax({
        url: 'index.php?route=common/edit/changestatus&type=coupon&status='+ status +'&token=<?php echo $token; ?>',
        dataType: 'json',
        data: $("#form").serialize(),
        success: function(json) {
            if(json){
                $('.box').before('<div class="warning">'+json.warning+'</div>');
            }
            else{
                location.reload();
            }
        }
    });
}
//--></script>