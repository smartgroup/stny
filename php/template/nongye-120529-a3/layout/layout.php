<?php 
if (!defined('IN_CONTEXT')) die('access violation error!');
//鍔犺浇椤甸潰澶撮儴
include_once('view/common/header.php');
?>
   
     <div id="mai01_div">
   <div id="main_div1">
     <!--top-->
<div id="top">
    <div id="header">
		<div id="logo"><?php 
				if (Content::countModules('logo') > 0 || Toolkit::editMode()) {
					echo Content::loadModules('logo');
				} else { ?>
					<a href="/"><img src="<?php echo P_TPL_WEB; ?>/images/logo.jpg" border="0" /></a>
			<?php }?>
            </div>
            
         <!-- 绔欑偣璇█妯″潡Start -->
<div class="switch_langbar" style="float:right;margin-top:15px; margin-right:15px;">
<?php include_once(P_INC.'/language_switch.php');?>
</div>
<!-- 绔欑偣璇█妯″潡End -->
   </div>      
      
</div>
 
    </div>
  <!--top end-->      
  <!--main_div-->
<div id="main_div">

<!--web_bg-->
<div class="web_bg">
  <!--mainmain-->
<div id="main_all">
<div id="mainmain">
  <div id="nav_bg">
 <div id="nav">
	<?php if (Content::countModules('nav') > 0 || Toolkit::editMode()) Content::loadModules('nav'); ?>
	</div>
    </div>
 <div id="banner_bg">
   <div id="banner">
	<?php 
		if (Content::countModules('banner') > 0 || Toolkit::editMode()) 
		{
			echo Content::loadModules('banner');
		} 
		else 
		{ ?>
		<img src="<?php echo P_TPL_WEB; ?>/images/banner.jpg" border="0" />
		<?php }?>
	</div>
    </div>  
	 <div id="main_con" class="web_bg">
    
          <?php 
		//--------------棣栭〉鏍峰紡銆恠tart銆?------------------
		if($_flat_module_class_name == 'frontpage'){
		?>
        
     
        <div id="main_01">
		<div id="left"><?php if (Content::countModules('left') > 0 || Toolkit::editMode()) Content::loadModules('left'); ?></div>
    
        <div id="right"><?php if (Content::countModules('right') > 0 || Toolkit::editMode()) Content::loadModules('right'); ?></div>
</div>

        
 		<?php } 
		//--------------棣栭〉鏍峰紡銆恊nd銆?---------------------	
		//--------------鍐呴〉鏍峰紡銆恠tart銆?-------------------
		else 
		{?>
        
         <div id="use"><?php if (Content::countModules('use') > 0 || Toolkit::editMode()) Content::loadModules('use'); ?></div>
        <div id="left">
		<?php if (Content::countModules('left') > 0 || Toolkit::editMode()) Content::loadModules('left'); ?>
		</div>
		<div id="right">
        <div id="right_bottom">
         <div id="right_mid">
        <?php include_once($_content_); ?>
        </div>
         </div>
		</div>
        <?php 
		//--------------鍐呴〉鏍峰紡銆恊nd銆?---------------------
		}?>
       
        <div class="blankbar"></div>
	</div>
     <div id="use"><?php if (Content::countModules('use') > 0 || Toolkit::editMode()) Content::loadModules('use'); ?></div>
</div>
  
  </div>
<div id="footer_bg">
<?php 
//鍔犺浇椤甸潰灏鹃儴
include_once('view/common/footer.php');
?>
</div>
  <!--main_div end--> 
        </div>
        </div>
 <!--mainmain end-->   
    </div>
<!--web_bg end-->
</div> 
