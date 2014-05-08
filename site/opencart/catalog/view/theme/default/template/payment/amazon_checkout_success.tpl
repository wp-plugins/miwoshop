<?php echo $header; ?><?php echo $column_left; ?><?php echo $column_right; ?>
<div id="content"><?php echo $content_top; ?>
    <h2><?php echo $heading_title; ?></h2>
    <p><?php echo $text_payment_success ?></p>
    <div id="AmazonOrderDetail"></div>
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
    new CBA.Widgets.OrderDetailsWidget ({
        merchantId: "<?php echo $merchant_id ?>",
        orderID: "<?php echo $amazon_order_id ?>"
    }).render ("AmazonOrderDetail");
//--></script>
<?php echo $footer; ?>