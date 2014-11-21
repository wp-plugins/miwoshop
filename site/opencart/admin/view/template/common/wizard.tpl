<style type="text/css">
    #content {
        background: none !important;
        padding: 10px 0 128px !important;
    }

    #content form {
        margin-left: 20px !important;
    }

    #content fieldset {
        margin-bottom: 20px !important;
    }

    .skip{
        float: right;
        margin-top: 10px;
    }

    .wizard_step{
        padding: 10px;
    }

    .wizard_step_content table td {
        padding: 5px;
    }

    .wizard_step_content table td input, textarea, select {
        margin-bottom: inherit !important;
        width: 240px !important;
    }

    .wizard_bottom{
        padding: 20px 0;
        text-align: center;
    }

    .row {
        margin-left: 0 !important;
    }

    .btn-group button {
        width: 50px !important;
    }

    <?php if(!MiwoShop::get(base)->is30()) { ?>

    .btn {
        -moz-border-bottom-colors: none;
        -moz-border-left-colors: none;
        -moz-border-right-colors: none;
        -moz-border-top-colors: none;
        background-color: #f5f5f5;
        background-image: linear-gradient(to bottom, #fff, #e6e6e6);
        background-repeat: repeat-x;
        border-color: #bbb #bbb #a2a2a2;
        border-image: none;
        border-style: solid;
        border-width: 1px;
        box-shadow: 0 1px 0 rgba(255, 255, 255, 0.2) inset, 0 1px 2px rgba(0, 0, 0, 0.05);
        color: #333;
        cursor: pointer;
        display: inline-block;
        font-size: 13px;
        line-height: 18px;
        margin: 0 !important;
        padding: 4px 12px;
        text-align: center;
        text-shadow: 0 1px 1px rgba(255, 255, 255, 0.75);
        vertical-align: middle;
    }
    .btn:hover, .btn:focus, .btn:active, .btn.active, .btn.disabled, .btn[disabled] {
        background-color: #e6e6e6;
        color: #333;
    }
    .btn:active, .btn.active {
    }
    .btn:first-child {
    }
    .btn:hover, .btn:focus {
        background-position: 0 -15px;
        color: #333;
        text-decoration: none;
        transition: background-position 0.1s linear 0s;
    }
    .btn:focus {
        outline: thin dotted #333;
        outline-offset: -2px;
    }
    .btn.active, .btn:active {
        background-image: none;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.15) inset, 0 1px 2px rgba(0, 0, 0, 0.05);
        outline: 0 none;
    }
    .btn.disabled, .btn[disabled] {
        background-image: none;
        box-shadow: none;
        cursor: default;
        opacity: 0.65;
    }
    .btn-large {
        font-size: 16.25px;
        padding: 11px 19px;
    }
    .btn-large [class^="icon-"], .btn-large [class*=" icon-"] {
        margin-top: 4px;
    }
    .btn-small {
        font-size: 12px;
        padding: 2px 10px;
    }
    .btn-small [class^="icon-"], .btn-small [class*=" icon-"] {
        margin-top: 0;
    }
    .btn-mini [class^="icon-"], .btn-mini [class*=" icon-"] {
        margin-top: -1px;
    }
    .btn-mini {
        font-size: 9.75px;
        padding: 0 6px;
    }
    .btn-block {
        box-sizing: border-box;
        display: block;
        padding-left: 0;
        padding-right: 0;
        width: 100%;
    }
    .btn-block + .btn-block {
        margin-top: 5px;
    }
    input.btn-block[type="submit"], input.btn-block[type="reset"], input.btn-block[type="button"] {
        width: 100%;
    }
    .button-primary.active, .btn-warning.active, .btn-danger.active, .btn-success.active, .btn-info.active, .btn-inverse.active {
        color: rgba(255, 255, 255, 0.75);
    }
    .button-primary {
        background-color: #1d6cb0;
        background-image: linear-gradient(to bottom, #2384d3, #15497c);
        background-repeat: repeat-x;
        border-color: #15497c #15497c #0a223b;
        color: #fff;
        text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);
    }
    .button-primary:hover, .button-primary:focus, .button-primary:active, .button-primary.active, .button-primary.disabled, .button-primary[disabled] {
        background-color: #15497c;
        color: #fff;
    }
    .button-primary:active, .button-primary.active {
    }
    .btn-warning {
        background-color: #faa732;
        background-image: linear-gradient(to bottom, #fbb450, #f89406);
        background-repeat: repeat-x;
        border-color: #f89406 #f89406 #ad6704;
        color: #fff;
        text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);
    }
    .btn-warning:hover, .btn-warning:focus, .btn-warning:active, .btn-warning.active, .btn-warning.disabled, .btn-warning[disabled] {
        background-color: #f89406;
        color: #fff;
    }
    .btn-warning:active, .btn-warning.active {
    }
    .btn-danger {
        background-color: #da4f49;
        background-image: linear-gradient(to bottom, #ee5f5b, #bd362f);
        background-repeat: repeat-x;
        border-color: #bd362f #bd362f #802420;
        color: #fff;
        text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);
    }
    .btn-danger:hover, .btn-danger:focus, .btn-danger:active, .btn-danger.active, .btn-danger.disabled, .btn-danger[disabled] {
        background-color: #bd362f;
        color: #fff;
    }
    .btn-danger:active, .btn-danger.active {
    }
    .btn-success {
        background-color: #5bb75b;
        background-image: linear-gradient(to bottom, #62c462, #51a351);
        background-repeat: repeat-x;
        border-color: #51a351 #51a351 #387038;
        color: #fff;
        text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);
    }
    .btn-success:hover, .btn-success:focus, .btn-success:active, .btn-success.active, .btn-success.disabled, .btn-success[disabled] {
        background-color: #51a351;
        color: #fff;
    }
    .btn-success:active, .btn-success.active {
    }
    .btn-info {
        background-color: #49afcd;
        background-image: linear-gradient(to bottom, #5bc0de, #2f96b4);
        background-repeat: repeat-x;
        border-color: #2f96b4 #2f96b4 #1f6377;
        color: #fff;
        text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);
    }
    .btn-info:hover, .btn-info:focus, .btn-info:active, .btn-info.active, .btn-info.disabled, .btn-info[disabled] {
        background-color: #2f96b4;
        color: #fff;
    }
    .btn-info:active, .btn-info.active {
    }
    .btn-inverse {
        background-color: #363636;
        background-image: linear-gradient(to bottom, #444, #222);
        background-repeat: repeat-x;
        border-color: #222 #222 #000000;
        color: #fff;
        text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);
    }
    .btn-inverse:hover, .btn-inverse:focus, .btn-inverse:active, .btn-inverse.active, .btn-inverse.disabled, .btn-inverse[disabled] {
        background-color: #222;
        color: #fff;
    }

    .btn-group {
        display: inline-block;
        font-size: 0;
        position: relative;
        vertical-align: middle;
        white-space: nowrap;
    }
    .btn-group:first-child {
    }
    .btn-group + .btn-group {
        margin-left: 5px;
    }
    <?php } ?>

