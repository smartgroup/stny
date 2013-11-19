<?php


if (!defined('IN_CONTEXT')) die('access violation error!');

/**
 * Role object
 * 
 */
class Role extends RecordObject {
       public static function rolepermissioncheckbox($module,$action,$label,$permissions=array()) {
             $html='';
	   $ispermission=self::isActionPermission($module, $action, $permissions);
	   if($ispermission){
		$checkstr='checked="checked" class="input_align_5" ';
	   }else{
		$checkstr=' class="input_align_5" ';	   
	   }
	  $html.=Html::input('checkbox', 'permission['.$module.'][]', $action,$checkstr );
	  $html.=" $label &nbsp;";
	  return $html;
       }
		
	public static function isActionPermission($module,$action,$permissions=array()) {
	      	$globalpermission=self::getGlobalPermission();
		if($module=='mod_roles') return false;
                list($module, $action)=self::transferToEqAction($module,$action);
	          if(isset($permissions[$module])){
			$actionarr=	$permissions[$module];
			if(in_array($action,$actionarr)){
				return true;
			}
		 }
		  if(isset($globalpermission[$module])){
			$actionarr=$globalpermission[$module];
			if(in_array($action,$actionarr)){
				return false;
			}
		 }
		 return true;
		
	}
	
	public static function getRolePermission($rolename) {
			$roleobj=new Role();
			$rolename=str_replace(array('{','}'),'',$rolename);
			$role=$roleobj->find('name=?', array($rolename));
			$paramserial=$role->permission;
			if(empty($paramserial)) $param=array();
			else $param=unserialize($paramserial);
			return $param;
	}
	
	public static function getRoleDesc($rolename) {
		static $allroledesc;
		if(!isset($allroledesc)){
			$db =& MysqlConnection::get();
			$prefix=Config::$tbl_prefix;
			$sql="SELECT `name`, `desc`  FROM {$prefix}roles";
			$rs =& $db->query($sql);
			$rows=$rs->fetchRows();
			foreach($rows as $row){
				$allroledesc[$row['name']]=__($row['desc']);
			}
			
		}
		$rolename=str_replace(array('{','}'),'',$rolename);
		return $allroledesc[$rolename];
	}


	public static function isAddBlockModEmpty($permissions=null) {
		 if(!isset($permissions)){
			 if(ACL::isRoleSuperAdmin()) return false;
			 $permissions=ACL::getUserPermission();
		 }
		 

		 if(empty($permissions['add_block'])) return true;
		 return false;
	}


	private static function getGlobalPermission() {
		$permissions=array(
			'mod_article'=>array('admin_list','admin_add','admin_edit','admin_delete'),
			'mod_category_a'=>array('admin_list'),
			'mod_product'=>array('admin_list','admin_add','admin_edit','admin_delete','admin_batch','admin_export'),
			'mod_category_p'=>array('admin_list'),
			'mod_user'=>array('admin_list','admin_add','admin_edit','admin_delete','admin_finance'),
			'mod_bulletin'=>array('admin_list','admin_add','admin_edit','admin_delete'),
			'mod_menu_item'=>array('add_page','del_page','admin_edit'),
			'mod_template'=>array('admin_list'),
			'add_block'=>array('article','product','effect','other','shopping'),
			'edit_block'=>array( 'process'),
			'mod_site'=>array('admin_list','admin_seo'),
			'mod_lang'=>array('admin_list'),
			'mod_payaccount'=>array('admin_list'),
			'mod_navigation'=>array('admin_list'),
			'mod_backup'=>array('admin_list'),
			'mod_attachment'=>array('admin_list'),
			'mod_advert'=>array('admin_list'),
			'mod_message'=>array('admin_list'),
			'mod_filemanager'=>array('admin_dashboard'),
			'mod_order'=>array('admin_list'),
			 'mod_statistics'=>array('admin_list'),
		);	
		return $permissions;
	}
    
	private static function transferExtraModule($module,$action) {
		$ret=array('edit_block','process');
		$globalpermission=self::getGlobalPermission();
		if($module=='mod_static'&&($action=='admin_mi_quick_add'||$action=='admin_create')){
			return array('mod_menu_item','add_page') ;
		}

		if($module=='frontpage'){
			return false ;
		}
		 if(!isset($globalpermission[$module])){
                   return $ret;
             }
		$extraModActionRel=array(
				'mod_menu_item'=>array('admin_list'),
		);
		if(isset($extraModActionRel[$module])){
                    $actionarr=	$extraModActionRel[$module];
                    if(in_array($action,$actionarr)){
                             return $ret;
                    }
		 }
		
		return false;
	}


	private static function transferToEqAction($module,$action) {
                $globalpermission=self::getGlobalPermission();
                 if(isset($permissions[$module])){
                    $actionarr=	$permissions[$module];
                    if(in_array($action,$actionarr)){
                             return array($module,$action);
                    }
                 }
			  if(($ret=self::transferExtraModule($module, $action))!==false){
					return $ret;
			   }
			  $newmodule=$module;
                 $newaction=$action;
                 $allActiontoOne=array(
                     'mod_category_a'=>'admin_list',
                     'mod_category_p'=>'admin_list',
                 );
                 if(isset($allActiontoOne[$module])) $newaction=$allActiontoOne[$module];
                 $transferActionRel=array(
                     'mod_product'=>array('admin_order'=>'admin_edit','admin_pic'=>'admin_edit'),
                      'mod_user'=>array('admin_toggle_active'=>'admin_edit'),
                     'mod_bulletin'=>array('admin_pic'=>'admin_edit'),
                      'mod_article'=>array('admin_order'=>'admin_edit','admin_pic'=>'admin_edit'),
                 );
                 if(isset($transferActionRel[$module])){
                         $actionrel=$transferActionRel[$module];
                         if(isset($actionrel[$action])) $newaction=$actionrel[$action];
                 }
                 return array($newmodule,$newaction);
    }

}
?>