<?php
if (!defined('IN_CONTEXT')) die('access violation error!');

class ModBackup extends Module {
	// 2010/03/16 Jane Add >>
	var $dir = '../sql/backup';
	// 2010/03/16 Jane Add <<
	
	protected $_filters = array(
        'check_admin' => ''
    );
    
    public function admin_list() {
    	$this->_layout = 'content';
    	$next_action = 'admin_backup';
    	$current_time = date("YmdHis");
	    $random = rand(100,999);
    	$file_name = 'backup_'.$current_time.".sql";
    	$this->assign('next_action', $next_action);
    	$this->assign('file_name', $file_name);
		$this->assign( 'list', $this->get_file_list( $this->dir ) );
    }
    
    public function admin_load()
    {
    	$files = $this->get_file_list( $this->dir );
    	$fid =& ParamHolder::get('_fid', array());
        $file = $this->dir.'/'.$files[$fid]['fname'];
        
        include_once P_LIB."/download.php";
		$o_filedownload = new file_download();
		$o_filedownload->downloadfile( $file );
		die;
    } 
    
    
    
    public function admin_backup() {
		@ini_set('memory_limit','128M');
    	$backup =& ParamHolder::get('backup', array());
    	$user = Config::$db_user;
	  	$password = Config::$db_pass;
		$db_name = Config::$db_name;
		$this->assign('msg','');
    	if(empty($backup['file_name'])) {
    		$this->assign('json', Toolkit::jsonERR(__('Missing site information!')));
            return '_result';
    	} else {
    		@chmod('../sql/backup/',0755);
    		$file_name = '../sql/backup/'.$backup['file_name'];
//    		$command = ROOT."/sql/mysqldump -u$user -p$password $db_name>$file_name";
    		try{
//	        	system($command);
				$db_host = (Config::$db_host).":".(Config::$port);
	    		$link = mysql_connect($db_host,Config::$db_user,Config::$db_pass);
				mysql_select_db(Config::$db_name, $link);
				mysql_query("SET NAMES ".Config::$mysqli_charset ,  $link);
				$res = mysql_query("show tables");
				$tables = array();$sql = "";
				while ($result = mysql_fetch_array($res, MYSQL_NUM)) {
					$tables[] = $result[0];
				}

    			foreach($tables as $k => $v)
    			{
    				$sql .= $this->data2sql($v);
    			}
    			@chmod($file_name,0755);
//    			if (is_writable($file_name)) 
//    			{
				    if (!$handle = fopen($file_name, 'a')) {
				         echo "Can not open $file_name";
				         exit;
				    }
				    if (fwrite($handle, $sql) === FALSE) {
				        echo "Can not write $file_name";
				        exit;
				    }
				    fclose($handle);
//				} 
//				else 
//				{
//				    echo "Can not write $file_name";
//				}
    			
				
	        	$o_backup = new Backup();
	        	$time = time();
	        	$file_name = ROOT."/sql/backup/{$backup['file_name']}";
	        	$o_backup->set(array('create_time' => $time,'file_name' => $file_name));
	        	$o_backup->save();
    		}catch(Exception $ex) {
    			 $this->assign('json', Toolkit::jsonERR($ex->getMessage()));
            	 return '_result';
    		}
	        $this->assign('json', Toolkit::jsonOK(array('forward' => Html::uriquery('mod_backup', 'admin_list'))));
        	return '_result';
    	}
    }
    
    public function admin_delete()
    {
    	$files = $this->get_file_list( $this->dir );
    	$fid =& ParamHolder::get('_fid', '');
        $backup = $this->dir.'/'.$files[$fid]['fname'];
        if (!file_exists($backup)) {
        	$this->assign('json', Toolkit::jsonERR(__('File does not exist!')));
            return '_result';
        } else {
        	chmod($backup, 0755);
        	@unlink($backup);
        }
        
		$this->assign('json', Toolkit::jsonOK(array('forward' => Html::uriquery('mod_backup', 'admin_list'))));
        return '_result';
    } 
    