</style>
<div id="content">
    <div class="success"><?php echo $text_message; ?></div>

    <div class="box">
        <div class="heading">
            <h1><img src="view/image/wizard.png" alt="" /> <?php echo $heading_title; ?></h1>
            <a class="btn btn-small modal skip" href="<?php echo $link_skip; ?>"><?php echo $text_skip; ?></a>
        </div>
        <div class="content">
            <form action="<?php echo $link_action; ?>" method="post">
                <fieldset class="wizard_step">
                    <legend><?php echo $text_step_1; ?></legend>
                    <div class="wizard_step_content">
                        <table>
                            <tr>
                                <td style="width: 200px"><?php echo $text_personal_id; ?></td>
                                <td><input type="password" name="pid" value="" readonly="true" /></td>
                            </tr>
                        </table>
                    </div>
                </fieldset>
                <fieldset class="wizard_step">
                    <legend><?php echo $text_step_2; ?></legend>
                    <div class="wizard_step_content">
                        <table>
                            <tr>
                                <td style="width: 200px"><?php echo $text_logo; ?></td>
                                <td>
                                    <div class="image"><img src="<?php echo $logo; ?>" alt="" id="thumb-logo" />
                                        <input type="hidden" name="logo" value="" id="logo" />
                                        <br />
                                        <a onclick="image_upload('logo', 'thumb-logo');"><?php echo $text_browse; ?></a>
                                        &nbsp;&nbsp;|&nbsp;&nbsp;
                                        <a onclick="jQuery('#thumb-logo').attr('src', '<?php echo $no_image; ?>'); jQuery('#logo').attr('value', '');"><?php echo $text_clear; ?></a>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo $text_name; ?></td>
                                <td><input type="text" name="name" /></td>
                            </tr>                        <tr>
                                <td><?php echo $text_mail; ?></td>
                                <td><input type="text" name="mail" /></td>
                            </tr>                        <tr>
                                <td><?php echo $text_telephone; ?></td>
                                <td><input type="text" name="telephone" /></td>
                            </tr>                        <tr>
                                <td><?php echo $text_address; ?></td>
                                <td><textarea name="address" ></textarea></td>
                            </tr>
                        </table>
                    </div>
                </fieldset>
                <fieldset class="wizard_step">
                    <legend><?php echo $text_step_3; ?></legend>
                    <div class="wizard_step_content">
                        <table>
                            <tr>
                                <td style="width: 200px"><?php echo $text_country; ?></td>
                                <td>
                                    <select style="width: 250px !important;" name="country_id">
                                    <?php foreach ($countries as $country) { ?>
                                        <?php if ($country['country_id'] == $country_id) { ?>
                                        <option value="<?php echo $country['country_id']; ?>" selected="selected"><?php echo $country['name']; ?></option>
                                        <?php } else { ?>
                                        <option value="<?php echo $country['country_id']; ?>"><?php echo $country['name']; ?></option>
                                        <?php } ?>
                                    <?php } ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo $text_zone; ?></td>
                                <td>
                                    <select style="width: 250px !important;" name="zone_id"></select>
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo $text_currency; ?></td>
                                <td>
                                    <select style="width: 250px !important;" name="currency">
                                    <?php foreach ($currencies as $currency) { ?>
                                        <?php if ($currency['code'] == $config_currency) { ?>
                                        <option value="<?php echo $currency['code']; ?>" selected="selected"><?php echo $currency['title']; ?></option>
                                        <?php } else { ?>
                                        <option value="<?php echo $currency['code']; ?>"><?php echo $currency['title']; ?></option>
                                        <?php } ?>
                                    <?php } ?>
                                    </select>
                                </td>
                            </tr>
                        </table>
                    </div>
                </fieldset>
                <fieldset class="wizard_step">
                    <legend><?php echo $text_step_4; ?></legend>
                    <div class="wizard_step_content">
                        <table>
                            <tr>
                                <td style="width: 200px"><?php echo $text_product_display; ?></td>
                                <td>
                                    <div class="row" id="radios">
                                      <div class="col-xs-12">
                                         <div class="form-group">
                                            <div class="col-md-6">
                                               <input name="miwoshop_display" type='hidden' value="0"/>
                                               <div class="btn-group" data-toggle="buttons">
                                                  <button type="button" class="btn btn-default" data-radio-name="radio" value="1"><?php echo $text_grid; ?></button>
                                                  <button type="button" class="btn btn btn-success active" data-radio-name="radio" value="0"><?php echo $text_list; ?></button>
                                               </div>
                                            </div>
                                         </div>
                                      </div>
                                   </div>
                                </td>
                            </tr>
                        </table>
                    </div>
                </fieldset>
                <?php if(!empty($lang)) { ?>
                <fieldset class="wizard_step">
                    <legend><?php echo $text_step_7; ?></legend>
                    <div class="wizard_step_content">
                        <table>
                            <tr>
                                <td colspan="2"><?php echo $text_language_info; ?></td>
                            </tr>
                        </table>
                    </div>
                </fieldset>
                <?php } ?>
                <?php if(!empty($mig_coms)) { ?>
                <fieldset  class="wizard_step">
                    <legend><?php echo $text_step_6; ?></legend>
                    <div class="wizard_step_content">
                        <table>
                            <tr>
                                <td style="width: 200px"><?php echo $text_migration; ?></td>
                                <td>
                                    <select style="width: 250px !important;" name="migration">
                                        <option value="0"><?php echo $text_select; ?></option>
                                        <?php foreach ($mig_coms as $mig_com) { ?>
                                        <option value="<?php echo $mig_com['link']; ?>"><?php echo $mig_com['name']; ?></option>
                                        <?php } ?>
                                    </select>
                                </td>
                            </tr>
                        </table>
                    </div>
                </fieldset>
                <?php } ?>
                <div class="wizard_bottom">
                    <input type="hidden" id="redirect" name="redirect" value="<?php echo $link_new_product; ?>" />
                    <button type="submit" id="btn-save" class="btn btn-large btn-success" ><?php echo $text_save_and_new_product; ?></button>
                </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript"><!--
