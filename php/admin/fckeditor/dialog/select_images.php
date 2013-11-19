<?php
require_once(dirname(__FILE__)."/../common.inc.php");
//if (!defined('IN_CONTEXT')) die('access violation error!');
include(SSROOT.'/data/inc_mark_config.php');
if(empty($activepath))
{
	$activepath = '';
}
if(empty($imgstick))
{
	$imgstick = '';
}
//$activepath = str_replace('.','',$activepath);
//$activepath = str_replace("/","/",$activepath);
if(strlen($activepath) < strlen($cfg_image_dir))
{
	$activepath = $cfg_image_dir;
}
$inpath = $cfg_basedir.$activepath;
$activeurl = '..'.$activepath;
if(empty($f))
{
	$f = 'form1.picname';
}
if(empty($v))
{
	$v = 'picview';
}
if(empty($comeback))
{
	$comeback = '';
}

?>
<html>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
<title><?php _e('Image Browser');?></title>
<link href='img/base.css' rel='stylesheet' type='text/css'>
<style>
.linerow {border-bottom: 1px solid #D5D59D;}
.napisdiv {left:40;top:3;width:150px;height:100px;position:absolute;z-index:3;display:none;}
</style>
<script>
function nullLink(){ return; }
function ChangeImage(surl){ document.getElementById('picview').src = surl; }
</script>
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
<div id="floater" class="napisdiv">
<a href="javascript:nullLink();" onClick="document.getElementById('floater').style.display='none';"><img src='img/picviewnone.gif' id='picview' border='0' alt="<?php _e('Click to close preview');?>"></a>
</div>
<SCRIPT language=JavaScript>
function nullLink(){ return; }
function ChangeImage(surl){ document.getElementById('floater').style.display='block';document.getElementById('picview').src = surl; }
function TNav()
{
	if(window.navigator.userAgent.indexOf("MSIE")>=1) return 'IE';
  else if(window.navigator.userAgent.indexOf("Firefox")>=1) return 'FF';
  else return "OT";
}
function ReturnImg(reimg)
{
	window.opener.document.<?php echo $f?>.value=reimg;
	if(window.opener.document.getElementById('div<?php echo $v?>'))
  {
  	 if(TNav()=='IE'){
  	 	 window.opener.document.getElementById('div<?php echo $v?>').filters.item('DXImageTransform.Microsoft.AlphaImageLoader').src = reimg;
  	 	 window.opener.document.getElementById('div<?php echo $v?>').style.width = '150px';
  	 	 window.opener.document.getElementById('div<?php echo $v?>').style.height = '100px';
  	 }
  	 else
  	 	 window.opener.document.getElementById('div<?php echo $v?>').style.backgroundImage = "url("+reimg+")";
  }
	else if(window.opener.document.getElementById('<?php echo $v?>')){
		window.opener.document.getElementById('<?php echo $v?>').src = reimg;
	}
	if(document.all) window.opener=true;
  window.close();
}
</SCRIPT>
<table width='100%' border='0' cellspacing='0' cellpadding='0' align="center">
<tr>
<td colspan='4' align='right'>
<table width='100%' border='0' cellpadding='0' cellspacing='1' bgcolor='#CBD8AC'>
<tr bgcolor='#FFFFFF'>
<td colspan='4'>
<table width='100%' border='0' cellspacing='0' cellpadding='2'>
<tr bgcolor="#CCCCCC">
<td width="8%" align="center" class='linerow' bgcolor='#EEF4EA'><strong><?php _e('Preview');?></strong></td>
<td width="47%" align="center" background="img/wbg.gif" class='linerow'><strong><?php _e('Click the name to select a picture');?></strong></td>
<td width="15%" align="center" bgcolor='#EEF4EA' class='linerow'><strong><?php _e('File Size');?></strong></td>
<td width="30%" align="center" background="img/wbg.gif" class='linerow'><strong><?php _e('Last modified');?></strong></td>
</tr>
<tr>
<td class='linerow' colspan='4' bgcolor='#F9FBF0'>
<?php _e("Click the 'V' preview image, click on the image name select pictures, images, and click the picture off the preview.")?>
</td>
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

	if($file == ".") continue;
	else if($file == ".."){
		if($activepath == "") continue;
		$path = pathinfo($activepath);
		$tmp = $path['dirname'];
		$line = "\n<tr>
   <td class='linerow' colspan='2'>
   <a href='select_images.php?imgstick=$imgstick&v=$v&f=$f&activepath=".urlencode($tmp)."'><img src=img/dir2.gif border=0 width=16 height=16 align=absmiddle>".__('Parent directory')."</a></td>
   <td colspan='2' class='linerow'> ".__('Current directory').":".str_replace($cfg_cmspath,$cfg_cmspath2,$activepath)."</td>
   </tr>
   ";
		echo $line;
	}
	else if(is_dir("$inpath/$file")){
		if(preg_match("/^_(.*)$/i",$file)) continue; #屏蔽FrontPage扩展目录和linux隐蔽目录
		if(preg_match("/^\.(.*)$/i",$file)) continue;
		$line = "\n<tr>
   <td bgcolor='#F9FBF0' class='linerow' colspan='2'>
   <a href='select_images.php?imgstick=$imgstick&v=$v&f=$f&activepath=".urlencode("$activepath/$file")."'><img src=img/dir.gif border=0 width=16 height=16 align=absmiddle>$file</a></td>
   <td class='linerow'>　</td>
   <td bgcolor='#F9FBF0' class='linerow'>　</td>
   </tr>";
		echo "$line";
	}
	else if(preg_match("/\.(gif|png)/i",$file)){

		// 中文乱码
		if (preg_match("/^WIN/i", PHP_OS) && preg_match("/[\x80-\xff]./", $file)) $file = iconv('GBK', 'UTF-8', $file);
		
		$reurl = "$activeurl/$file";
		$reurl = preg_replace("/^\.\./","",$reurl);

		if($file==$comeback) $lstyle = " style='color:red' ";
		else  $lstyle = "";

		$line = "\n<tr>
   <td align='center' class='linerow' bgcolor='#F9FBF0'>
   <a href=\"#\" onClick=\"ChangeImage('$reurl');\"><img src='img/picviewnone.gif' width='16' height='16' border='0' align=absmiddle></a>
   </td>
   <td class='linerow' bgcolor='#F9FBF0'>
   <a href=# onclick=\"ReturnImg('$reurl');\" $lstyle><img src=img/gif.gif border=0 width=16 height=16 align=absmiddle>$file</a></td>
   <td class='linerow'>$filesize KB</td>
   <td align='center' class='linerow' bgcolor='#F9FBF0'>$filetime</td>
   </tr>";
		echo "$line";
	}
	else if(preg_match("/.(jpg)/i",$file)){

		// 中文乱码
		if (preg_match("/^WIN/i", PHP_OS) && preg_match("/[\x80-\xff]./", $file)) $file = iconv('GBK', 'UTF-8', $file);

		$reurl = "$activeurl/$file";
		$reurl = preg_replace("/^\.\./","",$reurl);

		if($file==$comeback) $lstyle = " style='color:red' ";
		else  $lstyle = "";
		
		$line = "\n<tr>
   <td align='center' class='linerow' bgcolor='#F9FBF0'>
   <a href=\"#\" onClick=\"ChangeImage('$reurl');\"><img src='img/picviewnone.gif' width='16' height='16' border='0' align=absmiddle></a>
   </td>
   <td class='linerow' bgcolor='#F9FBF0'>
   <a href=# onclick=\"ReturnImg('$reurl');\" $lstyle><img src=img/jpg.gif border=0 width=16 height=16 align=absmiddle>$file</a>
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
$base_upload_dir = 'upload/image/';
$dirs = GetDirList($base_upload_dir);
array_unshift($dirs, $base_upload_dir);
/*$docroot = substr($activepath, 0, strrpos($activepath, $base_upload_dir));
$curdir = str_replace($docroot, '', $activepath)."/";*/
?>
<tr>
<td colspan='4' bgcolor='#E8F1DE'>

<table width='100%'>
<form action='select_images_post.php' method='POST' enctype="multipart/form-data" name='myform'>
<input type='hidden' name='activepath' value='<?php echo $activepath?>'>
<input type='hidden' name='f' value='<?php echo $f?>'>
<input type='hidden' name='v' value='<?php echo $v?>'>
<input type='hidden' name='imgstick' value='<?php echo $imgstick?>'>
<input type='hidden' name='job' value='upload'>
<tr>
<td background="img/tbg.gif" bgcolor="#99CC00">
  &nbsp;<?php _e('Upload');?>： <input type='file' name='imgfile' style='width:250px'/>
  <select name="imgdir" id="gtcurdir">
  <?php
    // if($curdir==$dir){selected="true"}
	foreach($dirs as $dir) {
  ?>
  <option value="<?php echo $dir;?>"><?php echo $dir;?></option>
  <?php }?>
  </select>
  <a href="javascript:void(0);" style="color:#FF0000;" onclick="addSort(this)"><?php _e('New Folder');?></a>&nbsp;<span style="display:none;">
  <input autocomplete="off" type="text" onkeyup="value=value.replace(/[^\w\)\(\- ]/g,'')" size="10" /><input type="button" onclick="newDir(this)" name="btnSubmit" value=" <?php _e('New');?> " /></span>
  <input type='checkbox' name='needwatermark' value='1' class='np' <?php if($photo_markup=='1') echo "checked"; ?> /><?php _e('IsWatermark');?>
  <input type='checkbox' name='resize' value='1' class='np' /><?php _e('Narrow');?>
  <?php _e('Width');?>：<input type='text' style='width:30' name='iwidth' value='<?php echo $cfg_ddimg_width?>' />
  <?php _e('Height');?>：<input type='text' style='width:30' name='iheight' value='<?php echo $cfg_ddimg_height?>' />
  <input type='submit' name='sb1' value="<?php _e('Upload');?>" />
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
</td>
</tr>
</table>
</body>
</html>