    public function import() {
//		$this->assign( 'list', $this->get_file_list( $this->dir ) );
//    	$this->_layout = 'content';
//    	$import_file =& ParamHolder::get('import_file', array(), PS_FILES);
//    	chmod($import_file['tmp_name'],0777);

    	$files = $this->get_file_list( $this->dir );
    	$fid =& ParamHolder::get('_fid', '');
        $import_file = $this->dir.'/'.$files[$fid]['fname'];
        @chmod($import_file,0755);
    	
    	$db_host = Config::$db_host;
    	$db_host .= ":".(Config::$port);
    	$db_user = Config::$db_user;
    	$db_pass = Config::$db_pass;
    	$db_name = Config::$db_name;
    	$charset = Config::$mysqli_charset;
    	
    	$link = mysql_connect($db_host,$db_user,$db_pass);
    	mysql_select_db($db_name,$link);
    	mysql_query("SET NAMES ".Config::$mysqli_charset ,$link);
    	$mqr = @get_magic_quotes_runtime();
    	@set_magic_quotes_runtime(0);
    	$query = fread(fopen($import_file, "r"), filesize($import_file)); 
    	@set_magic_quotes_runtime($mqr);
    	$pieces  = $this->_split_sql($query);
		if(function_exists("mysqli_set_charset")){
    		@mysqli_set_charset($link, $charset);
		}else{
			mysql_query("set character_set_client=binary");
		}
	    for ($i=0; $i<count($pieces); $i++){
			$pieces[$i] = trim($pieces[$i]);
			
			$pos1 = strpos($pieces[$i], "DROP TABLE IF EXISTS");
			$pos2 = strpos($pieces[$i], "CREATE TABLE");
			$pos3 = strpos($pieces[$i],"INSERT INTO");
			if(($pos1 === false) && ($pos2 === false) && ($pos3 === false))
			{
				continue;
			}
			if(($pos1 == 0) || ($pos2 == 0) || ($pos3 == 0)){
				if(!empty($pieces[$i]) && $pieces[$i] != "#"){
					$pieces[$i] = str_replace( "#__", '', $pieces[$i]); 
					if (!$result = @mysql_query ($pieces[$i])) {
						$errors[] = array ( mysql_error(), $pieces[$i] );
					}
				}
	    	}
		}
		$this->assign('json', Toolkit::jsonOK(array()));
        return '_result';
    }
    
    public function import_file()
    {
    	//ParamHolder::get('import_file', array(), PS_FILES);不支持sql后缀
    	$file_name = $_FILES['import_file']['name'];
    	$postfix_name = substr($file_name,-3);
    	@chmod($_FILES['import_file']['tmp_name'],0755);
    	if($postfix_name != 'sql')
    	{
    		@unlink($_FILES['import_file']['tmp_name']);//删除潜在的恶意脚本
    		die(_e('File type error!'));
    	}
    	
    	$db_host = Config::$db_host;
    	$db_host .= ":".(Config::$port);
    	$db_user = Config::$db_user;
    	$db_pass = Config::$db_pass;
    	$db_name = Config::$db_name;
    	$charset = Config::$mysqli_charset;
    	
    	try{
	    	$link = mysql_connect($db_host,$db_user,$db_pass);
	    	mysql_select_db($db_name,$link);
	    	mysql_query("SET NAMES ".Config::$mysqli_charset ,$link);
	    	$mqr = @get_magic_quotes_runtime();
	    	@set_magic_quotes_runtime(0);
	    	$query = fread(fopen($_FILES['import_file']['tmp_name'], "r"), filesize($_FILES['import_file']['tmp_name'])); 
	    	@set_magic_quotes_runtime($mqr);
	    	$pieces  = $this->_split_sql($query);
	    	//@mysqli_set_charset($link, $charset);
			if(function_exists("mysqli_set_charset")){
				@mysqli_set_charset($link, $charset);
			}else{
				mysql_query("set character_set_client=binary");
			}
		    for ($i=0; $i<count($pieces); $i++){
				$pieces[$i] = trim($pieces[$i]);
				
				$pos1 = strpos($pieces[$i], "DROP TABLE IF EXISTS");
				$pos2 = strpos($pieces[$i], "CREATE TABLE");
				$pos3 = strpos($pieces[$i],"INSERT INTO");
				if(($pos1 === false) && ($pos2 === false) && ($pos3 === false))
				{
					continue;
				}
				if(($pos1 == 0) || ($pos2 == 0) || ($pos3 == 0)){
					if(!empty($pieces[$i]) && $pieces[$i] != "#"){
						$pieces[$i] = str_replace( "#__", '', $pieces[$i]); 
						if (!$result = @mysql_query ($pieces[$i])) {
							$errors[] = array ( mysql_error(), $pieces[$i] );
						}
					}
		    	}
			}
    	}catch(Exception $ex) {
    		@unlink($_FILES['import_file']['tmp_name']);//删除潜在的恶意脚本
    		die(_e('Data recovery has failed,please check out your sql file whether it is right.'));
    	}
		@unlink($_FILES['import_file']['tmp_name']);
		$return_msg = __('Backup successfully!');
		echo <<<JS
<script type="text/javascript">
alert("$return_msg");
parent.window.location.reload(); 
</script>
JS;
		die;
    }
    
