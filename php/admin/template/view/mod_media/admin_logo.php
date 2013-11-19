<?php
if (!defined('IN_CONTEXT')) die('access violation error!');
?>
<div class="status_bar">
	<span id="adminsinfofrm_stat" class="status" style="display:none;"></span>
</div>
<?php
$sinfo_form = new Form('index.php', 'sinfoform', 'check_sinfo_info');
$sinfo_form->setEncType('multipart/form-data');
$sinfo_form->p_open('mod_media', 'save_logo');
?>
<div style="overflow:auto;width:100%;">
<table id="sinfoform_table" class="form_table" width="100%" border="0" cellspacing="0" cellpadding="2" style="line-height:24px;">
	<tfoot>
		<tr>
            <td colspan="2">
            <?php
			$curr_siteinfo_id='';
			if(isset($curr_siteinfo->id)){
				$curr_siteinfo_id=$curr_siteinfo->id;
			}
            echo Html::input('reset', 'reset', __('Reset'), 'onclick="if(!confirm(\''.__('Do you want to reset ?').'\')){return false;}"');
            echo Html::input('submit', 'submit', __('Save'));
            echo Html::input('hidden', 'si[id]', $curr_siteinfo_id);
            echo Html::input('hidden', 'si[s_locale]', $lang_sw);
            ?>
            </td>
        </tr>
	</tfoot>
	<tbody>
		<?php 
			echo Html::input('hidden', 'logo[id]', $curr_logo->id);
            echo Html::input('hidden', 'param[logo_img]', $p_logo['img_src']);
		?>
		<tr>
			<td class="label"><?php _e('Logo'); ?></td>
			<td class="entry">
			<?php 
			/*$logo_message1 = simplexml_load_file('SitestarMaker/SitestarMaker.xml');
			if($logo_message1->output->custom == 'yes')
			{
				echo "<img src='{$logo_message1->output->file_name}'/><br />";
			}
			else{*/
			if($p_logo['img_src']){
			?>
			<img src="../<?php echo $p_logo['img_src']?>" ><br />
			<?php }?>
            <?php
            echo Html::input('file', 'logo_file', '', 
                '', $mod_form);
            ?>
			<BR />
			<?php _e('Supported file format'); ?>:<?php echo PIC_ALLOW_EXT;?>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<BR />
			<?php _e('Upload size limit'); ?>:<?php echo ini_get('upload_max_filesize');?>
            </td>
		</tr>
		<tr>
			<td class="label"><?php _e('Size'); ?></td>
            <td class="entry">
            <?php
            echo Html::input('text', 'param[logo_width]', $p_logo['img_width'], 
                'class="textinput" style="width:40px;"', $mod_form);
            ?>
            &times;
            <?php
            echo Html::input('text', 'param[logo_height]', $p_logo['img_height'], 
                'class="textinput" style="width:40px;"', $mod_form);
            ?>
            </td>
		</tr>
	</tbody>
</table>
</div>
<?php
$sinfo_form->close();
$sinfo_form->writeValidateJs();
?>