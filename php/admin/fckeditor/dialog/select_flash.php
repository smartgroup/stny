<?php
require_once(dirname(__FILE__)."/../common.inc.php");
//if (!defined('IN_CONTEXT')) die('access violation error!');
if(empty($activepath))
{
	$activepath = '';
}
//$activepath = str_replace('.','',$activepath);
//$activepath = str_replace("/",'/',$activepath);
if(strlen($activepath) < strlen($cfg_other_flashs))
{
	$activepath = $cfg_other_flashs;
}
$inpath = $cfg_basedir.$activepath;
$activeurl = '..'.$activepath;
if(empty($f))
{
	$f = 'form1.enclosure';
}

if(empty($comeback))
{
	$comeback = '';
}
?>
<html>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
<title><?php _e('Flash File Manager');?></title>
<link href='img/base.css' rel='stylesheet' type='text/css'>
<style>
.linerow {border-bottom: 1px solid #D5D59D;}
</style>
<script type="text/javascript" language="javascript" src="../../../script/jquery.min.js"></script>
<script type="text/javascript" language="javascript">
function addSort(obj) {
	$(obj).parent().find('span').css('display','inline-block');
	$(obj).css('display','none');
	$(obj).parent().find('span > input:first').focus();
}

function newDir(obj) {
	var pth = $(obj).prev().attr('value');
	var basepth = $('#gtcurdir option:selected').text();
	if (pth.replace(/^\s+|\s+$/g,'').length == 0) {
		alert("<?php _e('Please input characters!');?>");
		$(obj).prev().focus();
		return false;
	} else {
	    $.ajax({
	        type     : "GET",
	        dataType : "text",
	        url      : "../mkdir.ajax.php?basedir="+basepth+"&newdir="+pth,
	        success  : function(response) {
	        	switch (response) {
	        		case '0':
	        			$(obj).prev().val('');
				       $(obj).parent().css('display','none');
				       $(obj).parent().parent().find('a').css('display','inline-block');
				       $('<option value="'+basepth+pth+'/" selected="true">'+basepth+pth+'/</option>').appendTo('#gtcurdir');
	        			break;
	        		case '-1':
		    			alert("<?php _e('The folder already exists!');?>");
		    		    $(obj).prev().focus();
		    			break;
		    		case '-2':
		    			alert("<?php _e('New Folder failed!');?>");
		    			break;
	        	}
	        },
	        error    : function(response) {
	        	alert("<?php _e('Request failed!');?>");
	    		return false;
	        }
	    });
	}
}	
</script>
</head>
<body background='img/allbg.gif' leftmargin='0' topmargin='0'>
<SCRIPT language='JavaScript'>
function nullLink()
{
	return;
}
function ReturnValue(reimg)
{
	window.opener.document.<?php echo $f?>.value=reimg;
	if(document.all) window.opener=true;
	window.close();
}
</SCRIPT>
<table width='100%' border='0' cellpadding='0' cellspacing='1' bgcolor='#CBD8AC' align="center">
<tr bgcolor='#FFFFFF'>
<td colspan='3'>
<!-- 开始文件列表  -->
<table width='100%' border='0' cellspacing='0' cellpadding='2'>
<tr bgcolor="#CCCCCC">
<td width="55%" align="center" background="img/wbg.gif" class='linerow'><strong><?php _e('Click the name to select a file');?></strong></td>
<td width="15%" align="center" bgcolor='#EEF4EA' class='linerow'><strong><?php _e('File Size');?></strong></td>
<td width="30%" align="center" background="img/wbg.gif" class='linerow'><strong><?php _e('Last modified');?></strong></td>
</tr>
<?php
$dh = dir(realpath($activepath));
$ty1="";
$ty2="";
while($file = $dh->read()) {
	//-----计算文件大小和创建时间
	if($file!="." && $file!=".." && !is_dir("$inpath/$file")){
		$filesize = filesize("$inpath/$file");
		$filesize=$filesize/1024;
		if($filesize!="")
		if($filesize<0.1){
			@list($ty1,$ty2)=split("\.",$filesize);
			$filesize=$ty1.".".substr($ty2,0,2);
		}
		else{
			@list($ty1,$ty2)=split("\.",$filesize);
			$filesize=$ty1.".".substr($ty2,0,1);
		}
		$filetime = filemtime("$inpath/$file");
		$filetime = MyDate("Y-m-d H:i:s",$filetime);
	}

	//------判断文件类型并作处理
	if($file == ".") continue;
	else if($file == "..")
	{
		if($activepath == "") continue;
		$path = pathinfo($activepath);
		$tmp = $path['dirname'];
		$line = "\n<tr>
    <td class='linerow'> <a href=select_flash.php?f=$f&activepath=".urlencode($tmp)."><img src=img/dir2.gif border=0 width=16 height=16 align=absmiddle>".__('Parent directory')."</a></td>
    <td colspan='2' class='linerow'> ".__('Current directory').":".str_replace($cfg_cmspath,$cfg_cmspath2,$activepath)."</td>
    </tr>\r\n";
		echo $line;
	}
	else if(is_dir("$inpath/$file"))
	{
		if(preg_match("/^_(.*)$/i",$file)) continue; #屏蔽FrontPage扩展目录和linux隐蔽目录
		if(preg_match("/^\.(.*)$/i",$file)) continue;
		$line = "\n<tr>
   <td bgcolor='#F9FBF0' class='linerow'>
    <a href=select_flash.php?f=$f&activepath=".urlencode("$activepath/$file")."><img src=img/dir.gif border=0 width=16 height=16 align=absmiddle>$file</a>
   </td>
   <td class='linerow'>-</td>
   <td bgcolor='#F9FBF0' class='linerow'>-</td>
   </tr>";
		echo "$line";
	}
	else if(preg_match("/\.(swf|fly|fla|flv)/i",$file)){

		// 中文乱码
		if (preg_match("/^WIN/i", PHP_OS) && preg_match("/[\x80-\xff]./", $file)) $file = iconv('GBK', 'UTF-8', $file);
		
		$reurl = "$activeurl/$file";
		$reurl = preg_replace("/^\.\./","",$reurl);

		if($file==$comeback) $lstyle = " style='color:red' ";
		else  $lstyle = "";

		$line = "\n<tr>
   <td class='linerow' bgcolor='#F9FBF0'>
     <a href=\"javascript:ReturnValue('$reurl');\"><img src=img/flash.gif border=0 width=16 height=16 align=absmiddle>$file</a>
   </td>
   <td class='linerow'>$filesize KB</td>
   <td align='center' class='linerow' bgcolor='#F9FBF0'>$filetime</td>
   </tr>";
		echo "$line";
	}
	else if(preg_match("/\.(wmv|avi)/i",$file)){

		// 中文乱码
		if (preg_match("/^WIN/i", PHP_OS) && preg_match("/[\x80-\xff]./", $file)) $file = iconv('GBK', 'UTF-8', $file);

		$reurl = "$activeurl/$file";
		$reurl = preg_replace("/^\.\./","",$reurl);

		if($file==$comeback) $lstyle = " style='color:red' ";
		else  $lstyle = "";

		$line = "\n<tr>
   <td class='linerow' bgcolor='#F9FBF0'>
     <a href=\"javascript:ReturnValue('$reurl');\"><img src=img/wmv.gif border=0 width=16 height=16 align=absmiddle>$file</a>
   </td>
   <td class='linerow'>$filesize KB</td>
   <td align='center' class='linerow' bgcolor='#F9FBF0'>$filetime</td>
   </tr>";
		echo "$line";
	}
	else if(preg_match("/\.(rm|rmvb)/i",$file)){

		// 中文乱码
		if (preg_match("/^WIN/i", PHP_OS) && preg_match("/[\x80-\xff]./", $file)) $file = iconv('GBK', 'UTF-8', $file);

		$reurl = "$activeurl/$file";
		$reurl = preg_replace("/^\.\./","",$reurl);

		if($file==$comeback) $lstyle = " style='color:red' ";
		else  $lstyle = "";

		$line = "\n<tr>
   <td class='linerow' bgcolor='#F9FBF0'>
     <a href=\"javascript:ReturnValue('$reurl');\"><img src=img/rm.gif border=0 width=16 height=16 align=absmiddle>$file</a>
   </td>
   <td class='linerow'>$filesize KB</td>
   <td align='center' class='linerow' bgcolor='#F9FBF0'>$filetime</td>
   </tr>";
		echo "$line";
	}
	else if(preg_match("/\.(mp3|wma)/i",$file)){

		// 中文乱码
		if (preg_match("/^WIN/i", PHP_OS) && preg_match("/[\x80-\xff]./", $file)) $file = iconv('GBK', 'UTF-8', $file);

		$reurl = "$activeurl/$file";
		$reurl = preg_replace("/^\.\./","",$reurl);

		if($file==$comeback) $lstyle = " style='color:red' ";
		else  $lstyle = "";

		$line = "\n<tr>
   <td class='linerow' bgcolor='#F9FBF0'>
     <a href=\"javascript:ReturnValue('$reurl');\"><img src=img/mp3.gif border=0 width=16 height=16 align=absmiddle>$file</a>
   </td>
   <td class='linerow'>$filesize KB</td>
   <td align='center' class='linerow' bgcolor='#F9FBF0'>$filetime</td>
   </tr>";
		echo "$line";
	}
}//End Loop
$dh->close();

// for making directory
$dirlist = $dirs = array();
$base_upload_dir = 'upload/flash/';
$dirs = GetDirList($base_upload_dir);
array_unshift($dirs, $base_upload_dir);
/*$docroot = substr($activepath, 0, strrpos($activepath, $base_upload_dir));
$curdir = str_replace($docroot, '', $activepath)."/";*/
?>
<!-- 文件列表完 -->
<tr>
<td colspan='3' bgcolor='#E8F1DE'>

<table width='100%'>
<form action='select_flash_post.php' method='POST' enctype="multipart/form-data" name='myform'>
<input type='hidden' name='activepath' value='<?php echo $activepath?>'>
<input type='hidden' name='f' value='<?php echo $f?>'>
<input type='hidden' name='job' value='upload'>
<tr>
<td background="img/tbg.gif" bgcolor="#99CC00">
  &nbsp;<?php _e('Upload');?>： <input type='file' name='uploadfile' style='width:320px'><select name="flashdir" id="gtcurdir">
  <?php
    // if($curdir==$dir){selected="true"}
	foreach($dirs as $dir) {
  ?>
  <option value="<?php echo $dir;?>"><?php echo $dir;?></option>
  <?php }?>
  </select>
  <a href="javascript:void(0);" style="color:#FF0000;" onclick="addSort(this)"><?php _e('New Folder');?></a>&nbsp;<span style="display:none;">
  <input autocomplete="off" type="text" onkeyup="value=value.replace(/[^\w\)\(\- ]/g,'')" size="10" /><input type="button" onclick="newDir(this)" name="btnSubmit" value=" <?php _e('New');?> " /></span>&nbsp;<input type='submit' name='sb1' value="<?php _e('Upload');?>">
</td>
</tr>
</form>
</table>

</td>
</tr>
</table>

</td>
</tr>
</table>

</body>
</html>