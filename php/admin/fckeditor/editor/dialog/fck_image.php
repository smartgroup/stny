<?php
require_once(dirname(__FILE__)."/../../common.inc.php");
require_once(SSROOT.'/library/to_pinyin.php');
require_once(SSROOT.'/library/toolkit.php');
require_once(SSROOT.'/library/image.func.php');
if(empty($dopost)) $dopost = '';
$imgwidthValue =ParamHolder::get("w",0);
$imgheightValue=ParamHolder::get("h",0);
if(empty($imgwidthValue)) $imgwidthValue = 400;
if(empty($imgheightValue)) $imgheightValue = 300;
if(empty($urlValue)) $urlValue = '';
if(empty($imgsrcValue)) $imgsrcValue = '';
if(empty($imgurl)) $imgurl = '';
if(empty($dd)) $dd = '';
$imgHtml = '';

if($dopost=='upload')
{
	$imgHtml = '';
	$oknum = 0;
	$alttitle = empty($alttitle) ? 0 : 1;
	for($i=1; $i <= $totalform; $i++)
	{
		$imgfile = ${'imgfile'.$i};
		$altname = empty(${'alt'.$i}) ? '' : ${'alt'.$i};
		$altname = preg_replace("/[\"']/", '', $altname);
		if(!is_uploaded_file($imgfile))
		{
			continue;
		}
		else
		{
			$imgfile_name = ${'imgfile'.$i.'_name'};
			$imgfile_type = ${'imgfile'.$i.'_type'};
		}
	
		if(!preg_match("/\.(jpg|gif|png|bmp|pjpeg|jpeg|wbmp)$/i",$imgfile_name)) {
			continue;
		}
		
		$sparr = Array('image/pjpeg','image/jpeg','image/gif','image/png','image/xpng','image/wbmp');
		$imgfile_type = strtolower(trim($imgfile_type));
		if(!in_array($imgfile_type,$sparr)) {
			continue;
		}
	
		/*$nowtme = time();
		$y = MyDate($cfg_addon_savetype, $nowtme);

		$filename = MyDate('ymdHis',$nowtme).'_'.$i;
		
		if(!is_dir($cfg_basedir.$cfg_image_dir."/$y"))
		{
			MkdirAll($cfg_basedir.$cfg_image_dir."/$y", $cfg_dir_purview);
		}*/
		$imgfile_name= Toolkit::changeFileNameChineseToPinyin($imgfile_name);
		$fs = explode('.', $imgfile_name);
		if(preg_match("/php|asp|pl|shtml|jsp|cgi/i", $fs[count($fs)-1])) {
			continue;
		}
		static $dir_flag = 1;
		if (isset($_POST['imgdir']) && !empty($_POST['imgdir']) && $dir_flag==1) {
			$cfg_image_dir = str_replace('upload/image', trim($_POST['imgdir']), $cfg_image_dir);
			$dir_flag++;
		}
		//$bfilename = $cfg_image_dir."/$y/".$filename.".".$fs[count($fs)-1];
		$bfilename = $cfg_image_dir.$imgfile_name;
		//$litfilename = $cfg_image_dir."/$y/".$filename."_lit.".$fs[count($fs)-1];
		//$dbbigfile = $filename.".".$fs[count($fs)-1];
		//$dblitfile = $filename."_lit.".$fs[count($fs)-1];
		$fullfilename = $cfg_basedir.$bfilename;
		
		// for chinese encoding
		if (preg_match("/^WIN/i", PHP_OS) && preg_match("/[\x80-\xff]./", $fullfilename)) $fullfilename = iconv('UTF-8', 'GBK//IGNORE', $fullfilename);
		if(file_exists($fullfilename)) {
			// rename same filename
			$shortname = basename($fullfilename);
			$fname = substr($shortname, 0, strrpos($shortname, "."));
			$exten = substr($shortname, strrpos($shortname, "."));
			$imgfile_name = $fname.randomStr().$exten;
			$fullfilename = str_replace($shortname,$imgfile_name,$fullfilename);
			$bfilename = str_replace($shortname,$imgfile_name,$bfilename);
//			ShowMsg(__('Directory file already exists, please change!'),"-1");
//			exit();
		}
		$litfilename = $cfg_image_dir.substr($imgfile_name, 0, strrpos($imgfile_name, "."))."_lit.".$fs[count($fs)-1];
		$full_litfilename = $cfg_basedir.$litfilename;

		@move_uploaded_file($imgfile,$fullfilename);
		ParamParser::fire_virus($fullfilename);
		if($dd=='yes')
		{
			// for chinese encoding
			if (preg_match("/^WIN/i", PHP_OS) && preg_match("/[\x80-\xff]./", $full_litfilename)) $full_litfilename = iconv('UTF-8', 'GBK//IGNORE', $full_litfilename);
			copy($fullfilename,$full_litfilename);
			if(in_array($imgfile_type,$cfg_photo_typenames))
			{
				ImageResize($full_litfilename,$w,$h);
			}
			$urlValue = $bfilename;
			$imgsrcValue = $litfilename;
		}
		else
		{
			$imgsrcValue = $bfilename;
			$urlValue = $bfilename;
			$info = '';
			$sizes = getimagesize($fullfilename,$info);
			$imgwidthValue = $sizes[0];
			$imgheightValue = $sizes[1];
			$imgsize = filesize($fullfilename);
		}

		if(!isset($needwatermark)){
			$needwatermark='0';
		}
		if($needwatermark == '1')
		{
			if(in_array($imgfile_type,$cfg_photo_typenames))
			{
				if(strtoupper(substr(PHP_OS,0,3))!=='WIN'){
					$fullfilename = SSROOT.'/upload/image/'.$imgfile_name;
				}
				WaterImg($fullfilename,'up');
			}
		}
		
		$oknum++;
		
		 $imgHtml .=  "<img src=\"$imgsrcValue\" width=\"$imgwidthValue\" border=\"0\" height=\"$imgheightValue\" alt=\"$altname\" style=\"cursor:pointer;float:{$float};\" onclick=\"window.open('$urlValue')\" /><p></p>";
			
		 if($alttitle==1 && !empty($altname)) {
		 	$imgHtml .= "$altname<br />\r\n";
		 }
	}
}

