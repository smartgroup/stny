
<?php
if (!defined('IN_CONTEXT')) die('access violation error!');
?>
<style>

.input_align_5{margin-bottom:1px;margin-top:-2px;vertical-align:middle;}
.font01{font-size:12px; _margin-top:3px;}
#mod_acticle_sapn{ _margin-top:5px;}
.kuan5{ margin-left:10px; margin-top:1px; *margin-top:-1px;   }
.lefttitle{ margin-top:2px !important; margin-top:3px\9 !important; *margin-top:-2px !important;   _margin-top:-3px;}
.lefttitle2{ margin-top:1px !important; margin-top:4px\9 !important; *margin-top:4px !important;   _margin-top:-3px;}
.title{ margin-top:3px;}
</style>
<link rel="stylesheet" href="../script/jquery.cluetip.css" type="text/css" />
<script type="text/javascript" src="../script/jquery.cluetip.min.js"></script>
<script>
$(document).ready(function(){
	$('#answer1').cluetip({splitTitle: '|',width: '300px',height:'80px'});
});
 function  toogle_checkbox(el,spanid){
         var spanel=$('#'+spanid);
         var checked=el.checked;
         spanel.find('input[type=checkbox]').each(function(){
                 var checkboxel=this;
                 checkboxel.checked=checked;
         });
 }
</script>
<div class="iconxian">
     <table width="686" border="0" cellpadding="0" cellspacing="0" class="iconright">
  <tr>
    <td width="153" valign="top"><table width="141" border="0" cellpadding="0" cellspacing="0" class="lefttitle">
      <tr>
        <td width="35"><img src="images/icon1.jpg" width="32" height="32" /></td>
        <td width="72" class="icontitle"><?php _e("Articles");?></td>
        <td width="20">
          <label>
            <?php echo Html::input('checkbox', '', ''," onclick='toogle_checkbox(this,\"mod_acticle_sapn\");' " ); ?>            </label>                </td>
      </tr>
    </table></td>
    <td width="533">
<span id="mod_acticle_sapn">
<?php echo Role::rolepermissioncheckbox('mod_article', 'admin_list', __('View'), $permissions)?>
<?php echo Role::rolepermissioncheckbox('mod_article', 'admin_add', __('Add'), $permissions)?>
      <?php echo Role::rolepermissioncheckbox('mod_article', 'admin_edit', __('Edit'), $permissions)?>
<?php echo Role::rolepermissioncheckbox('mod_article', 'admin_delete', __('Delete'), $permissions)?>
<?php echo Role::rolepermissioncheckbox('mod_category_a', 'admin_list', __('Manage Categories'), $permissions)?></span>	</td>
  </tr>
</table>
</div>
 <div class="iconxian2">
     <table width="754" border="0" cellpadding="0" cellspacing="0" class="iconright">
  <tr>
    <td width="153"><table width="141" border="0" cellpadding="0" cellspacing="0" class="lefttitle">
      <tr>
        <td width="35"><img src="images/icon2.jpg" width="32" height="32" /></td>
        <td width="72" class="icontitle"><?php _e("Products");?> </td>
        <td width="20">
          <label>
            <?php echo Html::input('checkbox', '', ''," onclick='toogle_checkbox(this,\"mod_product_sapn\");' " ); ?>            </label>                </td>
      </tr>
    </table></td>
    <td width="601">
<span id="mod_product_sapn">
<?php echo Role::rolepermissioncheckbox('mod_product', 'admin_list', __('View'), $permissions)?>
<?php echo Role::rolepermissioncheckbox('mod_product', 'admin_add', __('Add'), $permissions)?>
      <?php echo Role::rolepermissioncheckbox('mod_product', 'admin_edit', __('Edit'), $permissions)?>
<?php echo Role::rolepermissioncheckbox('mod_product', 'admin_delete', __('Delete'), $permissions)?>
<?php echo Role::rolepermissioncheckbox('mod_category_p', 'admin_list', __('Manage Categories'), $permissions)?>
<?php echo Role::rolepermissioncheckbox('mod_product', 'admin_batch', __('Batch Import'), $permissions)?>	
<?php echo Role::rolepermissioncheckbox('mod_product', 'admin_export', __('Batch Export'), $permissions)?> </span>	</td>
</tr>
</table>
</div>
<div class="iconxian3">
<table width="600" border="0" cellpadding="0" cellspacing="0" class="iconright">
  <tr>
    <td width="153">
 <table width="141" border="0" cellpadding="0" cellspacing="0" class="lefttitle">
<tr>
        <td width="35"><img src="images/icon3.jpg" width="32" height="32" /></td>
      <td width="72" class="icontitle"><?php _e("Web Edit");?> </td>
        <td width="20">
          <label>
            <?php echo Html::input('checkbox', '', ''," onclick='toogle_checkbox(this,\"mod_webedit_sapn\");toogle_checkbox(this,\"mod_webedit_sapn2\");' " ); ?>            </label>                </td>
      </tr>
    </table></td>
    <td valign="middle">
