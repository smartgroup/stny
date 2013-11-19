<?php
if (!defined('IN_CONTEXT')) die('access violation error!');
?>
<script type="text/javascript" language="javascript">
<!--
function on_success(response) {
    var o_result = _eval_json(response);
    if (!o_result) {
        return on_failure(response);
    }
    
    var stat = document.getElementById("adminedtusrform_stat");
    if (o_result.result == "ERROR") {
        document.forms["adminedtusrform"].reset();
        
        stat.innerHTML = o_result.errmsg;
        return false;
    } else if (o_result.result == "OK") {
        if (o_result.selfpwd) {
            parent_goto_d(o_result.forward);
        } else {
	        stat.innerHTML = "<?php _e('OK, redirecting...'); ?>";
	        parent.window.location.reload();
//	        window.location.href = o_result.forward;
        }
    } else {
        return on_failure(response);
    }
}

function on_failure(response) {
    document.forms["adminedtusrform"].reset();
    
    document.getElementById("adminedtusrform_stat").innerHTML = "<?php _e('Request failed!'); ?>";
    return false;
}

function backPrv(){
	window.location.href="index.php?_m=mod_user&_a=admin_list";	
}
//-->
</script>
<span id="adminedtusrform_stat" class="status" style="display:none;"></span>
<?php
$admin_edtusr_form = new Form('index.php', 'adminedtusrform', 'check_prof_info');
$admin_edtusr_form->p_open('mod_user', 'admin_update', '_ajax');
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="form_table" style="line-height:24px;">
	<tfoot>
        <tr>
            <td colspan="2">
            <?php
            echo Html::input('reset', 'reset', __('Reset'));
            echo Html::input('button', 'cancel', __('Cancel'), 'onclick="backPrv();"');
            echo Html::input('submit', 'submit', __('Save'));
            echo Html::input('hidden', 'user[id]', $curr_user->id);
            ?>
            </td>
        </tr>
    </tfoot>
    <tbody>
        <tr>
            <td class="label"><?php _e('Login Name'); ?></td>
            <td class="entry"><?php echo $curr_user->login; ?></td>
        </tr>
	<?php if($ismyself ||$issuperadmin){	 ?>
        <tr>
            <td class="label"><?php _e('Password'); ?></td>
            <td class="entry">
            <?php
            echo Html::input('password', 'passwd[passwd]', '', 'class="textinput"');
            ?>
            </td>
        </tr>
        <tr>
            <td class="label"><?php _e('Confirm Password'); ?></td>
            <td class="entry">
            <?php
            echo Html::input('password', 'passwd[re_passwd]', '', 'class="textinput"');
            ?>
            </td>
        </tr>
	<?php } ?>
        <tr>
            <td class="label"><?php _e('E-mail'); ?></td>
            <td class="entry">
            <?php
            echo Html::input('text', 'user[email]', $curr_user->email, 
                'class="textinput"', $admin_edtusr_form, 'RequiredTextbox', 
                __('Please input e-mail address!'));
            ?>
            </td>
        </tr>
        <tr>
            <td class="label"><?php _e('Name'); ?></td>
            <td class="entry">
            <?php
            echo Html::input('text', 'user[full_name]', $curr_user->full_name, 'class="textinput"');
            ?>
            </td>
        </tr>
		 <tr>
            <td class="label"><?php _e('Phone'); ?></td>
            <td class="entry">
            <?php
            echo Html::input('text', 'user[mobile]', $curr_user->mobile, 'class="textinput"');
            ?>
            </td>
        </tr>
	 <?php  if($issuperadmin&&!$ismyself){ ?>
        <tr>
            <td class="label"><?php _e('Active'); ?></td>
            <td class="entry">
            <?php
            echo Html::input('checkbox', 'user[active]', '1', 
				Toolkit::switchText($curr_user->active, array('0' => '', '1' => 'checked="checked"')));
            ?>
            </td>
        </tr>
	 <?php } ?>
	  <?php  if($issuperadmin){ ?>
        <tr>
            <td class="label"><?php _e('Role'); ?></td>
            <td class="entry">
            <?php
			if($curr_user->s_role == '{admin}') {
					echo Html::select('user[s_role]', 
									array('admin'=>__('Admin')), 
									str_replace(array('{', '}'), array('', ''), $curr_user->s_role), 'class="textselect"');
			} else{
				if(!Toolkit::isSiteStarAuthorized()){				
					 echo Html::select('user[s_role]',  array( 'member'=>__('Member')),str_replace(array('{', '}'), array('', ''), $curr_user->s_role), 'class="textselect"');
				} else {
						echo Html::select('user[s_role]', 
										Toolkit::toSelectArray($roles, 'name', 'desc', array(), true), 
										str_replace(array('{', '}'), array('', ''), $curr_user->s_role), 'class="textselect"');
					}
			}
            ?>
            </td>
        </tr>
	<?php } ?>
    </tbody>
</table>
<?php
$admin_edtusr_form->close();
if($ismyself ||$issuperadmin){
$admin_edtusr_form->genCompareValidate('passwd[passwd]', 'passwd[re_passwd]', 
    '=', __('Passwords mismatch!'));
}
$running_msg = __('Saving profile...');
$custom_js = <<<JS
$("#adminedtusrform_stat").css({"display":"block"});
$("#adminedtusrform_stat").html("$running_msg");
_ajax_submit(thisForm, on_success, on_failure);
return false;

JS;
$admin_edtusr_form->addCustValidationJs($custom_js);
$admin_edtusr_form->writeValidateJs();
?>
