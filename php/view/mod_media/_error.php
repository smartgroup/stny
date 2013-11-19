<?php
if (!defined('IN_CONTEXT')) die('access violation error!');

$result = json_decode($json, true);
echo '<div style="height:30px;">'.$result['errmsg']."</div>";
?>