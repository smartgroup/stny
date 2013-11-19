<div style="margin-top:-22px;">
<LINK  href="script/banner/a14/style/style.css" type=text/css rel=stylesheet>

<div id="img_heightnum" style="display:none; width:0px; height:0px;"><?php echo $img_height;?></div>
<div id="img_widthnum" style="display:none; width:0px; height:0px;"><?php echo $img_width;?></div>
<SCRIPT src="script/banner/a14/js/easySlider1.5.js" type=text/javascript></SCRIPT>
<style type="text/css">
#content_cndns14 {
	MARGIN: 0px auto; WIDTH: <?php echo $img_width;?>px; BACKGROUND-COLOR: #ffffff
}
#feature_cndns14 {
	PADDING-RIGHT: 0px; PADDING-LEFT: 0px; PADDING-BOTTOM: 0px; MARGIN: 0px auto; WIDTH: <?php echo $img_width;?>px; PADDING-TOP: 0px; POSITION: relative; HEIGHT: <?php echo $img_height;?>px
}
#feature_cndns14 IMG.featured {
	LEFT: <?php echo $img_width;?>px; POSITION: absolute; TOP: 0px
}
#slider_cndns14 LI {
	OVERFLOW: hidden; WIDTH: <?php echo $img_width;?>px; HEIGHT: <?php echo $img_height;?>px
}
#prevBtn {
	DISPLAY: block; LEFT: <?php echo $img_width-100;?>px; WIDTH: 30px; POSITION: absolute; TOP: <?php echo $img_height-30;?>px; HEIGHT: 28px
}
#nextBtn {
	DISPLAY: block; LEFT: <?php echo $img_width-100;?>px; WIDTH: 30px; POSITION: absolute; TOP: <?php echo $img_height-30;?>px; HEIGHT: 28px
}
#nextBtn {
	LEFT: <?php echo $img_width-50;?>px
}
</style>
<SCRIPT type=text/javascript>
		$(document).ready(function(){	
			$("#slider_cndns14").easySlider({
				auto: true,
				continuous: true 
			});
		});	
	</SCRIPT>

	<div id="content_cndns14">
			<div id="feature_cndns14">
			  <div id="slider_cndns14">
					<ul>				
				
                          <?php
		$kkk=1;
		foreach($img_order as $k=>$v){
			$urlhttp="";
			if($linkaddr[$k]&&$islink[$k]=='yes'){$urlhttp=$linkaddr[$k];}else{$urlhttp="#";}
			if($urlhttp=='http://'){$urlhttp='';}
		?>
        <li><a href="<?php echo $urlhttp;?>" <?php if (isset($img_open_type[$k+1][0])&&$img_open_type[$k+1][0]=='1'){ ?> target="_self" <?php }else{ ?> target="_blank"  <?php } ?>><img src="<?php echo $img_src[$k]; ?>" alt="<?php echo $sp_title[$k];?>"  height="<?php echo $img_height;?>"   width="<?php echo $img_width;?>"/></a></li>
    <?php
		$kkk++;
		}
		?>
					</ul>
				</div>
			</div>
</div>        
</div>