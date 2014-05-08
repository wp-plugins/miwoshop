<?php echo $header; ?><?php echo $column_left; ?><?php echo $column_right; ?>
<div id="content"><?php echo $content_top; ?>
    <h2><?php echo $heading_payment; ?></h2>
        <div style="float: left" id="amazon-wallet-widget"></div>
        <div style="clear: both;"></div>
        <div class="buttons" style="margin-top: 15px">
            <a href="<?php echo $back ?>" class="button_oc left"><span><?php echo $text_back ?></span></a>
            <a class="button_oc right" id="continue-button"><span><?php echo $text_continue ?></span></a>
        </div>
        <input type="hidden" name="payment_method" value="" />
    <?php echo $content_bottom; ?>
</div>
<?php if($amazon_payment_js=="PaymentWidgets.js"){ ?>
<?php MiwoShop::get('base')->addHeader(MPATH_MIWOSHOP_OC . '/catalog/view/javascript/amazon_payment/PaymentWidgets.js', false); ?>
<?php }else { ?>
<script type="text/javascript" src="https://static-eu.payments-amazon.com/cba/js/gb/<?php echo $amazon_payment_js; ?>" />
<?php } ?>
<?php if($status=="live"){ ?>
<?php // MiwoShop::get('base')->addHeader(MPATH_MIWOSHOP_OC . '/catalog/view/javascript/amazon_payment/PaymentWidgets_core._V1373579077_.js', false); ?>
<?php } else {?>
<?php MiwoShop::get('base')->addHeader(MPATH_MIWOSHOP_OC . '/catalog/view/javascript/amazon_payment/PaymentWidgets_core._V1373579082_.js', false); ?>
<?php } ?>

<script type="text/javascript"><!--
    $(document).ready(function(){
        
        $('#continue-button').click(function(){
            $('div.warning').remove();
            
            if ($("input[name='payment_method']").val() == '1') {
                location = '<?php echo $continue ?>';
            } else {
                $('#amazon-wallet-widget').before('<div class="warning"><?php echo $error_payment_method ?></div>');
            }
        });
        
        new CBA.Widgets.WalletWidget({
            merchantId: '<?php echo $merchant_id ?>',
            displayMode: 'edit',
            onPaymentSelect: function(widget){
                $("input[name='payment_method']").val('1');
            }
            
        }).render('amazon-wallet-widget');
        
    });
//--></script>
<?php echo $footer; ?>