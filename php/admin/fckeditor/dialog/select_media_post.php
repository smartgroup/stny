<?php
require_once(dirname(__FILE__)."/../common.inc.php");
//if (!defined('IN_CONTEXT')) die('access violation error!');
$cfg_softtype = $cfg_mediatype;
$cfg_soft_dir = $cfg_other_medias;
$bkurl = 'select_media.php';
$uploadmbtype = __('Media file type');
require_once(dirname(__FILE__)."/select_soft_post.php");
?>