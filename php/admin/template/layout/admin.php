<?php
if (!defined('IN_CONTEXT')) die('access violation error!');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php if((!Toolkit::getAgent() && !IS_INSTALL) || (!ToolKit::getCorp() && IS_INSTALL)){ echo '企业网站';}else{ echo 'SiteStar';} ?>后台管理系统</title>
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<link rel="stylesheet" type="text/css" href="<?php echo P_TPL_WEB; ?>/css/admin.css" />
<style type="text/css">
.logo{ margin-left:-2px;}
.user{ background:#ebf9ff url(../admin/template/images/user.gif) no-repeat 5px 3px; padding:4px 5px 4px 25px; position:absolute; margin:-60px 0px 0px 705px;*margin:33px 0px 0px 345px;}
a{text-decoration:none;}

</style>
</head>

<body>
<div id="main">
<div class="top">
<a href="<?php echo Html::uriquery("frontpage","dashboard");?>">
	<?php
	$ext = false;
	if((!Toolkit::getAgent() && !IS_INSTALL) || (!ToolKit::getCorp() && IS_INSTALL)){
		if(!isset($i)){
			$i=0;
		}
		$dataXml = new DOMDocument('1.0','utf-8');
		$dataXml->load(ROOT.'/data/admin_block_config.xml');
		$xml = $dataXml->getElementsByTagName('node')->item($i);
		$logo_src = $xml->getElementsByTagName('logo_src')->item(0)->nodeValue;
		$logo_width = $xml->getElementsByTagName('logo_width')->item(0)->nodeValue;
		$logo_height = $xml->getElementsByTagName('logo_height')->item(0)->nodeValue;
		$footer = $xml->getElementsByTagName('footer')->item(0)->nodeValue;
		if(!file_exists(P_TPL_WEB.'/images/site_agent_logo.gif')) $ext = true;
	?><img style="margin-left:30px;" src="<?php echo $logo_src;?>" width="<?php echo $logo_width;?>" height="<?php echo $logo_height;?>" class="logo" border=0/><?php }else{
	if(!file_exists(P_TPL_WEB.'/images/site_logo.png')) $ext = true; ?>
	<img src="<?php echo P_TPL_WEB;?>/images/site_logo.png" width="299" height="92" class="logo" border=0/><?php }?></a>
<div class="user" <?php if($ext){echo 'style="margin-top:60px"';}?>>
<?php 
	$o_locale = new Parameter();
	$locale_items = $o_locale->findAll("`key` = 'DEFAULT_LOCALE'");
	$_user = SessionHolder::get('user/login');
	/*if($locale_items[0]->val == 'zh_CN') {
		$showMsg = '您好尊敬的'.$_user.'会员';
	} elseif($locale_items[0]->val == 'en') {
		$showMsg = 'Hello,'.$_user;
	}*/
	echo __('Hello,').$_user;
?> &nbsp;
<a href="<?php echo Html::uriquery('frontpage', 'dashboard');?>"><?php _e('Return');?></a>
<a href="<?php echo Html::uriquery('frontpage', 'dologout');?>"><?php _e('Logout');?></a>
</div>
</div>
<iframe src="index.php?<?php echo $url;?>" frameborder=0 width=940 onload="this.height=184;this.height=this.contentWindow.document.documentElement.scrollHeight"></iframe>
<div id="bottom"><?php if((!Toolkit::getAgent() && !IS_INSTALL) || (!ToolKit::getCorp() && IS_INSTALL)){
	echo $footer;
}else{
	echo '建站之星（SiteStar）网站建设系统 版本 SiteStar V2.3 美橙互联<br />Copyrigt@2010 www.sitestar.cn All Right Reserved';
}	
?></div>
</div>

</body>
</html>