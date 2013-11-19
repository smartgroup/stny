<?php
if (!defined('IN_CONTEXT')) die('access violation error!');

//$content = trim($bulletin->content);
if (sizeof($bulletins_list)) {
?>
<style type="text/css">
.bulletin h4 {font-weight:normal;}
</style>
<div class="list_con notice_con">
	<div class="bulletin" id="marquee_bulletin<?php echo $randstr;?>" style="margin-top:15px;">
	<?php if ($bulletin_type == '1') {?>
	<marquee scrollAmount="2"  scrollDelay="10" Height="100%" onmouseover="this.stop()"  onmouseout="this.start()" direction="up" loop="-1">
	<?php 
		}
		foreach($bulletins_list as $bulletin) {
			echo '<h4><a href="'.Html::uriquery('mod_bulletin', 'bulletin_content', array('bulletin_id' => $bulletin->id)).'">'.$bulletin->title.'</a></h4>';
		}
		if ($bulletin_type == '1') {
	?></marquee><?php }?>
	</div>
</div><div class="list_bot"></div>
<?php
} else {
	echo '<div class="list_main"><div class="marquee bulletin" style="margin-top:15px;">'.__('No Records!').'</div><div class="list_bot"></div></div><div class="blankbar"></div>';
}
if (false) {
?>
<script language="javascript">
<!--
$(function(){
	new Marquee(
    "marquee_bulletin<?php echo $randstr;?>",  //容器ID<br />
    0,  //滚动方向(0向上 1向下 2向左 3向右)<br />
    2,  //滚动步长<br />
    600,  //滚动区域宽度<br />
    100,  //滚动区域高度<br />
    100,  //定时器 数值越小，滚动的速度越快(1000=1秒,建议不小于20)<br />
    0,  //停顿时间(0为不停顿,1000=1秒)<br />
    0,  //开始等待时间(0为不等待,1000=1秒)<br />
    24  //间歇滚动间距(可选)<br />
    );
});
function Marquee(){
  this.ID=document.getElementById(arguments[0]);
  this.Direction=arguments[1];
  this.Step=arguments[2];
  this.Width=arguments[3];
  this.Height=arguments[4];
  this.Timer=arguments[5];
  this.WaitTime=arguments[6];
  this.StopTime=arguments[7];
  if(arguments[8]){this.ScrollStep=arguments[8];}else{this.ScrollStep=this.Direction>1?this.Width:this.Height;}
  this.CTL=this.StartID=this.Stop=this.MouseOver=0;
  this.ID.style.overflowX=this.ID.style.overflowY="hidden";
  this.ID.noWrap=true;
  this.ID.style.width=this.Width;
  this.ID.style.height=this.Height;
  this.ClientScroll=this.Direction>1?this.ID.scrollWidth:this.ID.scrollHeight;
  this.ID.innerHTML+=this.ID.innerHTML;
  this.Start(this,this.Timer,this.WaitTime,this.StopTime);
}
Marquee.prototype.Start=function(msobj,timer,waittime,stoptime){
  msobj.StartID=function(){msobj.Scroll();}
  msobj.Continue=function(){
    if(msobj.MouseOver==1){setTimeout(msobj.Continue,waittime);}
    else{clearInterval(msobj.TimerID); msobj.CTL=msobj.Stop=0; msobj.TimerID=setInterval(msobj.StartID,timer);}
    }
  msobj.Pause=function(){msobj.Stop=1; clearInterval(msobj.TimerID); setTimeout(msobj.Continue,waittime);}
  msobj.Begin=function(){
    msobj.TimerID=setInterval(msobj.StartID,timer);
    msobj.ID.onmouseover=function(){msobj.MouseOver=1; clearInterval(msobj.TimerID);}
    msobj.ID.onmouseout=function(){msobj.MouseOver=0; if(msobj.Stop==0){clearInterval(msobj.TimerID); msobj.TimerID=setInterval(msobj.StartID,timer);}}
    }
  setTimeout(msobj.Begin,stoptime);
}
Marquee.prototype.Scroll=function(){
  this.CTL+=this.Step;
  if(this.CTL>=this.ScrollStep&&this.WaitTime>0){this.ID.scrollTop+=this.ScrollStep+this.Step-this.CTL; this.Pause(); return;}
  else{if(this.ID.scrollTop>=this.ClientScroll) this.ID.scrollTop-=this.ClientScroll; this.ID.scrollTop+=this.Step;}
}
-->
</script>
<?php
}
?>