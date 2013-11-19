<?php
if (!defined('IN_CONTEXT')) die('access violation error!');

$frontpagemappings=  Frontpage::frontpagemapping();
$fronturlrel=array();
$nopermissionstr=__('No Permission');
foreach($frontpagemappings as $key=>$modactrel){
        $mod=$modactrel[0];
        $action=$modactrel[1];
         if(ACL::isAdminActionHasPermission($mod, $action)){
               $fronturlrel[$key]=Html::uriquery('frontpage', 'admin',array("_c"=>$key));
         }else{
                $fronturlrel[$key]='javascript:alert(\''.$nopermissionstr.'\');';   
         }
}

$eblock = ''; // for editable item(s)
// 授权或代理
if ((!Toolkit::getAgent() && !IS_INSTALL) || (!ToolKit::getCorp() && IS_INSTALL)) {
	$eblock = '.mod_logo, .mod_block, .mod_nag';
	$local = SessionHolder::get('_LOCALE');
	if (file_exists(ROOT.'/data/admin_block_config.xml')) {
		$i = -1;$k = 0;
		$tmpXml = simplexml_load_file(ROOT.'/data/admin_block_config.xml');
		foreach ($tmpXml->node as $items) {
			$k++;
			if ($items->lang == $local) {
				$i += $k;
				break;
			}
		}
		
		$dataXml = new DOMDocument('1.0','utf-8');
		$dataXml->load(ROOT.'/data/admin_block_config.xml');
		// Read xml
		if ($i > -1) {
			$xml = $dataXml->getElementsByTagName('node')->item($i);
			$logo_src = $xml->getElementsByTagName('logo_src')->item(0)->nodeValue;
			$logo_width = $xml->getElementsByTagName('logo_width')->item(0)->nodeValue;
			$logo_height = $xml->getElementsByTagName('logo_height')->item(0)->nodeValue;
			$bbs_title = $xml->getElementsByTagName('bbs_title')->item(0)->nodeValue;
			$bbs_url = $xml->getElementsByTagName('bbs_url')->item(0)->nodeValue;
			$bbs_description = $xml->getElementsByTagName('bbs_description')->item(0)->nodeValue;
			$host_title = $xml->getElementsByTagName('host_title')->item(0)->nodeValue;
			$host_url = $xml->getElementsByTagName('host_url')->item(0)->nodeValue;
			$host_description = $xml->getElementsByTagName('host_description')->item(0)->nodeValue;
			$footer = $xml->getElementsByTagName('footer')->item(0)->nodeValue;
		} else {
			$xml = $dataXml->getElementsByTagName('node')->item(0);
			$logo_src = $xml->getElementsByTagName('logo_src')->item(0)->nodeValue;
			$bbs_title = __('Official BBS');
			$bbs_url = 'http://www.sitestar.cn/bbs/';
			$bbs_description = __('Any trouble，please seek help from here');
			$host_title = __('Recommend Host');
			$host_url = 'http://www.cndns.com/';
			$host_description = __('Better Host,Better Site');
			$footer = '建站之星（SiteStar）网站建设系统 V2.3 美橙互联<br />Copyrigt@2010 www.sitestar.cn All Right Reserved';
			// Write xml
			$xmlfooter = htmlspecialchars($footer);
			$newNode = <<<XML
<node>
 <lang>{$local}</lang>
 <logo_src>{$logo_src}</logo_src>
 <logo_width>299</logo_width>
 <logo_height>92</logo_height>
 <bbs_title>{$bbs_title}</bbs_title>
 <bbs_url>{$bbs_url}</bbs_url>
 <bbs_description>{$bbs_description}</bbs_description>
 <host_title>{$host_title}</host_title>
 <host_url>{$host_url}</host_url>
 <host_description>{$host_description}</host_description>
 <footer>{$xmlfooter}</footer>
</node>
</root>
XML;
			$oldxml = file_get_contents(ROOT.'/data/admin_block_config.xml');
			if ($oldxml) {
				$newxml = str_replace('</root>', $newNode, $oldxml);
				@file_put_contents(ROOT.'/data/admin_block_config.xml', $newxml);
			}
		}
	} else {
		$i = 0;
		if(!Toolkit::getAgent() && !IS_INSTALL){
		$logo_src = 'template/images/agent_site_logo.png';
		$bbs_title = __('Custom shortcuts');
		$bbs_url = 'http://';
		$bbs_description = __('Custom shortcuts brief introduction');
		$host_title = __('Custom shortcuts');
		$host_url = 'http://';
		$host_description = __('Custom shortcuts brief introduction');
		$footer = __('Enterprise intelligence destinati management system<br />Copyrigt@2010 yourdomain All Right Reserved');
		$xmlfooter = htmlspecialchars($footer);
		}else{
		$logo_src = 'template/images/site_logo.png';
		$bbs_title = __('Official BBS');
		$bbs_url = 'http://www.sitestar.cn/bbs/';
		$bbs_description = __('Any trouble，please seek help from here');
		$host_title = __('Recommend Host');
		$host_url = 'http://www.cndns.com/';
		$host_description = __('Better Host,Better Site');
		$footer = '建站之星（SiteStar）网站建设系统 V2.3 美橙互联<br />Copyrigt@2010 www.sitestar.cn All Right Reserved';
		$xmlfooter = htmlspecialchars($footer);
		}
		
		// create xml
		$xml = <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<root>
<node>
<lang>{$local}</lang>
<logo_src>{$logo_src}</logo_src>
<logo_width>299</logo_width>
<logo_height>92</logo_height>
<bbs_title>{$bbs_title}</bbs_title>
<bbs_url>{$bbs_url}</bbs_url>
<bbs_description>{$bbs_description}</bbs_description>
<host_title>{$host_title}</host_title>
<host_url>{$host_url}</host_url>
<host_description>{$host_description}</host_description>
<footer>{$xmlfooter}</footer>
</node>
</root>
XML;
		$fp = fopen(ROOT.'/data/admin_block_config.xml', 'wb');
		@fwrite($fp, $xml);
		fclose($fp);
	}
} else {
	$logo_width = 299;
	$logo_height = 92;
	$logo_src = 'template/images/site_logo.png';
	$bbs_title = __('Official BBS');
	$bbs_url = 'http://www.sitestar.cn/bbs/';
	$bbs_description = __('Any trouble，please seek help from here');
	$host_title = __('Recommend Host');
	$host_url = 'http://www.cndns.com/';
	$host_description = __('Better Host,Better Site');
	$footer = '建站之星（SiteStar）网站建设系统 V2.3 美橙互联<br />Copyrigt@2010 www.sitestar.cn All Right Reserved';
}

