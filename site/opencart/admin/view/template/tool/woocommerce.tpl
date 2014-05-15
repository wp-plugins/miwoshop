<?php echo $header; ?>
<div id="content">
	<div class="breadcrumb">
		<?php foreach ($breadcrumbs as $breadcrumb) { ?>
		<?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
		<?php } ?>
	</div>
	<div class="miwi_paid">
		<strong><?php echo MText::sprintf('MLIB_X_PRO_MEMBERS', 'Migrate'); ?></strong>
		<br /><br />
		<?php echo MText::sprintf('MLIB_PRO_MEMBERS_DESC', 'http://miwisoft.com/wordpress-plugins/miwoshop-wordpress-shopping-cart#pricing','MiwoShop'); ?>
	</div>
</div>
<?php echo $footer; ?>