    private function _split_sql($sql) {
    	$sql = trim($sql);
		$sql = @str_replace("\n#[^\n]*\n", "\n", $sql);
		$buffer = array();
		$ret = array();
		$in_string = false;
		for($i=0; $i<strlen($sql)-1; $i++){
			if($sql[$i] == ";" && !$in_string){
				$ret[] = substr($sql, 0, $i);
				$sql = substr($sql, $i + 1);
				$i = 0;
			}
		if($in_string && ($sql[$i] == $in_string) && $buffer[1] != "\\"){
			$in_string = false;
		}elseif(!$in_string && ($sql[$i] == '"' || $sql[$i] == "'") && (!isset($buffer[0]) || $buffer[0] != "\\")){
			$in_string = $sql[$i];
		}
		if(isset($buffer[1])) {
			$buffer[0] = $buffer[1];
		}
			$buffer[1] = $sql[$i];
		}
		if(!empty($sql)){
			$ret[] = $sql;
		}
		return($ret);
    }
    

    /*
     * Description: display file list in a directory
     * Version: v1.0.0
	 * Date: 2010/03/16
	 * Author: Jane
	 * Copyright: cndns.com
     */
	private function get_file_list( $filePath )
	{
		$list = $result = array();
		$files = is_array(glob($filePath.'/*')) ? glob($filePath.'/*') : array();
		foreach( $files as $file )
		{
			if ( is_dir( $file ) ) {
				$list = array_merge( $list, getFileList($file) );
			} else {
				$list[] = $file;
			}
		}
		
		// format array
		$cnt = sizeof( $list );
		for( $i=0; $i<$cnt; $i++ )
		{
			$file = $list[$i];
			$result[$i]['fname'] = basename( $file );
			$result[$i]['fsize'] = filesize( $file );
			$result[$i]['ftime'] = filectime( $file );
		}
		
		return $result;
	}
	
	private function data2sql($table)
	{
		$tabledump = "DROP TABLE IF EXISTS $table;\n";
		$createtable = mysql_query("SHOW CREATE TABLE $table");
		$create = mysql_fetch_row($createtable);
		$tabledump .= $create[1].";\n\n";
		
		$rows = mysql_query("SELECT * FROM $table");
		$numfields = mysql_num_fields($rows);
		$numrows = mysql_num_rows($rows);
		while ($row = mysql_fetch_row($rows))
		{
		  $tab_desc = mysql_query("describe $table");
		  $tab_filed = '';
		  while($tab_rows = mysql_fetch_row($tab_desc)){
			  $tab_filed .= '`'.$tab_rows[0].'`,';
		  }
		  $tab_filed = substr($tab_filed,0,-1);
		  
		  $comma = "";
		  $tabledump .= "INSERT INTO $table($tab_filed) VALUES(";
		  for($i = 0; $i < $numfields; $i++)
		  {
		   $tabledump .= $comma."'".mysql_escape_string($row[$i])."'";
		   $comma = ",";
		  }
		  $tabledump .= ");\n";
		}
		$tabledump .= "\n";
		return $tabledump;
	}

}
?>