<span id="mod_webedit_sapn2">
<?php echo Role::rolepermissioncheckbox('edit_block', 'process', __('Layouts'). '&nbsp;<img id="answer1" src="template/images/answer1.gif" alt="help" align="absmiddle" title="'.__('This option control the deletion and move of the block').' "/>', $permissions)?> </span>	</td>
</tr>
</table>

</div>
<span id="mod_webedit_sapn">
<div class="iconxian3" >
 <table border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="153" valign="top"><table width="141" border="0" cellpadding="0" cellspacing="0" class="lefttitle">
      <tr>
        <td width="35">&nbsp;</td>
        <td width="72" class="icontitle1">1.<?php _e('Add Module');?> </td>
        <td width="20">
          <label>
            <?php echo Html::input('checkbox', '', ''," onclick='toogle_checkbox(this,\"mod_addblock_sapn\");' " ); ?>            </label>                </td>
      </tr>
    
    </table></td>      
    <td width="560"><table width="500" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td> 
<span id="mod_addblock_sapn">
<?php echo Role::rolepermissioncheckbox('add_block', 'article', __('Article Category translate'), $permissions)?>
<?php echo Role::rolepermissioncheckbox('add_block', 'product', __('Product Category translate'), $permissions)?>
<?php echo Role::rolepermissioncheckbox('add_block', 'effect', __('Effect Plugins'), $permissions)?>
<?php echo Role::rolepermissioncheckbox('add_block', 'other', __('Other Category'), $permissions)?>
<?php echo Role::rolepermissioncheckbox('add_block', 'shopping', __('Shopping Cart'), $permissions)?>
</span>  		
	   </td>
      </tr>
    </table></td>
		
		</tr>
</table>
</div>
<div class="iconxian3">
 <table width="600" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="149" valign="top"><table width="141" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="35">&nbsp;</td>
        <td width="100" class="icontitle1">2.<?php _e('Add Page');?> </td>
       
      </tr>
    
    </table></td>      
    <td width="437"><table width="87" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td >
			<?php echo Role::rolepermissioncheckbox('mod_menu_item', 'add_page', __('Add Page'), $permissions)?>
          </td>
      </tr>
    </table></td>
  </tr>
</table>

</div>
<div class="iconxian3">
 <table width="600" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="149"><table width="141" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="35">&nbsp;</td>
        <td width="100" class="icontitle1">3.<?php _e('Delete Page');?> </td>
       
      </tr>
    
    </table></td>      
    <td width="437"><table width="87" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td >
			<?php echo Role::rolepermissioncheckbox('mod_menu_item', 'del_page', __('Delete Page'), $permissions)?>
          </td>
      </tr>
    </table></td>
  </tr>
</table>

</div>	
<div class="iconxian3">
 <table width="600" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="149"><table width="141" border="0">
      <tr>
        <td width="32">&nbsp;</td>
        <td width="100" class="icontitle1">4.<?php _e('Page Property');?> </td>
       
      </tr>
    
    </table></td>      
    <td width="437"><table width="87" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td >
			<?php echo Role::rolepermissioncheckbox('mod_menu_item', 'admin_edit', __('Page Property'), $permissions)?>
          </td>
      </tr>
    </table></td>
  </tr>
</table>

</div>		
<div class="iconxian3">
 <table width="600" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="149"><table width="141" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="37">&nbsp;</td>
        <td width="100" class="icontitle1">5.<?php _e('Manage Templates');?> </td>
       
      </tr>
    
    </table></td>      
    <td width="437"><table width="87" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td >			
<?php echo Role::rolepermissioncheckbox('mod_template', 'admin_list', __('Manage Templates'), $permissions)?>
          </td>
      </tr>
    </table></td>
  </tr>
</table>

</div>	
<div class="iconxian5">
 <table width="600" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="157" valign="top"><table width="141" border="0" cellpadding="0" cellspacing="0" class="lefttitle">
      <tr class="lefttitle2">
        <td width="35">&nbsp;</td>
        <td width="72" class="icontitle1">6.<?php _e('Preferences');?> </td>
        <td width="20">
          <label>
          <?php echo Html::input('checkbox', '', ''," onclick='toogle_checkbox(this,\"mod_preferences_sapn\");' " ); ?>            </label>                </td>
      </tr>
    
    </table>
      <p class="lefttitle2">&nbsp;</p></td>     
	<td width="427">
    <table width="400" border="0" align="left" cellpadding="0" cellspacing="0">
  <tr>
    <td width="465" ><table width="440"  border="0" cellpadding="0" cellspacing="0">
      <tr>
        
        <td width="480" valign="top" >
