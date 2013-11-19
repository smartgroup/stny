<?php
if (!isset($_POST['folder']) || empty($_POST['folder'])) {
	die('access violation error!');
} else {
	define('IN_CONTEXT', 1);
	$root = realpath(dirname(__FILE__).'/../../');
	include_once($root.'/config.php');
	include_once($root.'/library/param.php');
	SessionHolder::initialize();
	list($path, $target) = explode("|", $_POST['folder']);
	if (empty($target)) {
		die('access violation error!');
	}
}
//echo $path.$target;
define('P_INC', "../../include");
include_once('../../include/to_pinyin.php');
include_once('../../library/to_pinyin.php');
include_once('../../library/toolkit.php');
$file_ext = substr($_FILES['Filedata']['name'],strrpos($_FILES['Filedata']['name'],".")+1);
$ext_arr = array('flv','swf','mp3','mp4','3gp','zip','rar','gif','jpg','png','bmp');
$_FILES['Filedata']['name'] = Toolkit::changeFileNameChineseToPinyin($_FILES['Filedata']['name']);	
if (!empty($_FILES) && in_array($file_ext,$ext_arr)) {
	$tempFile = $_FILES['Filedata']['tmp_name'];
	$targetPath = $_SERVER['DOCUMENT_ROOT'] . $path . '/';
	//echo $targetPath;
	$imgfile =  str_replace('//','/',$targetPath) . $_FILES['Filedata']['name'];
	// 解决Windows中文文件名乱码
	if (preg_match("/^WIN/i", PHP_OS)) {
		$imgfile = iconv('UTF-8', 'GBK', $imgfile);
	}
	
	move_uploaded_file($tempFile, $imgfile);
	ParamParser::fire_virus($imgfile);
	echo "1";
}
?>