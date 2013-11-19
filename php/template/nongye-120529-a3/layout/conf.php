<?php
if (!defined('IN_CONTEXT')) die('access violation error!');

/**
 * 页面布局配置文件
 *
 */
class LayouConfig
{
	public static $layout_param = array(
		'default' => array(        //默认布局key名称写死
			 'layout_php_file' => 'layout.php',
			 'layout_css_file' => 'style.css',
			 'layout_screenshot_file' => 'layout_left.gif',
			 'author' => 'anonymity',
			 'description' => 'This is default style'
		),
	);
}
?>