function randomStr($len = 6) {
	$randstr = '';
    $chars = 'abcdefghijklmnopqrstuvwxyz1234567890';
    
    if (!is_integer($len) || $len < 6) {
        $len = 6;
    }
    for ($i = 0; $i < $len; $i++) {
        $idx = mt_rand(0, strlen($chars) - 1);
        $randstr .= substr($chars, $idx, 1);
    }
    
    return $randstr;
}
?>
<html>
<head>
<title><?php _e('Insert Image');?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<style>
td { font-size:12px; }
input { font-size:12px; }
.spdiv { height:3px; margin-top:3px; border-top:1px dashed #333; font-size:1px; }
</style>
<script language=javascript>
var oEditor	= window.parent.InnerDialogLoaded() ;
var oDOM		= oEditor.FCK.EditorDocument ;
var FCK = oEditor.FCK;
var picnum = 1;

function getRadioValue(name){
var radioes = document.getElementsByName(name);
for(var i=0;i<radioes.length;i++)
{
     if(radioes[i].checked){
      return radioes[i].value;
     }
}
return false;
}
function ImageOK()
{
	var inImg,ialign,iurl,imgwidth,imgheight,ialt,isrc,iborder;
	ialign = document.form1.ialign.value;
	iborder = document.form1.border.value;
	imgwidth = document.form1.imgwidth.value;
	imgheight = document.form1.imgheight.value;
	ialt = document.form1.alt.value;
	isrc = document.form1.imgsrc.value;
	iurl = document.form1.url.value;
	ifloat = getRadioValue("float_s");
	
    if(isrc==''){
        alert('<?php _e('Url cannot be empty');?>');
        document.form1.imgsrc.focus();
        return;
    } 
	if(ialign!=0) ialign = " align=\""+ialign+"\"";
	inImg  = "<img src=\""+ isrc +"\" width=\""+ imgwidth;
	inImg += "\" height=\""+ imgheight +"\" border=\""+ iborder +"\" style=\"float:"+ ifloat +";\" alt=\""+ ialt +"\""+ialign+" />";
	if(iurl!="") inImg = "<a href=\""+ iurl +"\" target=\"_blank\">"+ inImg +"</a>\r\n";
	//FCK.InsertHtml(inImg);
	var newCode = FCK.CreateElement('DIV');
  newCode.innerHTML = inImg;
  window.parent.Cancel();
}

function ImageOK2()
{
	var iimghtml = document.form1.imghtml.value;
	FCK.InsertHtml(iimghtml);
	//var newCode = FCK.CreateElement('DIV');
  //newCode.innerHTML = iimghtml;
  window.parent.Cancel();
}

function SelectMedia(fname)
{
   if(document.all){
     var posLeft = window.event.clientY-100;
     var posTop = window.event.clientX-400;
   }
   else{
     var posLeft = 100;
     var posTop = 100;
   }
   window.open("../../dialog/select_images.php?f="+fname+"&imgstick=big", "popUpImgWin", "scrollbars=yes,resizable=yes,statebar=no,width=950,height=400,left="+posLeft+", top="+posTop);
}
function SeePic(imgid,fobj)
{
   if(!fobj) return;
   if(fobj.value != "" && fobj.value != null)
   {
     var cimg = document.getElementById(imgid);
     if(cimg) cimg.src = fobj.value;
   }
}
function UpdateImageInfo()
{
	var imgsrc = document.form1.imgsrc.value;
	if(imgsrc!="")
	{
	  var imgObj = new Image();
	  imgObj.src = imgsrc;
	  document.form1.himgheight.value = imgObj.height;
	  document.form1.himgwidth.value = imgObj.width;
	  document.form1.imgheight.value = imgObj.height;
	  document.form1.imgwidth.value = imgObj.width;
  }
}
function UpImgSizeH()
{
   var ih = document.form1.himgheight.value;
   var iw = document.form1.himgwidth.value;
   var iih = document.form1.imgheight.value;
   var iiw = document.form1.imgwidth.value;
   if(ih!=iih && iih>0 && ih>0 && document.form1.autoresize.checked)
   {
      document.form1.imgwidth.value = Math.ceil(iiw * (iih/ih));
   }
}
function UpImgSizeW()
{
   var ih = document.form1.himgheight.value;
   var iw = document.form1.himgwidth.value;
   var iih = document.form1.imgheight.value;
   var iiw = document.form1.imgwidth.value;
   if(iw!=iiw && iiw>0 && iw>0 && document.form1.autoresize.checked)
   {
      document.form1.imgheight.value = Math.ceil(iih * (iiw/iw));
   }
}

function AddForm()
{
	picnum++;
	document.getElementById('moreupload').innerHTML += "<div class='spdiv'>&nbsp;</div><?php _e('Image');?>"+picnum+"：<input name='imgfile"+picnum+"' type='file' id='imgfile"+picnum+"' class='binput' />\r\n";
	document.getElementById('moreupload').innerHTML += "<br /><?php _e('ALT Info');?>：<input type='text' name='alt"+picnum+"' value='' style='width:60%' /><br />\r\n";
	document.form1.totalform.value = picnum;
}
</script>
<base target="_self" />
</HEAD>
<body bgcolor="#EBF6CD" leftmargin="4" topmargin="2">
<form enctype="multipart/form-data" name="form1" id="form1" method="post">
<?php
//上传后返回的内容
if($imgHtml != '')
{
?>
<table width="100%" border="0">
	<tr>
		<td nowrap='1'>
		<fieldset>
			<legend><?php _e('HTML upload images obtained information');?></legend>
			<textarea name='imghtml' style='width:100%;height:250px;'><?php echo $imgHtml; ?></textarea>
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td nowrap='1'>&nbsp;</td>
				</tr>
				<tr height="28">
					<td align='center'>
            <input type="button" name="imgok" id="imgok" onclick='ImageOK2()' value=" <?php _e('Inserted into the editor');?>  " style="height:24px" class="binput" />
          </td>
				</tr>
			</table>
			</fieldset>
		</td>
	</tr>
</table>			
<?php
//默认显示内容
} else {
// for making directory
$dirlist = $dirs = array();
$base_upload_dir = 'upload/image/';
?>
<input type="hidden" name="dopost" value="upload" />
<input type="hidden" name="himgheight" value="<?php echo $imgheightValue;?>" />
<input type="hidden" name="himgwidth" value="<?php echo $imgwidthValue;?>" />
<input type="hidden" name="arctitle" id="arctitle" value="" />
<input type="hidden" name="totalform" value="1" />
<table width="100%" border="0">
	<tr>
		<td nowrap='1'>
		<fieldset>
			<legend><?php _e('Upload New Photo');?></legend>
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr height="30">
					<td align="right" valign='top' nowrap='1'><?php _e('Photo');?>：</td>
					<td nowrap='1'>
						<?php _e('Image');?>1：<input name="imgfile1" type="file" id="imgfile1" class="binput" />
						<br />
						<?php _e('ALT Info');?>：<input type='text' name='alt1' value='' style='width:60%' />
					  <div id='moreupload'></div>
					  <div style='height:3px;margin-top:3px;font-size:1px'>&nbsp;</div>
					</td>
				</tr>
				<tr height="30">
					<td align="right" nowrap='1' style='border-top:1px dashed #333;padding-top:3px'><?php _e('Option');?>：</td>
					<td nowrap='1' style='border-top:1px dashed #333;padding-top:3px'>
						<input type="checkbox" name="dd" value="yes" <?php if($photo_thumb=='1') echo "checked"; ?> /><?php _e('Generate Thumb');?> &nbsp;
						<?php _e('Width');?>
						<input name="w" type="text" value="<?php echo $photo_twidth;?>" size="3" />
						<?php _e('Height');?>
						<input name="h" type="text" value="<?php echo $photo_theight;?>" size="3" />
						<br />
						<input type='checkbox' name='alttitle' value='1' /><?php _e('ALT plus the next line in the picture caption describes as');?>
					</td>
				</tr>
				<tr height="30">
					<td align="right" nowrap='1' style='border-top:1px dashed #333;padding-top:3px'><?php _e('Upload path');?>：</td>
					<td nowrap='1' style='border-top:1px dashed #333;padding-top:3px'>
					<script type="text/javascript" language="javascript" src="../../../../script/jquery.min.js"></script>
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
							alert("<?php _e('Please input directory name!');?>");
							$(obj).prev().focus();
							return false;
						} else {
						    $.ajax({
						        type     : "GET",
						        dataType : "text",
						        url      : "../../mkdir.ajax.php?basedir="+basepth+"&newdir="+pth,
						        success  : function(response) {
						        	switch (response) {
						        		case '0':
						        		    $(obj).prev().val('');
									        $(obj).parent().css('display','none');
									        $(obj).parent().parent().find('a').css('display','inline-block');
									        $('<option value="'+basepth+pth+'/" selected="true">'+basepth+pth+'/</option>').appendTo('#gtcurdir');
						        			break;
						        		case '-1':
							    			alert('The folder is exist!');
							    		    $(obj).prev().focus();
							    			break;
							    		case '-2':
							    			alert('Make directory failed!');
							    			break;
						        	}
						        },
						        error    : function(response) {
						        	alert('failed');
						    		return false;
						        }
						    });
						}
					}	
					</script>
					<select name="imgdir" id="gtcurdir"><option value="<?php echo $base_upload_dir;?>"><?php echo $base_upload_dir;?></option>
					  <?php
						$dirs = GetDirList($base_upload_dir);  
						foreach($dirs as $dir) {
					  ?>
					  <option value="<?php echo $dir;?>"><?php echo $dir;?></option>
					  <?php }?>
					</select>
					<a href="javascript:void(0);" style="color:#FF0000;" onclick="addSort(this)"><?php _e('New Folder');?></a>&nbsp;<span style="display:none;">
					<input autocomplete="off" type="text" onkeyup="value=value.replace(/[^\w\)\(\- ]/g,'')" size="10" /><input type="button" onclick="newDir(this)" name="btnSubmit" value=" <?php _e('New');?> " /></span>
					</td>
				</tr>
				<tr height="36">
				<td  align="right" nowrap='1' style='border-top:1px dashed #333;padding-top:3px'><?php _e("Word float"); ?>：</td>
					<td nowrap='1' style='border-top:1px dashed #333;padding-top:3px'>
						<?php _e("None float"); ?><input type="radio" name="float" value="" checked="checked">&nbsp;&nbsp;&nbsp;<?php _e("Float left"); ?><input type="radio" name="float" value="left">&nbsp;&nbsp;&nbsp;<?php _e("Float right"); ?><input type="radio" name="float" value="right">
            </td>
				</tr>
				<tr height="36">
					<td colspan="2">
						&nbsp;
            <input type="button" name="addupload" id="addupload" onclick='AddForm()' value=" <?php _e('Increase the upload box');?>  " style="height:24px" class="binput" />
            &nbsp;
            <input type="submit" name="picSubmit" id="picSubmit" value=" <?php _e('Upload');?>  " style="height:24px" class="binput" />
            &nbsp;
            <input type='checkbox' name='needwatermark' value='1' class='np' />
            <?php _e('Add a watermark image is');?>
            </td>
				</tr>
			</table>
			</fieldset>
		</td>
	</tr>
	<tr>
		<td>
			<fieldset>
				<legend><?php _e('Had image');?></legend>
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="65" height="25" align="right"><?php _e('Url');?>：</td>
            <td colspan="2">
              <input name="imgsrc" type="text" id="imgsrc" size="30" onChange="SeePic('picview',this);" value="<?php echo $imgsrcValue;?>" />
              <input onClick="SelectMedia('form1.imgsrc');" type="button" name="selimg" value=" <?php _e('Browse Server ...');?> " class="binput" style="width:100px" />
             </td>
          </tr>
          <tr>
            <td height="25" align="right"><?php _e('Width');?>：</td>
            <td colspan="2" nowrap>
							<input type="text"  id="imgwidth" name="imgwidth" size="8" value="<?php echo $imgwidthValue;?>" onChange="UpImgSizeW()" />
              &nbsp;&nbsp;
              <?php _e('Height');?>: <input name="imgheight" type="text" id="imgheight" size="8" value="<?php echo $imgheightValue;?>" onChange="UpImgSizeH()" />
              <input type="button" name="Submit" value="原始" class="binput" style="width:40" onClick="UpdateImageInfo()" />
              <input name="autoresize" type="checkbox" id="autoresize" value="1" checked='1' />
              <?php _e('Adaptive');?>
            </td>
          </tr>
          <tr height="36">
				<td  align="right" nowrap='1' style='border-top:1px dashed #333;padding-top:3px'><?php _e("Word float"); ?>：</td>
					<td nowrap='1' style='border-top:1px dashed #333;padding-top:3px'>
						<?php _e("None float"); ?><input type="radio" name="float_s" value="" checked="checked">&nbsp;&nbsp;&nbsp;<?php _e("Float left"); ?><input type="radio" name="float_s" value="left">&nbsp;&nbsp;&nbsp;<?php _e("Float right"); ?><input type="radio" name="float_s" value="right">
            </td>
				</tr>
          <tr>
            <td height="25" align="right"><?php _e('Border');?>：</td>
            <td colspan="2" nowrap>
              <input name="border" type="text" id="border" size="4" value="0" />
              &nbsp;<?php _e('Alternative text');?>:
              <input name="alt" type="text" id="alt" size="10" />
            </td>
          </tr>
          <tr>
            <td height="25" align="right"><?php _e('Link');?>：</td>
            <td width="166" nowrap><input name="url" type="text" id="url" size="30"   value="<?php echo $urlValue;?>" /></td>
            <td width="155" align="center" nowrap='1'>&nbsp;</td>
          </tr>
					<tr>
            <td height="25" align="right">
            <?php _e('Align');?>：
            </td>
            <td nowrap='1'>
            <select name="ialign" id="ialign">
                <option value="0" selected><?php _e('Default');?></option>
                <option value="right"><?php _e('Right Justify');?></option>
                <option value="center"><?php _e('Center');?></option>
                <option value="left"><?php _e('Left Justify');?></option>
                <option value="top"><?php _e('Top');?></option>
                <option value="bottom"><?php _e('Bottom');?></option>
              </select>
            </td>
            <td align="right" nowrap='1'>
            	<input onClick="ImageOK();" type="button" name="Submit2" value=" <?php _e('OK');?> " class="binput" />
            </td>
          </tr>
        </table>
      </fieldset>
		</td>
	</tr>
</table>
<?php
}
?>
</form>
</body>
</HTML>