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
    
    var stat = document.getElementById("regform_stat");
    if (o_result.result == "ERROR") {
        //document.forms["regform"].reset();
        
        stat.innerHTML = o_result.errmsg;
        return false;
    } else if (o_result.result == "OK") {
		if(o_result.verify=="1"){
			stat.innerHTML = "<?php _e('verifying...'); ?>";
			alert("<?php _e('verifying...'); ?>");
			window.location.href = o_result.forward;
		}else{
			stat.innerHTML = "<?php _e('OK, redirecting...'); ?>";
			// for bugfree#398
			window.location.href = o_result.forward;
			//reloadParent();
		}
    } else {
        return on_failure(response);
    }
}

function on_failure(response) {
    document.forms["regform"].reset();
    
    document.getElementById("regform_stat").innerHTML = "<?php _e('Request failed!'); ?>";
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
        chk_rs.innerHTML = o_result.errmsg;
    }
}

function on_chk_login_failure(response) {
    var chk_rs = document.getElementById("chk_login_rs");
    chk_rs.innerHTML = "<?php _e('Check failed!'); ?>";
}
//-->
</script>
<?php
$reg_form = new Form('index.php', 'regform', 'check_reg_info');
$reg_form->p_open('mod_user', 'do_reg', '_ajax');
?>
<div class="art_list">
	<div class="art_list_title"><?php _e('Register Member');?></div>
</div>
<div id="regform_table">
<table width="100%"  align="center" cellspacing="1" class="regform_table_s" id="">
    <tfoot>
        <tr>
            <td colspan="2" align="center" class="td_sub">
            <?php
            echo Html::input('submit', 'submit', __('Register'));
            ?>
            <span id="regform_stat" class="status" style="display:none;"></span>
            </td>
        </tr>
    </tfoot>
    <tbody>
        <tr>
            <td class="label"><?php _e('Login Name'); ?></td>
            <td class="entry">
            <?php
            echo Html::input('text', 'user[login]', '', 
                '', $reg_form, 'RequiredTextbox', 
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
                '', $reg_form, 'RequiredTextbox', 
                __('Please input password!'));
            ?>
            </td>
        </tr>
        <tr>
            <td class="label"><?php _e('Confirm Password'); ?></td>
            <td class="entry">
            <?php
            echo Html::input('password', 'user[re_passwd]', '', 
                '', $reg_form, 'RequiredTextbox', 
                __('Please retype your password for confirmation!'));
            ?>
            </td>
        </tr>
        <tr>
            <td class="label"><?php _e('E-mail'); ?></td>
            <td class="entry">
            <?php
            echo Html::input('text', 'user[email]', '', 
                '', $reg_form, 'RequiredTextbox', 
                __('Please input e-mail address!'));
            ?>
            </td>
        </tr>
        <tr>
            <td class="label"><?php _e('Name'); ?></td>
            <td class="entry">
            <?php
            echo Html::input('text', 'user[full_name]');
            ?>
            </td>
        </tr>
                </tr>
		<tr>
            <td class="label"><?php _e('Telephone'); ?></td>
            <td class="entry">
            <?php
            echo Html::input('text', 'user[mobile]');
            ?>
            </td>
        </tr>

        
    </tbody>
</table>
<table width="598" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="332" valign="top" class="reg_bg">&nbsp;</td>
  </tr>
</table>
</div>
<?php
$reg_form->close();
$reg_form->genCompareValidate('user[passwd]', 'user[re_passwd]', 
    '=', __('Passwords mismatch!'));
$running_msg = __('Registring user...');
$custom_js = <<<JS
$("#regform_stat").css({"display":"block"});
$("#regform_stat").html("$running_msg");
_ajax_submit(thisForm, on_success, on_failure);
return false;

JS;
$reg_form->addCustValidationJs($custom_js);
$reg_form->writeValidateJs();
?>