// 套餐版
if (!empty($eblock) && !IS_INSTALL && Toolkit::getAgent()) {
	$logo_width = 299;
	$logo_height = 92;
	$logo_src = 'template/images/site_logo.png';
	$bbs_title = __('Official BBS');
	$bbs_url = 'http://www.sitestar.cn/bbs/';
	$bbs_description = __('Any trouble，please seek help from here');
	$host_title = __('Recommend Host');
	$host_url = 'http://www.cndns.com/';
	$host_description = __('Better Host,Better Site');
	$footer = '建站之星（SiteStar）网站建设系统 V2.3 美橙互联<br />Copyrigt@2010 www.sitestar.cn All Right Reserved';
	// 取消内容编辑
	$eblock = '';
}

//非超级管理员不能内容编辑
if(!ACL::isRoleSuperAdmin()){
	$eblock = '';
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php if(!ToolKit::getCorp()){?>企业网站<?php }else{ ?>SiteStar<?php }?>后台管理系统</title>
<link rel="stylesheet" type="text/css" href="<?php echo P_TPL_WEB; ?>/css/admin.css" />
<?php if (!empty($eblock)) { ?>
<link rel="stylesheet" type="text/css" href="../script/popup/theme/jquery.ui.core.css" />
<link rel="stylesheet" type="text/css" href="../script/popup/theme/jquery.ui.dialog.css" />
<link rel="stylesheet" type="text/css" href="../script/popup/theme/jquery.ui.theme.css" />
<link rel="stylesheet" type="text/css" href="../script/popup/theme/jquery.ui.resizable.css" />
<?php } ?>
<script type="text/javascript" language="javascript" src="../script/popup/jquery-1.4.3.min.js"></script>
<script type="text/javascript" language="javascript" src="../script/helper.js"></script>
<script language="javascript" type="text/javascript">
var edt = "<?php echo $eblock;?>";
$(function(){
	if (edt.length > 0) {		
		$(edt).hover(function(){
			$(this).css({'cursor':'pointer','border':'2px dashed #FF0000'});
			$(this).find('.mod_toolbar').css('display','block');
		},function(){
			$(this).css({'cursor':'normal','border':'none'});
			$(this).find('.mod_toolbar').css('display','none');
		});
		if (edt == '.mod_nag') $('.logo').css('margin-left','50px');
	} else { // for logo
		$('.logo').css('margin-left','50px');
	}
});

function getV() {
	$('#site_upgrade').empty().html("<?php _e('Saving request...');?>");
	_ajax_request('frontpage', 'get_version', null, ongetvok, ongetverr);
}

function ongetvok(response) {
    var o_result = _eval_json(response);

    if (!o_result) {
        return ongetverr(response);
    }
    
    if (o_result.result == "ERROR") {
        alert(o_result.errmsg);
        reloadPage();
    } else if (o_result.result == "OK") {
		if( o_result.curvn >= o_result.vn ) {
			alert("<?php _e('Currently is the latest version, do not upgrade!');?>");
			reloadPage();
		} else {
			$('#site_upgrade').empty().html("<a href=\"javascript:void(0);\" onclick=\"autoupgrade('" + o_result.tag + "', '" + o_result.vn + "')\"><font color=\"#FF0000\"><?php _e('Click here to update');?></font></a>");
		}
    } else {
        return ongetverr(response);
    }
}

function ongetverr(response) {
	alert("<?php _e('Remote request failed!');?>");
	reloadPage();
	return false;
}

function autoupgrade(tag, vn) {
	$("#site_upgrade").empty().html("<?php _e('Upgrading...'); ?>");
	_ajax_request('frontpage', 'auto_upgrade', {'status': tag,'orgvn': vn}, onsuccess, onfailed);
}

function onsuccess(response) {
    var o_result = _eval_json(response);

    if (!o_result) {
        return onfailed(response);
    }
    
    if (o_result.result == "ERROR") {
        $("#site_upgrade").empty().html(o_result.errmsg);
        return false;
    } else if (o_result.result == "OK") {
        $("#site_upgrade").empty().html("<?php _e('Upgrade success!'); ?>");
        reloadPage();
    } else {
        return onfailed(response);
    }
}

function onfailed(response) {
	var retry = "<a href=\"javascript:void(0);\" onclick=\"autoupgrade()\"><font color=\"#FF0000\"><?php _e('Retry');?></font></a>";
    $("#site_upgrade").empty().html("<?php _e('Request failed!'); ?>&nbsp;&nbsp;" + retry);
    return false;
}
</script>
</head>

<body>
<div id="main">
<div class="top">
<?php if (!empty($eblock)) {?>
<div class="mod_logo"><div class="mod_toolbar">
<a onClick="popup_window('index.php?_m=frontpage&amp;_a=admin_logo&amp;_p=<?php echo $i;?>','<?php _e("Edit Logo");?>','','',true,'','','','',true);return false;" title="<?php _e('Edit Logo');?>" href="#"><?php _e('Edit Logo');?></a></div>
<?php }?>

<img src="<?php echo $logo_src;?>" width="<?php echo $logo_width;?>" height="<?php echo $logo_height;?>" class="logo" border="0" />

<?php if (!empty($eblock)) {?></div><?php }?>
<div class="user" <?php if(!file_exists($logo_src)){echo 'style="margin-top:60px"';}?>>
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
<a href="../"><?php _e('Preview Home');?></a>
&nbsp;
<?php
if(SessionHolder::get('user/s_role')=='{admin}'){
?>
<span id="site_upgrade"><a href="javascript:void(0);" onClick="getV()"><?php _e('Upgrade');?></a></span>
&nbsp;
<?php }?>
<a href="<?php echo Html::uriquery('frontpage', 'dologout');?>"><?php _e('Logout');?></a>

</div>
<div style="position:absolute;top:60px;left:800px;">
当前版本：
<?php
echo str_replace('sitestar_','',SYSVER);
?>&nbsp;&nbsp;&nbsp;&nbsp;
</div>
</div>
<?php 
    $db = MysqlConnection::get();
    $prefix = Config::$tbl_prefix;
    
    $user_sql = <<<SQL
SELECT COUNT(*) AS count_user FROM {$prefix}users
SQL;
	$result_user = $db->query($user_sql);
	$rows_user = $result_user->fetchRows(); 
	
	$article_sql = <<<SQL
SELECT COUNT(*) AS count_article FROM {$prefix}articles	
SQL;
	$result_article = $db->query($article_sql);
	$rows_article = $result_article->fetchRows();
	
	$product_sql = <<<SQL
SELECT COUNT(*) AS count_product FROM {$prefix}products	
SQL;
	$result_product = $db->query($product_sql);
	$rows_product = $result_product->fetchRows();
	
	$order_sql = <<<SQL
SELECT COUNT(*) AS count_order FROM {$prefix}online_orders
SQL;
	$result_order = $db->query($order_sql);
	$rows_order = $result_order->fetchRows();
	
	$message_sql = <<<SQL
SELECT COUNT(*) AS count_message FROM {$prefix}messages
SQL;
	$result_message = $db->query($message_sql);
	$rows_message = $result_message->fetchRows();
    ?>
<marquee direction='left' onmouseover="this.stop();" onmouseout="this.start();" scrollamount=3 style='width:820px;margin-left:60px;*margin-left:60px;_margin-left:60px;'>			<font style="color:red;font-size:16px;">&nbsp;<?php _e('Information Statistics');?></font>：&nbsp;&nbsp;
            <font style="color:#ffffff;"><a href="<?php echo $fronturlrel[3];?>" style="color:#ffffff;"><?php _e('Users Number');?>:<?php echo $rows_user[0]['count_user'];?></a>&nbsp;&nbsp;&nbsp;&nbsp;
            <a href="<?php echo $fronturlrel[1];?>" style="color:#ffffff;"><?php _e('Articles Number');?>:<?php echo $rows_article[0]['count_article'];?></a>&nbsp;&nbsp;&nbsp;&nbsp;
            <a href="<?php echo $fronturlrel[2];?>" style="color:#ffffff;"><?php _e('Products Number');?>:<?php echo $rows_product[0]['count_product'];?></a>&nbsp;&nbsp;&nbsp;&nbsp;
            <?php _e('Orders Number');?>:<?php echo $rows_order[0]['count_order'];?>&nbsp;&nbsp;&nbsp;&nbsp;
            <a href="<?php echo $fronturlrel[4];?>" style="color:#ffffff;"><?php _e('Message Number');?>:<?php echo $rows_message[0]['count_message'];?></a>
     </font>
		</marquee>
<div id="nav">

<div class="nl">

<div class="nag">
<a href="<?php echo $fronturlrel[1];?>"><h1><?php _e("Articles");?></h1></a>
<p><?php _e("View,Edit,Add,Delete article and category");?></p>
</div>
<div class="nag">
<a href="<?php echo $fronturlrel[2];?>"><h1><?php _e("Products");?></h1>
</a>
<p><?php _e("View,Edit,Add,Delete product and category");?></p>
</div>
<div class="nag">
<a href="../index.php"><h1><?php _e("Web Edit");?></h1>
</a>
<p><?php _e("Easy manage web content,layout");?></p>
</div>
<div class="nag">
<a href="<?php echo $fronturlrel[3];?>"><h1><?php _e("Member Manage");?></h1>
</a>
<p><?php _e("Manage your web member");?></p>
</div>	
</div>
<div class="nr">
<div class="nag">
<a href="<?php echo $fronturlrel[4];?>"><h1><?php _e("Messages");?></h1>
</a>
<p><?php _e("Manage your custom message");?></p>
</div>
<div class="nag">
<a href="<?php echo $fronturlrel[5];?>"><h1><?php _e("Bulletins");?></h1>
</a>
<p><?php _e("Publishing the new notice in timely");?></p>
</div>
<div class="nag mod_nag">
<?php if (!empty($eblock)) {?><div class="mod_toolbar"><a onClick="popup_window('index.php?_m=frontpage&amp;_a=admin_cell&amp;_t=bbs&amp;_p=<?php echo $i;?>','<?php _e("Edit Content");?>','','',true,'','','','',true);return false;" title="<?php _e('Edit Content');?>" href="#"><?php _e('Edit Content');?></a></div><?php }?>
<a href="<?php if($bbs_url){echo $bbs_url;}else{echo '#';} ?>" target="_blank"><h1><?php echo $bbs_title;?></h1>
</a>
<p><?php echo $bbs_description;?></p>
</div>

<div class="nag mod_nag">
<?php if (!empty($eblock)) {?><div class="mod_toolbar"><a onClick="popup_window('index.php?_m=frontpage&amp;_a=admin_cell&amp;_t=host&amp;_p=<?php echo $i;?>','<?php _e("Edit Content");?>','','',true,'','','','',true);return false;" title="<?php _e('Edit Content');?>" href="#"><?php _e('Edit Content');?></a></div><?php }?>
<a href="<?php if($host_url){echo $host_url;}else{echo '#';} ?>" target="_blank"><h1><?php echo $host_title;?></h1>
</a>
<p><?php echo $host_description;?></p>
</div>
</div>
<div style="clear:both"></div>
</div>
<?php
if(ToolKit::getCorp()){
?>
<?php if(!ToolKit::getCorp()){?>
<?php if(Toolkit::getAgent()){?>
<img src="<?php echo P_TPL_WEB;?>/images/location_2.gif" width="882" height="102" border="0" usemap="#Map" style="margin-left:30px;"  />
<?php }?>
<?php }else{ ?>
<img src="<?php echo P_TPL_WEB;?>/images/location.gif" width="882" height="102" border="0" usemap="#Map" style="margin-left:30px;"  />
<?php } ?>
<div class="binfo">
<h3><?php
if(!ToolKit::getCorp()){
	if(Toolkit::getAgent()){
	_e('Has obtained a commercial license');
	}
} else {
	_e('Without the commercial license');
} 
?></h3>
<?php
	if(!ToolKit::getCorp()){
		if(Toolkit::getAgent()){
		include(ROOT.'/licence.dat');
		//_e('Licenced');
		_e('Licenced domain');echo $l0.'<br />';
		_e('Licenced start');echo $l2.'<br />';
		$start_time = substr($l2, 0, strpos($l2,"-"));
		$end_time   = substr($l4, 0, strpos($l4,"-"));		
		$time_stamp = $end_time-$start_time;
		//$time_tag = $time_stamp/(60*60*24*365);
		_e('Licenced end');if($time_stamp<100){echo $l4;}else{ _e('Time so long') ;}
		}
	} else {
		_e('Licence Desc');
	}
?>
</div>
<?php if(ToolKit::getCorp()){ ?>
<map name="Map" id="Map">
  <area shape="rect" coords="467,18,638,87" href="http://www.sitestar.cn/license/" target="_blank"/>
  <area shape="rect" coords="655,18,825,86" href="http://www.sitestar.cn/license/" target="_blank" />
</map><?php }?>
</div>
<?php
}
?>
<?php if (!empty($eblock)) {?>
<div class="mod_block"><div class="mod_toolbar"><a onClick="popup_window('index.php?_m=frontpage&amp;_a=admin_foot&amp;_p=<?php echo $i;?>','<?php _e("Edit Content");?>','','',true,'','','','',true);return false;" title="<?php _e('Edit Content');?>" href="#"><?php _e('Edit Content');?></a></div><?php }?>
<div id="bottom"><?php echo $footer;?></div>
<?php if (!empty($eblock)) {?></div><?php }?>
<?php if (!empty($eblock)) {?>
<script type="text/javascript" language="javascript" src="../script/popup/jquery.ui.custom.min.js"></script><?php }?>
<script type="text/javascript" language="javascript" src="<?php echo P_SCP; ?>/png.js"></script>
</body>
</html>