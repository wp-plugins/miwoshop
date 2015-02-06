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
		<div class="left"></div>
		<div class="right"></div>
		<div class="heading">
			<h1><img src="view/image/backup.png" alt="" />DB Migration</h1>
			<div class="buttons">
				<a onClick="migrateDatabase();" class="button_oc"><span>Migrate Database</span></a>
				<a onClick="backupMedia();" class="button_oc"><span>Backup Media</span></a>
				<a href="index.php?option=com_mijoshop&route=common/dbfix/backup&format=raw&tmpl=component" target="_blank" class="button_oc"><span>DB Dump</span></a>
			</div>
	  </div>
	  <div class="content">
			<h2>Just use this tool before upgrade to v3.0, otherwise it will brake your site.</h2>
			<div id="migrateDatabase"></div>
		</div>
	</div>
</div>
<?php echo $footer; ?>
<script type="text/javascript">
<!--
function migrateDatabase() {
    document.getElementById('migrateDatabase').innerHTML = '<span style="color:green;">Loading...</span>';
    jQuery('#migrateDatabase').load('<?php echo $link; ?>');
}
function backupMedia() {
    document.getElementById('migrateDatabase').innerHTML = '<span style="color:green;">Loading...</span>';
    jQuery('#migrateDatabase').load('<?php echo $link2; ?>');
}
-->
</script>