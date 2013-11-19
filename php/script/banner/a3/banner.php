
<LINK href="script/banner/a3/css/css.css" type=text/css rel=stylesheet>

<style type="text/css">
.ddindex_content_lz {
	 WIDTH: <?php echo $img_width;?>px; HEIGHT: <?php echo $img_height+36;?>px; background-color:#FFFFFF;margin:0 auto; padding:0; text-align:center;
}

#lantern {
	BORDER-RIGHT: #878787 0px solid; BORDER-TOP: #878787 0px solid; FONT-SIZE: 10.5pt; OVERFLOW: hidden; BORDER-LEFT: #878787 0px solid; WIDTH: <?php echo $img_width;?>px; CURSOR: pointer; LINE-HEIGHT: 23px; BORDER-BOTTOM: #878787 0px solid; HEIGHT: <?php echo $img_height+36;?>px
}

#lanternMain {
	WIDTH: <?php echo $img_width;?>px; HEIGHT: <?php echo $img_height;?>px; BACKGROUND-COLOR: #ffffff;
}

#lanternImg {
	OVERFLOW: hidden; left:0px; WIDTH: <?php echo $img_width;?>px; position:relative; HEIGHT: <?php echo $img_height;?>px; float:left;
}


</style>
<div id="img_heightnum" style="display:none; width:0px; height:0px;"><?php echo $img_height;?></div>
<div id="img_widthnum" style="display:none; width:0px; height:0px;"><?php echo $img_width;?></div>
<div id="img_alt_site_name" style="display:none; width:0px; height:0px;"><?php echo $curr_siteinfo->site_name;?></div>
<SCRIPT src="script/banner/a3/js/xixi.js" type=text/javascript></SCRIPT>
<DIV class=ddindex_content_lz id=__E_lunzhuan>
<DIV id=lantern>
<DIV id=lanternMain>
<DIV id=lanternImg></DIV></DIV>
<DIV 
style="BORDER-TOP: #ffffff 1px solid; FLOAT: left; BORDER-BOTTOM: #ffffff 1px solid"><IMG alt="<?php echo $curr_siteinfo->site_name;?>" onclick=Lantern.moveprevious(); src="script/banner/a3/images/index_banner_lz_02_left.gif"></DIV>
<DIV id=lanternNavy></DIV>
<DIV style="BORDER-TOP: #ffffff 1px solid; FLOAT: left; BORDER-BOTTOM: #ffffff 1px solid"><IMG alt="<?php echo $curr_siteinfo->site_name;?>" onclick=Lantern.movenext(); src="script/banner/a3/images/index_banner_lz_02_right.gif"></DIV>
<SCRIPT type=text/javascript>
     document.lanterninfo=function(){
   Lanterninfo=new Array();
   Lanterninfo=[    
      <?php
		$kkk=1;
		foreach($img_order as $k=>$v){
			$urlhttp="";
			$classname=',';
			$fname=',';
			$pushLink='';
			if($kkk==1){$classname='';}
			if($linkaddr[$k]&&$islink[$k]=='yes'){$urlhttp=$linkaddr[$k];}
			if($urlhttp=='http://'){$urlhttp='';}
			if($urlhttp){
				if (isset($img_open_type[$k+1][0])&&$img_open_type[$k+1][0]=='1'){ 
					$tag_target = "_self"; 
				}else{ 
					$tag_target = "_blank";
				} 
				
		?>
 <?php echo $classname;?>['<?php echo $img_src[$k]; ?>','<?php echo $sp_title[$k];?>','<?php echo $urlhttp;?>','<?php echo $tag_target; ?>']
               <?php
			}else{
			?>
 <?php echo $classname;?>['<?php echo $img_src[$k]; ?>','<?php echo $sp_title[$k];?>','#']
          <?php
			}
		
			$pushLink.=$fname.'"'.$urlhttp.'"';
			
		$kkk++;
		}
		?>   

       ];
       return Lanterninfo;
   } 
   Lantern.info=new Array();
   Lantern.info=document.lanterninfo();
   Lantern.init();
</SCRIPT>
</DIV></DIV>
