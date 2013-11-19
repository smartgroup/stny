<?php
header('Conten-type:text/html; charset=UTF-8');
define('SSFCK', str_replace("\\", "/", dirname(__FILE__)));
$adminRoot = str_replace("\\", "/", substr(SSFCK, 0, -10));
define('SSROOT', str_replace("\\", "/", realpath($adminRoot."/..")));
	
$err = '0';
$basedir = trim($_GET['basedir']);
$newdir = trim($_GET['newdir']);
// is or not exist dir
$hd = dir("../../".$basedir);
while(($path = $hd->read()) !== false) {
	if ($path == $newdir) {
		$err = '-1';
		break;
	} else continue;
}

if ($err != '-1') {
	if (!mkdir("../../{$basedir}{$newdir}", 0755)) $err = '-2';
}

echo $err;
?>