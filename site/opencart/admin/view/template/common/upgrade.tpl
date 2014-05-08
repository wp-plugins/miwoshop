<?php echo $header; ?>
<div id="content">
    <div class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
        <?php } ?>
    </div>
    <?php if ($text_error) { ?>
    <div class="warning"><?php echo $text_error; ?></div>
    <?php } else if($text_success) {  ?>
    <div class="success"><?php echo $text_success; ?></div>
    <?php } ?>
    <div class="box">
        <div class="heading">
            <h1><img src="view/image/upgrade.png" alt="" /> <?php echo $heading_title; ?></h1>
        </div>
        <div class="content">
            <script type="text/javascript">
                Miwi.submitbutton = function(pressbutton) {
                    var form = document.getElementById('upgradeFromUpload');

                    // do field validation
                    if (form.install_package.value == ""){
                        alert("<?php echo MText::_('No file selected', true); ?>");
                    }
                    else {
                        form.submit();
                    }
                }
            </script>
            <fieldset class="adminform">
                <legend><?php echo MText::_('COM_MIWOSHOP_UPGRADE_VERSION_INFO'); ?></legend>
                <table class="adminform">
                    <tr>
                        <th>
                            <?php echo MText::_('COM_MIWOSHOP_INSTALLED_VERSION'); ?> : <?php echo Miwoshop::get('base')->getMiwoshopVersion();?>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <?php echo MText::_('COM_MIWOSHOP_LATEST_VERSION'); ?> : <?php echo Miwoshop::get('base')->getLatestMiwoshopVersion();?>
                        </th>
                    </tr>
                </table>
            </fieldset>
            <br/><br/>
            <div id="tabs" class="htabs"><a href="#tab-automatic"><?php echo MText::_('COM_MIWOSHOP_UPGRADE_FROM_SERVER'); ?></a><a href="#tab-manual"><?php echo MText::_('COM_MIWOSHOP_UPGRADE_FROM_FILE'); ?></a></div>
            <div id="tab-automatic">
                <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="upgradeFromServer">
                    <table class="form">
                        <tr>
                            <td><?php if (!isset($text_auto_btn)) { ?>
                                    <b><font color="red"><?php echo $error_personal_id; ?></font></b>
                                <?php } else { ?>
                                    <input class="button btn button-primary" type="button" value="<?php echo $text_auto_btn; ?>" onclick="form.submit()"/>
                                <?php } ?>
                            </td>
                            <input type="hidden" name="option" value="com_miwoshop" />
                            <!--<input type="hidden" name="route" value="upgrade/upgrade" />-->
                            <input type="hidden" name="task" value="upgrade" />
                            <input type="hidden" name="type" value="server" />
                            <input type="hidden" name="<?php echo $token; ?>" value="1" />
                            <?php //echo MHtml::_('form.token'); ?>
                        </tr>
                    </table>
                </form>
            </div>
            <div id="tab-manual">
                <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="upgradeFromUpload">
                    <table class="form">
                        <tr>
                            <td><?php echo $text_upload_pkg; ?></td>
                            <td><input class="input_box" id="install_package" name="install_package" type="file" size="57" /></td>
                        </tr>
                        <tr>
                            <td><input class="button btn button-primary" type="button" value="<?php echo $text_upload_upgrade; ?>" onclick="Miwi.submitbutton()" /></td>
                        </tr>
                        <input type="hidden" name="option" value="com_miwoshop" />
                        <!--<input type="hidden" name="route" value="upgrade/upgrade" />-->
                        <input type="hidden" name="task" value="upgrade" />
                        <input type="hidden" name="type" value="upload" />
                        <input type="hidden" name="<?php echo $token; ?>" value="1" />
                        <?php //echo MHtml::_('form.token'); ?>
                    </table>
                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript"><!--
    $('#tabs a').tabs();
//--></script>