function image_upload(field, thumb) {
	jQuery('#dialog').remove();

	jQuery('#content').prepend('<div id="dialog" style="padding: 3px 0px 0px 0px;"><iframe src="index.php?route=common/filemanager&token=<?php echo $token; ?>&field=' + encodeURIComponent(field) + '" style="padding:0; margin: 0; display: block; width: 100%; height: 100%;" frameborder="no" scrolling="auto"></iframe></div>');

	jQuery('#dialog').dialog({
		title: '<?php echo $text_image_manager; ?>',
		close: function (event, ui) {
			if (jQuery('#' + field).attr('value')) {
				jQuery.ajax({
					url: 'index.php?route=common/filemanager/image&token=<?php echo $token; ?>&image=' + encodeURIComponent(jQuery('#' + field).val()),
					dataType: 'text',
					success: function(data) {
						jQuery('#' + thumb).replaceWith('<img src="' + data + '" alt="" id="' + thumb + '" />');
					}
				});
			}
		},
		bgiframe: false,
		width: 800,
		height: 400,
		resizable: false,
		modal: false
	});
};
//--></script>

<script type="text/javascript"><!--
jQuery('select[name=\'country_id\']').bind('change', function() {
	jQuery.ajax({
		url: 'index.php?route=setting/store/country&token=<?php echo $token; ?>&country_id=' + this.value,
		dataType: 'json',
		beforeSend: function() {
			jQuery('select[name=\'country_id\']').after('<span class="wait">&nbsp;<img src="view/image/loading.gif" alt="" /></span>');
		},
		complete: function() {
			jQuery('.wait').remove();
		},
		success: function(json) {
			if (json['postcode_required'] == '1') {
				jQuery('#postcode-required').show();
			} else {
				jQuery('#postcode-required').hide();
			}

			html = '<option value=""><?php echo $text_select; ?></option>';

			if (json['zone'] != '') {
				for (i = 0; i < json['zone'].length; i++) {
        			html += '<option value="' + json['zone'][i]['zone_id'] + '"';

					if (json['zone'][i]['zone_id'] == '<?php echo $zone_id; ?>') {
	      				html += ' selected="selected"';
	    			}

	    			html += '>' + json['zone'][i]['name'] + '</option>';
				}
			} else {
				html += '<option value="0" selected="selected"><?php echo $text_none; ?></option>';
			}

			jQuery('select[name=\'zone_id\']').html(html);
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
});

jQuery('select[name=\'country_id\']').trigger('change');

jQuery('select[name=\'migration\']').bind('change', function() {
    if(this.value == 0) {
        jQuery('#btn-save').text('<?php echo $text_save_and_new_product; ?>');
        jQuery('#redirect').attr('value', '<?php echo $link_new_product; ?>');
    } else {
        jQuery('#btn-save').text('<?php echo $text_save_and_migration; ?>');
        jQuery('#redirect').attr('value', this.value);
    }
});
//--></script>

<script type="text/javascript">
    jQuery('.btn[data-radio-name="radio"]').click(function() {
        jQuery('.btn[data-radio-name="'+jQuery(this).data('radioName')+'"]').removeClass('btn-success');
        jQuery('.btn[data-radio-name="'+jQuery(this).data('radioName')+'"]').removeClass('active');
        jQuery(this).addClass('btn-success')

        jQuery('input[name="miwoshop_display"]').val( jQuery(this).val());
    });

    jQuery('.btn[data-radio-name="radio-menu"]').click(function() {
        jQuery('.btn[data-radio-name="'+jQuery(this).data('radioName')+'"]').removeClass('btn-danger');
        jQuery('.btn[data-radio-name="'+jQuery(this).data('radioName')+'"]').removeClass('btn-success');
        jQuery('.btn[data-radio-name="'+jQuery(this).data('radioName')+'"]').removeClass('active');

        if(jQuery(this).val() == 0){
            jQuery(this).addClass('btn-danger');
        }
        else{
            jQuery(this).addClass('btn-success');
        }

        jQuery('input[name="home_menu"]').val( jQuery(this).val());
    });


</script>