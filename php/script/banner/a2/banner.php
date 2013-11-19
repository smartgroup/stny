<LINK href="script/banner/a2/css/lanrentuku.css" type=text/css rel=stylesheet>
<div id="img_heightnum" style="display:none; width:0px; height:0px;"><?php echo $img_height;?></div>
<div id="img_widthnum" style="display:none; width:0px; height:0px;"><?php echo $img_width;?></div>

<SCRIPT src="script/banner/a2/js/lanrentuku.js" type=text/javascript></SCRIPT>
<style type="text/css">
#imgPlay_cndns2 UL{PADDING: 0px; MARGIN: 0px;}
#imgPlay_cndns2 li{ list-style:none;}
#imgPlay_cndns2 P{PADDING: 0px; MARGIN: 0px;}
#imgPlay_cndns2 A {COLOR: #333}
#imgPlay_cndns2 A:hover {COLOR: #e51a45; TEXT-DECORATION: none}

#imgPlay_cndns2 {
	OVERFLOW: hidden; WIDTH: <?php echo $img_width;?>px; ZOOM: 1; POSITION: relative; HEIGHT: <?php echo $img_height;?>px;margin:0 auto; padding:0; text-align:center; 
}
#imgPlay_cndns2 .imgs IMG {
	BORDER-RIGHT: #dbdbdb 0px solid; PADDING-RIGHT: 0px; BORDER-TOP: #dbdbdb 0px solid; PADDING-LEFT: 0px; PADDING-BOTTOM: 1px; BORDER-LEFT: #dbdbdb 0px solid; WIDTH: <?php echo $img_width;?>px; PADDING-TOP: 1px; BORDER-BOTTOM: #dbdbdb 0px solid
}
#imgPlay_cndns2 .imgs LI {
	FLOAT: left; POSITION: relative
}
#imgPlay_cndns2 .imgs {
	WIDTH: 5760px
}
#imgPlay_cndns2 .btn {
	RIGHT: 12px; OVERFLOW: hidden; WIDTH: 112px; BOTTOM: 12px; TEXT-INDENT: -9999px; POSITION: absolute; HEIGHT: 29px;
}
#imgPlay_cndns2 .btn A {
/*	BACKGROUND: url(images/bg.png) no-repeat;BACKGROUND-POSITION: 0px 0px; DISPLAY: block; WIDTH: 112px; HEIGHT: 29px;*/
}
#imgPlay_cndns2 .btn A:hover {
/*	BACKGROUND: url(images/bg.png) no-repeat;BACKGROUND-POSITION: 0px -30px;*/
}
#imgPlay_cndns2 .prev {
	LEFT: 1px; WIDTH: 46px; CURSOR: pointer; TEXT-INDENT: -9999px; POSITION: absolute; TOP: 110px; HEIGHT: 81px
}
#imgPlay_cndns2 .next {
	LEFT: 1px; WIDTH: 46px; CURSOR: pointer; TEXT-INDENT: -9999px; POSITION: absolute; TOP: 110px; HEIGHT: 81px
}
#imgPlay_cndns2 .next {
	BACKGROUND-POSITION: right 0px; RIGHT: 1px; LEFT: auto
}
#imgPlay_cndns2 .numcndns2 {
	DISPLAY: inline; LEFT: 400px; POSITION: absolute; TOP: <?php echo $img_height;?>px; HEIGHT: 19px
}
#imgPlay_cndns2 .numcndns2 SPAN {
	DISPLAY: inline-block; MARGIN: 0px 2px; OVERFLOW: hidden; WIDTH: 14px; CURSOR: pointer; LINE-HEIGHT: 0; HEIGHT: 13px
}
#imgPlay_cndns2 .numcndns2 SPAN.on {
	BACKGROUND-POSITION: 1px -83px
}
#imgPlay_cndns2 .numcndns2 .lc {
	PADDING-RIGHT: 0px; PADDING-LEFT: 0px;  FLOAT: left; PADDING-BOTTOM: 0px; WIDTH: 13px; PADDING-TOP: 3px; HEIGHT: 16px
}
#imgPlay_cndns2 .numcndns2 .mc {
	PADDING-RIGHT: 0px; PADDING-LEFT: 0px; FLOAT: left; PADDING-BOTTOM: 0px; WIDTH: 13px; PADDING-TOP: 3px; HEIGHT: 16px
}
#imgPlay_cndns2 .numcndns2 .rc {
	PADDING-RIGHT: 0px; PADDING-LEFT: 0px; FLOAT: left; PADDING-BOTTOM: 0px; WIDTH: 13px; PADDING-TOP: 3px; HEIGHT: 16px
}
#imgPlay_cndns2 .numcndns2 .mc {

}
#imgPlay_cndns2 .numcndns2 .rc {

}
#numInner {
	PADDING-RIGHT: 0px; PADDING-LEFT: 0px; BACKGROUND: none transparent scroll repeat 0% 0%; PADDING-BOTTOM: 0px; PADDING-TOP: 3px; POSITION: absolute; TOP: <?php echo $img_height;?>px; TEXT-ALIGN: center
}

</style>

<div id=imgPlay_cndns2>
  <ul class=imgs id=actor>
     <?php
		$kkk=1;
		foreach($img_order as $k=>$v){
			$urlhttp="";
			if($linkaddr[$k]&&$islink[$k]=='yes'){$urlhttp=$linkaddr[$k];}
			if($urlhttp){
				if($urlhttp=='http://'){$urlhttp='';}
		?>

             <li><a href="<?php echo $urlhttp;?>" <?php if (isset($img_open_type[$k+1][0])&&$img_open_type[$k+1][0]=='1'){ ?> target="_self" <?php }else{ ?> target="_blank"  <?php } ?>><img title="<?php echo $sp_title[$k];?>" alt="<?php echo $sp_title[$k];?>" src="<?php echo $img_src[$k]; ?>" width="<?php echo $img_width;?>" height="<?php echo $img_height;?>"  /></a>    </li>
               <?php
			}else{
			?>
           <li><a href="#" ><img title="<?php echo $sp_title[$k];?>" src="<?php echo $img_src[$k]; ?>" width="<?php echo $img_width;?>" height="<?php echo $img_height;?>"  /></a>    </li>
          <?php
			}
		
		$kkk++;
		}
		?>
   
  </ul>
 
  <div class=numcndns2>
    <p class=lc></p>
    <p class=mc></p>
    <p class=rc></p>
  </div>
  <div class=numcndns2 id=numInner></div>
  <div class=prev>上一张</div>
  <div class=next>下一张</div>
   <!---->
</div>
