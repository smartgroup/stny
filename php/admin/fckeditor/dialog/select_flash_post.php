<?php
require_once(dirname(__FILE__)."/../common.inc.php");
//if (!defined('IN_CONTEXT')) die('access violation error!');
$cfg_softtype = 'swf';
$cfg_soft_dir = $cfg_other_medias;
$bkurl = 'select_flash.php';
$uploadmbtype = __('Flash file type');
require_once(dirname(__FILE__)."/select_soft_post.php");
?>