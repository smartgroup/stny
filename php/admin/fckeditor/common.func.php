<?php
if(!defined('SSFCK')) exit('SSCMS');

//兼容php4
if(!function_exists('file_put_contents'))
{
	function file_put_contents($n,$d)
	{
		$f=@fopen($n,"w");
		if (!$f)
		{
			return false;
		}
		else
		{
			fwrite($f,$d);
			fclose($f);
			return true;
		}
	}
}

//返回格林威治标准时间
function MyDate($format='Y-m-d H:i:s',$timest=0)
{
	global $cfg_cli_time;
	$addtime = $cfg_cli_time * 3600;
	if(empty($format))
	{
		$format = 'Y-m-d H:i:s';
	}
	return gmdate ($format,$timest+$addtime);
}

function ShowMsg($msg,$gourl,$onlymsg=0,$limittime=0)
{
	if(empty($GLOBALS['cfg_phpurl'])) $GLOBALS['cfg_phpurl'] = '..';

	$htmlhead  = "<html>\r\n<head>\r\n<title>".__('System message')."</title>\r\n<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />\r\n";
	$htmlhead .= "<base target='_self'/>\r\n<style>div{line-height:160%;}</style></head>\r\n<body leftmargin='0' topmargin='0'>".(isset($GLOBALS['ucsynlogin']) ? $GLOBALS['ucsynlogin'] : '')."\r\n<center>\r\n<script>\r\n";
	$htmlfoot  = "</script>\r\n</center>\r\n</body>\r\n</html>\r\n";

	$litime = ($limittime==0 ? 1000 : $limittime);
	$func = '';

	if($gourl=='-1')
	{
		if($limittime==0) $litime = 5000;
		$gourl = "javascript:history.go(-1);";
	}

	if($gourl=='' || $onlymsg==1)
	{
		$msg = "<script>alert(\"".str_replace("\"","“",$msg)."\");</script>";
	}
	else
	{
		//当网址为:close::objname 时, 关闭父框架的id=objname元素
		if(preg_match('/close::/i',$gourl))
		{
			$tgobj = trim(preg_replace('/close::/i', '', $gourl));
			$gourl = 'javascript:;';
			$func .= "window.parent.document.getElementById('{$tgobj}').style.display='none';\r\n";
		}
		
		$func .= "      var pgo=0;
      function JumpUrl(){
        if(pgo==0){ window.location.href='$gourl'; pgo=1; }
      }\r\n";
		$rmsg = $func;
		$rmsg .= "document.write(\"<br /><div style='width:450px;padding:0px;border:1px solid #D1DDAA;'>";
		$rmsg .= "<div style='padding:6px;font-size:12px;border-bottom:1px solid #D1DDAA;background:#DBEEBD url({$GLOBALS['cfg_phpurl']}/img/wbg.gif)';'><b>".__('System message')."</b></div>\");\r\n";
		$rmsg .= "document.write(\"<div style='height:130px;font-size:10pt;background:#ffffff'><br />\");\r\n";
		$rmsg .= "document.write(\"".str_replace("\"","“",$msg)."\");\r\n";
		$rmsg .= "document.write(\"";
		
		if($onlymsg==0)
		{
			if( $gourl != 'javascript:;' && $gourl != '')
			{
				$rmsg .= "<br /><a href='{$gourl}'>".__('If your browser does not respond, please click here ...')."</a>";
				$rmsg .= "<br/></div>\");\r\n";
				$rmsg .= "setTimeout('JumpUrl()',$litime);";
			}
			else
			{
				$rmsg .= "<br/></div>\");\r\n";
			}
		}
		else
		{
			$rmsg .= "<br/><br/></div>\");\r\n";
		}
		$msg  = $htmlhead.$rmsg.$htmlfoot;
	}
	echo $msg;
}

function dd2char($ddnum)
{
	$ddnum = strval($ddnum);
	$slen = strlen($ddnum);
	$okdd = '';
	$nn = '';
	for($i=0;$i<$slen;$i++)
	{
		if(isset($ddnum[$i+1]))
		{
			$n = $ddnum[$i].$ddnum[$i+1];
			if( ($n>96 && $n<123) || ($n>64 && $n<91) )
			{
				$okdd .= chr($n);
				$i++;
			}
			else
			{
				$okdd .= $ddnum[$i];
			}
		}
		else
		{
			$okdd .= $ddnum[$i];
		}
	}
	return $okdd;
}

// get directory
function GetDirList($base_upload_dir) {
	global $dirlist;

	$handle = dir(SSROOT."/$base_upload_dir");
	while(($path = $handle->read()) !== false) {
		if (!in_array($path, array(".", "..", ".svn")) && is_dir(SSROOT."/{$base_upload_dir}{$path}/"))	{
			$dirlist[] = $base_upload_dir."{$path}/";
			GetDirList($base_upload_dir."{$path}/");
		} else continue;
	}
	$handle->close();
	
	return $dirlist;
}

function __($msgid){
	global $lang;
	if(array_key_exists($msgid,$lang)){
		return $lang[$msgid];
	}else{
		return $msgid;
	}
	
}

function _e($msgid){
	global $lang;
	if(array_key_exists($msgid,$lang)){
		echo $lang[$msgid];
	}else{
		echo $msgid;
	}
}
?>