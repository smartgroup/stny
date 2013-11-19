<?php
if (!defined('IN_CONTEXT')) die('access violation error!');
?>
<div class="status_bar">
<?php if (Notice::get('mod_download/msg')) { ?>
	<span id="admindownfrm_stat" class="status"><?php echo Notice::get('mod_download/msg'); ?></span>
<?php } ?>
</div>
<div class="space"></div>
<?php
$download_form = new Form('index.php', 'downloadform', 'check_download_info');
$download_form->setEncType('multipart/form-data');
$download_form->p_open('mod_download', $next_action);
?>
<table id="downloadform_table" class="form_table" width="100%" border="0" cellspacing="0" cellpadding="2" style="line-height:24px;">
    <tfoot>
        <tr>
            <td colspan="2">
            <?php
            echo Html::input('button', 'cancel', __('Cancel'), 'onclick="window.history.go(-1);"');
            echo Html::input('reset', 'reset', __('Reset'));
            echo Html::input('submit', 'submit', __('Save'));
            echo Html::input('hidden', 'download[id]', '');
            ?>
            </td>
        </tr>
    </tfoot>
    <tbody>
        <tr>
            <td class="label" width="10%"><?php _e('Language'); ?></td>
            <td class="entry">
            <?php
            echo Toolkit::switchText($mod_locale, Toolkit::toSelectArray($langs, 'locale', 'name'));
            echo Html::input('hidden', 'download[s_locale]', $mod_locale);
            ?>
            </td>
        </tr>
        <tr>
            <td class="label"><?php _e('File'); ?></td>
            <td class="entry">
            <?php
            echo Html::input('file', 'download_file', '', 
                '', $download_form, 'RequiredTextbox', 
                __('Please select a download file to upload!'));echo "&nbsp;&nbsp;&nbsp;&nbsp;";
            ?>
			<BR />
			<?php _e('Supported file format'); ?>:<?php echo FILE_ALLOW_EXT;?>
			<BR />
			<?php _e('Upload size limit'); ?>:<?php echo ini_get('upload_max_filesize');?>
            </td>
        </tr>
        <tr>
            <td class="label"><?php _e('Description'); ?></td>
            <td class="entry">
            <?php
            echo Html::textarea('download[description]', '', 
                'rows="8" cols="76" class="textinput" style="width:450px;"', $download_form, 'RequiredTextbox', 
                __('Please input description!'));
            ?>
            </td>
        </tr>
        <tr>
            <td class="label"></td>
            <td class="entry">
            <?php
            echo Html::input('checkbox', 'ismemonly', '1');
            ?>
            &nbsp;<?php _e('Member only access'); ?>
            </td>
        </tr>
    </tbody>
</table>
<?php
$download_form->close();
$download_form->writeValidateJs();
?>