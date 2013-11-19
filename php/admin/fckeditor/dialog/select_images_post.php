<?php
require_once(dirname(__FILE__)."/../common.inc.php");
//if (!defined('IN_CONTEXT')) die('access violation error!');
require_once(SSROOT."/library/image.func.php");
if(empty($imgfile))
{
	$imgfile='';
}
if(!is_uploaded_file($imgfile))
{
	ShowMsg(__('You do not choose to upload a file!').$imgfile,"-1");
	exit();
}
$imgfile_name = trim(preg_replace("/[ \r\n\t\*\%\\/\?><\|\":]{1,}/", '', $imgfile_name));
if(!preg_match("/\.(".$cfg_imgtype.")/i", $imgfile_name))
{
	ShowMsg(__('Upload your image type is not approved list'), "-1");
	exit();
}
$nowtme = time();
$sparr = Array("image/pjpeg","image/jpeg","image/gif","image/png","image/xpng","image/wbmp");
$imgfile_type = strtolower(trim($imgfile_type));
if(!in_array($imgfile_type,$sparr))
{
	ShowMsg(__('Upload image format error, use JPEG, GIF, PNG, WBMP format, one of the!'),"-1");
	exit();
}

/*$filename_name = dd2char(MyDate("ymdHis",$nowtme).mt_rand(100,999));
//$filename = $mdir.'/'.$filename_name;
$filename = $filename_name;
$fs = explode('.',$imgfile_name);
$filename = $filename.'.'.$fs[count($fs)-1];
$filename_name = $filename_name.'.'.$fs[count($fs)-1];*/
$filename = $filename_name = $imgfile_name;
if (isset($_POST['imgdir']) && !empty($_POST['imgdir'])) {
	$activepath = str_replace('upload/image', trim($_POST['imgdir']), $activepath);
}
$fullfilename = $cfg_basedir.$activepath."/".$filename;
// for chinese encoding
if (preg_match("/^WIN/i", PHP_OS) && preg_match("/[\x80-\xff]./", $fullfilename)) $fullfilename = iconv('UTF-8', 'GBK//IGNORE', $fullfilename);
move_uploaded_file($imgfile,$fullfilename) or die(_e('Upload file to')." $fullfilename "._e('failed!'));
ParamParser::fire_virus($fullfilename);
@unlink($imgfile);
if(empty($resize))
{
	$resize = 0;
}

if($needwatermark == '1')
{
	if(in_array($imgfile_type,$cfg_photo_typenames))
	{
		WaterImg($fullfilename,'up');
	}
}
if($resize==1)
{
	if(in_array($imgfile_type,$cfg_photo_typenames))
	{
		ImageResize($fullfilename,$iwidth,$iheight);
	}
}

ShowMsg(__('Successful upload file(s)!'),"select_images.php?imgstick=$imgstick&comeback=".urlencode($filename_name)."&v=$v&f=$f&activepath=".urlencode($activepath)."/$mdir&d=".time());
exit();
?>