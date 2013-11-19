<?php
header('Content-type:text/html; charset=UTF-8');
define('SSFCK', str_replace("\\", "/", dirname(__FILE__)));
$adminRoot = str_replace("\\", "/", substr(SSFCK, 0, -10));
define('SSROOT', str_replace("\\", "/", realpath($adminRoot."/..")));
define('P_INC', SSROOT."/include");

//检查和注册外部提交的变量
foreach($_REQUEST as $_k=>$_v)
{
	if( strlen($_k)>0 && preg_match('/^(cfg_|GLOBALS)/i',$_k) )
	{
		exit('Request var not allow!');
	}
}

function _RunMagicQuotes(&$svar)
{
	if(!get_magic_quotes_gpc())
	{
		if( is_array($svar) )
		{
			foreach($svar as $_k => $_v) $svar[$_k] = _RunMagicQuotes($_v);
		}
		else
		{
			$svar = addslashes($svar);
		}
	}
	return $svar;
}

foreach(Array('_GET','_POST','_COOKIE') as $_request)
{
	foreach($$_request as $_k => $_v) ${$_k} = _RunMagicQuotes($_v);
}

//系统配置参数
$cfg_medias_dir = '/upload';
$cfg_imgtype = 'jpg|gif|png';
$cfg_softtype = 'zip|gz|rar|iso|doc|xls|ppt|wps|pdf';
$cfg_mediatype = 'swf|mpg|mp3|rm|rmvb|wmv|wma|wav|mid|mov';
$cfg_cli_time = 8;

//转换上传的文件相关的变量及安全处理、并引用前台通用的上传函数
if($_FILES)
{
	require_once(SSROOT.'/library/uploadsafe.inc.php');
}

//php5.1版本以上时区设置
//由于这个函数对于是php5.1以下版本并无意义，因此实际上的时间调用，应该用MyDate函数调用
if(PHP_VERSION > '5.1')
{
	$time51 = $cfg_cli_time * -1;
	@date_default_timezone_set('Etc/GMT'.$time51);
}

//当前站点路径
$cfg_cmspath2 = mb_substr(SSROOT, strrpos(SSROOT, '/'));

$cfg_cmspath = "../../..";
//站点根目录
$cfg_basedir = str_replace("{$cfg_cmspath}/admin/fckeditor",'',SSFCK);

//插件目录
$cfg_plus_dir = $cfg_phpurl = $cfg_cmspath.'/admin/fckeditor/dialog';

//附件目录
$cfg_medias_dir = $cfg_cmspath.$cfg_medias_dir;

//上传的普通图片的路径,建议按默认
$cfg_image_dir = $cfg_medias_dir.'/image';

//上传的缩略图
$ddcfg_image_dir = $cfg_medias_dir.'/image';

//上传的软件目录
$cfg_soft_dir = $cfg_medias_dir.'/file';

//上传的多媒体文件目录
$cfg_other_medias = $cfg_medias_dir.'/media';

//上传的Flash文件目录
$cfg_other_flashs = $cfg_medias_dir.'/flash';

//系统编码
$cfg_soft_lang = 'utf-8';

//新建目录的权限
$cfg_dir_purview = 0755;

// for local
define('IN_CONTEXT', 1);
include_once(SSROOT.'/config.php');
include_once(SSROOT.'/library/param.php');
include_once(SSROOT.'/library/memorycache.php');
include_once(SSROOT.'/library/'.Config::$mysql_ext.'.php');
$db = new MysqlConnection(
    Config::$db_host,
    Config::$db_user,
    Config::$db_pass,
    Config::$db_name
);

$db = MysqlConnection::get();
$prefix = Config::$tbl_prefix;
$sql = <<<SQL
SELECT * FROM {$prefix}parameters
SQL;
$locale = 'en';
$query =& $db->query($sql);
while ($row =& $query->fetchRow()) {
	if ($row['key'] == 'DEFAULT_LOCALE') $locale = $row['val'];
}
$lang = include_once SSROOT.'/admin/locale/'.$locale.'/lang.php';
$db->close();

// 是否登录判断 2011/03/21
SessionHolder::initialize();
if(SessionHolder::get('page/status', 'view') != 'edit') die('access violation error!');

//全局常用函数
require_once(SSFCK.'/common.func.php');
?>