<span id="mod_preferences_sapn">
<table width="600" border="0" cellspacing="0" class="kuan5">
  <tr>
    <td width="123"><?php echo Role::rolepermissioncheckbox('mod_site', 'admin_list', __('Web Set'), $permissions)?></td>
    <td width="103"><?php echo Role::rolepermissioncheckbox('mod_site', 'admin_seo', __('SEO Set'), $permissions)?></td>
    <td width="131"><?php echo Role::rolepermissioncheckbox('mod_lang', 'admin_list', __('Language Manager'), $permissions)?></td>
    <td width="235"><?php echo Role::rolepermissioncheckbox('mod_navigation', 'admin_list', __('Home Navigation'), $permissions)?><br/></td>
  </tr>
  <tr>
    <td><?php echo Role::rolepermissioncheckbox('mod_payaccount', 'admin_list', __('Payment Set'), $permissions)?></td>
    <td><?php echo Role::rolepermissioncheckbox('mod_backup', 'admin_list', __('Data Backup & Recovery'), $permissions)?></td>
    <td><?php echo Role::rolepermissioncheckbox('mod_attachment', 'admin_list', __('Watemark & Thumbnail'), $permissions)?></td>
    <td><?php echo Role::rolepermissioncheckbox('mod_advert', 'admin_list', __('Advert Tool'), $permissions)?><br/></td>
  </tr>
  <tr>
    <td><?php echo Role::rolepermissioncheckbox('mod_message', 'admin_list', __('Message Manage'), $permissions)?></td>
    <td><?php echo Role::rolepermissioncheckbox('mod_filemanager', 'admin_dashboard', __('File Manager'), $permissions)?></td>
    <td><?php echo Role::rolepermissioncheckbox('mod_order', 'admin_list', __('User Order'), $permissions)?></td>
    <td><?php echo Role::rolepermissioncheckbox('mod_statistics', 'admin_list', __('Statistics'), $permissions)?></td>
  </tr>
</table>
</span>					
		</td>
      </tr>
    </table></td>
	</tr>
 </table>
	</td>
	</tr>
 </table>
</div>
</span>
<div class="iconxian">
     <table width="600" border="0" cellpadding="0" cellspacing="0" class="iconright">
  <tr>
    <td width="136"><table width="134" border="0" cellpadding="0" cellspacing="0" class="lefttitle">
      <tr>
        <td width="38"><img src="images/icon4.jpg" width="32" height="32" /></td>
        <td width="79" class="icontitle"><?php _e("Member Manage");?> </td>
        <td width="17">
          <label>
            <?php echo Html::input('checkbox', '', ''," onclick='toogle_checkbox(this,\"mod_member_sapn\");' " ); ?>            </label>                </td>
      </tr>
    </table></td>
    <td width="464"><table border="0">
      <tr>
        
        <td width="243" class="iconxiaotext">
<span id="mod_member_sapn">
<?php echo Role::rolepermissioncheckbox('mod_user', 'admin_list', __('View'), $permissions)?>
<?php echo Role::rolepermissioncheckbox('mod_user','admin_add', __('Add'), $permissions)?>
<?php echo Role::rolepermissioncheckbox('mod_user','admin_edit', __('Edit'), $permissions)?>
<?php echo Role::rolepermissioncheckbox('mod_user', 'admin_delete', __('Delete'), $permissions)?>
<?php echo Role::rolepermissioncheckbox('mod_user', 'admin_finance', __('Finance'), $permissions)?></span>	    </td>
      </tr>
    </table></td>
   
  
  </tr>
</table>

</div>
<div class="iconxian3">
     <table width="600" border="0" cellpadding="0" cellspacing="0" class="iconright">
  <tr>
    <td width="136"><table width="134" border="0" cellpadding="0" cellspacing="0" class="lefttitle">
      <tr>
        <td width="38"><img src="images/icon1.jpg" width="32" height="32" /></td>
        <td width="79" class="icontitle"><?php _e("Bulletins");?> </td>
        <td width="17">
          <label>
            <?php echo Html::input('checkbox', '', ''," onclick='toogle_checkbox(this,\"mod_bulletins_sapn\");' " ); ?>            </label>                </td>
      </tr>
    </table></td>
    <td width="464"><table border="0">
      <tr>
        
        <td width="273" class="iconxiaotext">
<span id="mod_bulletins_sapn">
<?php echo Role::rolepermissioncheckbox('mod_bulletin', 'admin_list', __('View'), $permissions)?>
<?php echo Role::rolepermissioncheckbox('mod_bulletin', 'admin_add', __('Add'), $permissions)?>
      <?php echo Role::rolepermissioncheckbox('mod_bulletin', 'admin_edit', __('Edit'), $permissions)?>
<?php echo Role::rolepermissioncheckbox('mod_bulletin', 'admin_delete', __('Delete'), $permissions)?></span>	    </td>
      </tr>
    </table></td>
    
  </tr>
</table>

</div>