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
    
    var stat = document.getElementById("adminaddusrform_stat");
    if (o_result.result == "ERROR") {       
        stat.innerHTML = o_result.errmsg;
        document.forms["adminaddusrform"].reset();
        return false;
    } else if (o_result.result == "OK") {
        stat.innerHTML = "<?php _e('OK, redirecting...'); ?>";
//        window.location.href = o_result.forward;
		  parent.window.location.reload();
    } else {
        return on_failure(response);
    }
}

function on_failure(response) {
    document.forms["adminaddusrform"].reset();
    
    document.getElementById("adminaddusrform_stat").innerHTML = "<?php _e('Request failed!'); ?>";
    return false;
}

function check_login_name() {
    var login_name = document.getElementById("user_login_").value;
    _ajax_request("mod_user", "chk_login_name", {login: login_name}, 
        on_chk_login_success, on_chk_login_failure)
}

function on_chk_login_success(response) {
    var o_result = _eval_json(response);
    if (!o_result) {
        return on_chk_login_failure(response);
    }
    
    var chk_rs = document.getElementById("chk_login_rs");
    if (o_result.result == "OK") {
        chk_rs.innerHTML = o_result.msg;
    } else {
        chk_rs.innerHTML = o_result.errmsg;;
    }
}

function on_chk_login_failure(response) {
    var chk_rs = document.getElementById("chk_login_rs");
    chk_rs.innerHTML = "<?php _e('Check failed!'); ?>";
}

function backPrv(){
	window.location.href="index.php?_m=mod_user&_a=admin_list";	
}
//-->
</script>
<span id="adminaddusrform_stat" class="status" style="display:none;"></span>
<?php
$admin_addusr_form = new Form('index.php', 'adminaddusrform', 'check_reg_info');
$admin_addusr_form->p_open('mod_user', 'admin_create', '_ajax');
?>
<table width="100%" border="0" cellspacing="0" class="form_table" cellpadding="0" style="line-height:24px;">
    <tfoot>
        <tr>
            <td colspan="2">
            <?php
            echo Html::input('button', 'cancel', __('Cancel'), 'onclick="backPrv()"');
            echo Html::input('reset', 'reset', __('Reset'));
            echo Html::input('submit', 'submit', __('Create'));
            ?>
            </td>
        </tr>
    </tfoot>
    <tbody>
        <tr>
            <td class="label"><?php _e('Login Name'); ?></td>
            <td class="entry">
            <?php
            echo Html::input('text', 'user[login]', '', 
                'class="textinput"', $admin_addusr_form, 'RequiredTextbox', 
                __('Please input login name!'));
            ?>
            <a href="#" onclick="check_login_name();return false;"><?php _e('Check'); ?></a>
            <span id="chk_login_rs"></span>
            </td>
        </tr>
        <tr>
            <td class="label"><?php _e('Password'); ?></td>
            <td class="entry">
            <?php
            echo Html::input('password', 'user[passwd]', '', 
                'class="textinput"', $admin_addusr_form, 'RequiredTextbox', 
                __('Please input password!'));
            ?>
            </td>
        </tr>
        <tr>
            <td class="label"><?php _e('Confirm Password'); ?></td>
            <td class="entry">
            <?php
            echo Html::input('password', 'user[re_passwd]', '', 
                'class="textinput"', $admin_addusr_form, 'RequiredTextbox', 
                __('Please retype your password for confirmation!'));
            ?>
            </td>
        </tr>
        <tr>
            <td class="label"><?php _e('E-mail'); ?></td>
            <td class="entry">
            <?php
            echo Html::input('text', 'user[email]', '', 
                'class="textinput"', $admin_addusr_form, 'RequiredTextbox', 
                __('Please input e-mail address!'));
            ?>
            </td>
        </tr>
        <tr>
            <td class="label"><?php _e('Name'); ?></td>
            <td class="entry">
            <?php
            echo Html::input('text', 'user[full_name]', '', 'class="textinput"');
            ?>
            </td>
        </tr>
		 <tr>
            <td class="label"><?php _e('Phone'); ?></td>
            <td class="entry">
            <?php
            echo Html::input('text', 'user[mobile]', '', 'class="textinput"');
            ?>
            </td>
        </tr>
        <tr>
            <td class="label"><?php _e('Active'); ?></td>
            <td class="entry">
            <?php
            echo Html::input('checkbox', 'user[active]', '1', 'checked="checked"');
            ?>
            </td>
        </tr>
        <tr>
            <td class="label"><?php _e('Role'); ?></td>
            <td class="entry">
            <?php
		if(!Toolkit::isSiteStarAuthorized()){				
            echo Html::select('user[s_role]', 
               array( 'member'=>__('Member')), 'member', 'class="textselect"');
		}else{
		  echo Html::select('user[s_role]', 
                Toolkit::toSelectArray($roles, 'name', 'desc', array(), true), 'member', 'class="textselect"');
		}
            ?>
            </td>
        </tr>
    </tbody>
</table>
<?php
$admin_addusr_form->close();
$admin_addusr_form->genCompareValidate('user[passwd]', 'user[re_passwd]', 
    '=', __('Passwords mismatch!'));
$running_msg = __('Creating user...');
$custom_js = <<<JS
$("#adminaddusrform_stat").css({"display":"block"});
$("#adminaddusrform_stat").html("$running_msg");
_ajax_submit(thisForm, on_success, on_failure);
return false;

JS;
$admin_addusr_form->addCustValidationJs($custom_js);
$admin_addusr_form->writeValidateJs();
?>
