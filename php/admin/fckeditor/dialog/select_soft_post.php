<?php
require_once(dirname(__FILE__)."/../common.inc.php");
//if (!defined('IN_CONTEXT')) die('access violation error!');

if(empty($uploadfile)) $uploadfile = '';
if(empty($uploadmbtype)) $uploadmbtype = __('Attachment Type');
if(empty($bkurl)) $bkurl = 'select_soft.php';
$newname = ( empty($newname) ? '' : preg_replace("/[\\ \"\*\?\t\r\n<>':\|]/", "", $newname) );

if(!is_uploaded_file($uploadfile))
{
	ShowMsg(__('You do not choose to upload a file or select the file size exceeds the limit!'), "-1");
	exit();
}

//软件类型所有支持的附件
$cfg_softtype = $cfg_softtype;
$cfg_softtype = str_replace('||', '|', $cfg_softtype);
$uploadfile_name = trim(preg_replace("/[ \r\n\t\*\%\\/\?><\|\":]{1,}/",'',$uploadfile_name));
if(!preg_match("/\.(".$cfg_softtype.")/i", $uploadfile_name))
{
	ShowMsg(__('Upload your file type is not approved list'),"-1");
	exit();
}

//文件名（前为手工指定， 后者自动处理）
if(!empty($newname))
{
	$filename = $newname;
	if(!preg_match("/\./", $filename)) $fs = explode('.', $uploadfile_name);
	else $fs = explode('.', $filename);
	if(preg_match("/{$cfg_not_allowall}/i", $fs[count($fs)-1]))
	{
		ShowMsg(__('The file name you specify prohibited by the system!'),'-1');
		exit();
	}
	if(!preg_match("/\./", $filename)) $filename = $filename.'.'.$fs[count($fs)-1];
}else{
	$filename = $uploadfile_name;
	$fs = explode('.', $filename);
	if(preg_match("/{$cfg_not_allowall}/i", $fs[count($fs)-1]))
	{
		ShowMsg(__('You upload some files may exist insecurity, the system refused to operate!'),'-1');
		exit();
	}
}

if (isset($_POST['mediadir']) && !empty($_POST['mediadir'])) {
	$activepath = str_replace('upload/media', trim($_POST['mediadir']), $activepath);
}
if (isset($_POST['flashdir']) && !empty($_POST['flashdir'])) {
	$activepath = str_replace('upload/flash', trim($_POST['flashdir']), $activepath);
}
if (isset($_POST['softdir']) && !empty($_POST['softdir'])) {
	$activepath = str_replace('upload/file', trim($_POST['softdir']), $activepath);
}
$fullfilename = $cfg_basedir.$activepath.'/'.$filename;
$fullfileurl = $activepath.'/'.$filename;
// for chinese encoding
if (preg_match("/^WIN/i", PHP_OS) && preg_match("/[\x80-\xff]./", $fullfilename)) $fullfilename = iconv('UTF-8', 'GBK//IGNORE', $fullfilename);
move_uploaded_file($uploadfile,$fullfilename) or die(_e('Upload file to')." $fullfilename "._e('failed!'));
ParamParser::fire_virus($fullfilename);
@unlink($uploadfile);

ShowMsg(__('Successful upload file(s)!'),$bkurl."?comeback=".urlencode($filename)."&f=$f&activepath=".urlencode($activepath)."&d=".time());
exit();
?>