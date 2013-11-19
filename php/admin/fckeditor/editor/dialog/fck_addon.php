<?php
require_once(dirname(__FILE__)."/../../common.inc.php");
?>
<html>
<head>
<title><?php _e('Insert Addon');?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<style>
.td{font-size:10pt;}
</style>
<script src="common/fck_dialog_common.js" type="text/javascript"></script>
<script language=javascript>
var dialog = window.parent ;
var oEditor	= window.parent.InnerDialogLoaded() ;
var oDOM		= oEditor.FCK.EditorDocument ;
var FCK = oEditor.FCK;

window.onload = function()
{
	oEditor.FCKLanguageManager.TranslatePage(document) ;
	window.parent.SetOkButton( true ) ;
}

function Ok()
{
    var rurl,widthdd,heightdd,rvalue,rurlname,addonname;
    rurlname = form1.rurl.value;
    addonname = form1.rname.value;
    if(addonname=='') addonname = rurlname;
    rurl = encodeURI(form1.rurl.value);
    rvalue = "<table width='450'>";
    rvalue += "<tr><td height='30' width='20'>";
    rvalue += "<a href='"+rurl+"' target='_blank'><img src='<?php echo $cfg_phpurl; ?>/img/addon.gif' border='0' align='center'></a>";
    rvalue += "</td><td>";
    rvalue += "<a href='"+ rurl +"' target='_blank'><u>"+ addonname +"</u></a>";
    rvalue += "</td></tr></table>";
    oEditor.FCK.InsertHtml(rvalue);
    return true;
}
 
function SelectAddon(fname)
{
   if(document.all){
     var posLeft = window.event.clientY-100;
     var posTop = window.event.clientX-400;
   }
   else{
     var posLeft = 100;
     var posTop = 100;
   }
   window.open("../../dialog/select_soft.php?f="+fname, "popUpSoftWin", "scrollbars=yes,resizable=yes,statebar=no,width=800,height=350,left="+posLeft+", top="+posTop);
}

function addon_check() {
	var tmp = document.getElementById('rname');
	
	if (tmp.value == "<?php _e('Enter the name of the attachment here');?>") {
		alert("<?php _e('Please input attachment name!');?>");
		tmp.value = '';
		tmp.style.color = "#000";
		tmp.focus();
	} else if (!tmp.value.length) {
		alert("<?php _e('Please input attachment name!');?>");
		tmp.style.color = "#000";
		tmp.focus();
	} else {
		SelectAddon('form1.rurl')
	}
}
</script>
</head>
<body bgcolor="#EBF6CD" topmargin="8">
  <form name="form1" id="form1">
  	<table border="0" width="98%" align="center">
    <tr> 
      <td align="right"><?php _e('Addon Name');?>:</td>
      <td colspan="3">
      	<input name="rname" type="text" id="rname" onfocus="this.style.color='#000';this.value=''" style="width:250px;color:#C6C6C6" value="<?php _e('Enter the name of the attachment here');?>">
      </td>
    </tr>
    <tr> 
      <td align="right"><?php _e('Url');?>:</td>
      <td colspan="3">
      	<input name="rurl" type="text" id="rurl" style="width:250px" value="http://">
      	<input type="button" name="selmedia" class="binput" style="width:60px" value="<?php _e('Browse Server ...');?>" onClick="addon_check()">
      </td>
    </tr>
  </table>
  </form>
</body>
</HTML>

