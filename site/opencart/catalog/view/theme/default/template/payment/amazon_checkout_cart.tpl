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

<span id="AmazonCheckoutWidgetCart"></span>
<script type="text/javascript"><!--
              
    new CBA.Widgets.InlineCheckoutWidget({
        merchantId: "<?php echo $merchant_id ?>",
        buttonSettings: {
            color: '<?php echo $button_colour ?>',
            background: '<?php echo $button_background ?>',
            size: '<?php echo $button_size ?>',
        },
        onAuthorize: function(widget) {
            var redirectUrl = '<?php echo html_entity_decode($amazon_checkout) ?>';
            if (redirectUrl.indexOf('?') == -1) {
                redirectUrl += '?contract_id=' + widget.getPurchaseContractId();
            } else {
                redirectUrl += '&contract_id=' + widget.getPurchaseContractId();
            }
                      
            window.location = redirectUrl;
        }
    }).render("AmazonCheckoutWidgetCart");
              
//--></script>