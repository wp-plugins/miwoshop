<?php echo $header; ?>
<?php MiwoShop::getClass('base')->addHeader(MPATH_MIWOSHOP_OC . '/admin/view/stylesheet/progress.css'); ?>
<div id="content">
	 <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <?php if ($error_warning) { ?>
  <div class="warning"><?php echo $error_warning; ?>  </div>
  <?php } ?>
  <div class="box">
    <div class="heading">
     <h1><img src="view/image/module.png" alt="" /> <?php echo $heading_title; ?></h1>
    </div>
    <div class="content">
      <form class="form-horizontal">
			
        <div class="form-group">
          <label class="col-sm-2 control-label" for="button-upload"><?php echo $entry_upload; ?> </label>
          <div class="col-sm-10">
            <a id="button-upload" class="button_oc">  <?php echo $button_upload; ?></a>
            <?php if ($error_warning) { ?>
            <a id="button-clear" class="button_oc" style="opacity:0.5;"> <?php echo $button_clear; ?></a>
            <?php } else { ?>
            <a id="button-clear" disabled="disabled" style="opacity:0.5;" class="button_oc"><?php echo $button_clear; ?></a>
            <?php } ?>
            <span style=" padding-left: 20px; "><?php echo $help_upload; ?></span></div>
        </div>
		</br>
        <div class="form-group">
          <label class="col-sm-2 control-label"><?php echo $entry_progress; ?></label>
          <div class="col-sm-10" style="padding-top: 6px;">
            <div class="progress">
              <div id="progress-bar" class="progress-bar" style="width: 0%;"></div>
            </div>
            <div id="progress-text"></div>
          </div>
        </div>
		<label class="col-sm-2 control-label"><?php echo $entry_overwrite; ?></label><br /><br />
        <div class="form-group">
          
          <div class="col-sm-10">
            <textarea rows="10" style="width:100% !important;" readonly="readonly" id="overwrite" class="form-control"></textarea>
            <br /><br />
            <a id="button-continue" class="button_oc" style="opacity:0.5;" disabled="disabled"><?php echo $button_continue; ?></a>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
<script type="text/javascript"><!--
var step = new Array();
var total = 0;

$('#button-upload').on('click', function() {
	$('#form-upload').remove();
	
	$('body').prepend('<form enctype="multipart/form-data" id="form-upload" style="display: none;"><input type="file" name="file" /></form>');

	$('#form-upload input[name=\'file\']').trigger('click');

	$('#form-upload input[name=\'file\']').on('change', function() {
		// Reset everything
		$('.alert').remove();
		$('#progress-bar').css('width', '0%');
		$('#progress-bar').removeClass('progress-bar-danger progress-bar-success');		
		$('#progress-text').html('');
	
		$.ajax({
			url: 'index.php?route=extension/installer/upload&token=<?php echo $token; ?>',
			type: 'post',		
			dataType: 'json',
			data: new FormData($(this).parent()[0]),
			cache: false,
			contentType: false,
			processData: false,		
			beforeSend: function() {
				$('#button-upload i').replaceWith('<i class="fa fa-spinner fa-spin"></i>');
				$('#button-upload').prop('disabled', true);
			},
			complete: function() {
				$('#button-upload i').replaceWith('<i class="fa fa-upload"></i>');
				$('#button-upload').prop('disabled', false);
			},		
			success: function(json) {
				if (json['error']) {
					$('#progress-bar').addClass('progress-bar-danger');				
					$('#progress-text').html('<div class="text-danger">' + json['error'] + '</div>');
				}
				
				if (json['step']) {
					step = json['step'];
					total = step.length;
					
					if (json['overwrite'].length) {
						html = '';
						
						for (i = 0; i < json['overwrite'].length; i++) {
							html += json['overwrite'][i] + "\n";
						}
						
						$('#overwrite').html(html);
						
						$('#button-continue').prop('disabled', false);
						$('#button-continue').css('opacity','1');
					} else {
						next();
					}	
				}
			},			
			error: function(xhr, ajaxOptions, thrownError) {
				alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			}
		});
	});
});

$('#button-continue').on('click', function() {
	next();
	
	$('#button-continue').prop('disabled', true);
	

});

function next() {
	data = step.shift();
	
	if (data) {
		$('#progress-bar').css('width', (100 - (step.length / total) * 100) + '%');
		$('#progress-text').html('<span class="text-info">' + data['text'] + '</span>');
		
		$.ajax({
			url: data.url,
			type: 'post',		
			dataType: 'json',
			data: 'path=' + data.path,
			success: function(json) {
				if (json['error']) {
					$('#progress-bar').addClass('progress-bar-danger');
					$('#progress-text').html('<div class="text-danger">' + json['error'] + '</div>');
					$('.button-clear').prop('disabled', false);
					$('.button-clear').css('opacity',1);
				} 
				
				if (json['success']) {
					$('#progress-bar').addClass('progress-bar-success');
					$('#progress-text').html('<span class="text-success">' + json['success'] + '</span>');
					$('#button-continue').css('opacity','0.5');
					$('#overwrite').html('');
				}
									
				if (!json['error'] && !json['success']) {
					next();
				}
			},
			error: function(xhr, ajaxOptions, thrownError) {
				alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			}
		});
	}
}

$('#button-clear').bind('click', function() {
	$.ajax({
		url: 'index.php?route=extension/installer/clear&token=<?php echo $token; ?>',	
		dataType: 'json',
		beforeSend: function() {
			$('#button-clear i').replaceWith('<i class="fa fa-spinner fa-spin"></i>');
			$('#button-clear').prop('disabled', true);
		},	
		complete: function() {
			$('#button-clear i').replaceWith('<i class="fa fa-eraser"></i>');
		},		
		success: function(json) {
			$('.alert').remove();
				
			if (json['error']) {
				$('.panel').before('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
			} 
		
			if (json['success']) {
				$('.panel').before('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
				
				$('#button-clear').prop('disabled', true);
			}
		},			
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
});

//--></script> 
<?php echo $footer; ?>