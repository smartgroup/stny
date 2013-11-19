<?php
class Frontpage extends Module {
	protected $_filters = array(
        'check_admin' => '{index}{dologin}'
    );
    
    public function index() {
    	if(ACL::requireRoles(array('admin')))
    	{
    	    Content::redirect(Html::uriquery('frontpage', 'dashboard'));
    	}
    	$this->_layout = 'login';
    	$this->setVar('page_title', __('Administrator Login'));
    }
    
    public function dologin() {
        if (!RandMath::checkResult(ParamHolder::get('rand_rs'))) {
            $this->setVar('json', Toolkit::jsonERR(__('Sorry! Please have another try with the math!')));
            return '_result';
        }

        if (ACL::loginUser(ParamHolder::get('login_user', ''), 
            ParamHolder::get('login_pwd', ''))) {
            if (!ACL::requireRoles(array('admin'))) {
                $this->setVar('json', Toolkit::jsonERR(__('Username and password mismatch!')));
                return '_result';
            }
            /*$xml = new DOMDocument('1.0','utf-8');
			$xml->load('SitestarMaker/SitestarMaker.xml');
			$xml->getElementsByTagName('logoin')->item(0)->nodeValue = 'yes';
			$xml->save('SitestarMaker/SitestarMaker.xml');*/
            $this->setVar('json', Toolkit::jsonOK(array('forward' => 'index.php')));
        } else {
            $this->setVar('json', Toolkit::jsonERR(__('Username and password mismatch!')));
        }
        
        
        return '_result';
    }
    
    public function dologout()
    {
    	/*$xml = new DOMDocument('1.0','utf-8');
		$xml->load('SitestarMaker/SitestarMaker.xml');
		$xml->getElementsByTagName('logoin')->item(0)->nodeValue = 'no';
		$xml->save('SitestarMaker/SitestarMaker.xml');*/
    	
        SessionHolder::destroy();
        Content::redirect('index.php');
    }
    
    public function dashboard() {
        $this->_layout = 'dashboard';
        $o_admin_short = new AdminShortcut();
        $shortcuts =& $o_admin_short->findAll(false, false, "ORDER BY `priority`");
        
        $this->assign('shortcuts', $shortcuts);
        
        $curr_locale = trim(SessionHolder::get('_LOCALE'));
        
        $o_article_category = new ArticleCategory();
        $cate_a_count = $o_article_category->count("id<>'1' AND s_locale=?", array($curr_locale));
        $o_article = new Article();
        $article_count = $o_article->count("s_locale=?", array($curr_locale));
        
        $o_prod_category = new ProductCategory();
        $cate_p_count = $o_prod_category->count("id<>'1' AND s_locale=?", array($curr_locale));
        $o_product = new Product();
        $prod_count = $o_product->count("s_locale=?", array($curr_locale));
        
        $this->assign('cate_a_count', $cate_a_count);
        $this->assign('article_count', $article_count);
        $this->assign('cate_p_count', $cate_p_count);
        $this->assign('prod_count', $prod_count);
    }

	public function iframe() {
        $this->_layout = 'iframe';
	}

    public function admin() {
        $this->_layout = 'admin';
		$_c = intval(ParamHolder::get('_c', '1'));
		$mappings=self::frontpagemapping();
		if(!empty($mappings[$_c])){
			$modactrel=$mappings[$_c];
		}else{
			$modactrel=$mappings[1];
		}
		$url = "_m=".$modactrel[0]."&_a=".$modactrel[1];
		
		$this->assign('url', $url);
	}
	
	/**
	 * Edit Module >>
	 */
	public function admin_logo() {
    	$this->_layout = 'blank';
    	
		$act = ParamHolder::get('act', '');
		$loop = ParamHolder::get('_p', '0');
		if ($act == 'btnsumbit') {
			$err = '';
			$max_filesize = ini_get('upload_max_filesize');
			$maxsize = intval($max_filesize) * 1024 * 1024;
			$typeArr = array('image/gif','image/png','image/x-png','image/jpeg','image/pjpeg','image/bmp');
			
			$logo_width = ParamHolder::get('logo_width', '299');
			$logo_height = ParamHolder::get('logo_height', '92');
			$hid_logo_src = ParamHolder::get('hid_logo_src', '');
			$logo_file =& ParamHolder::get('logo_src', array(), PS_FILES);
			$logo_file["name"] = Toolkit::changeFileNameChineseToPinyin($logo_file["name"]);
			if (!empty($logo_file["name"])) {
				// 文件大小
		        if ($logo_file['size'] > $maxsize) {
		        	$err = __('Upload size limit').':'.$max_filesize;
		        // 文件类型
		    	} elseif (!in_array($logo_file['type'], $typeArr)) {
		        	$err = __('Supported file format').':gif|jpg|png|bmp';	
		        } else {
		        	// rename file name
					if (file_exists(ROOT.'/upload/image/'.$logo_file["name"])) {
						$logo_file["name"] = Toolkit::randomStr(8).strrchr($logo_file["name"],".");
					}
		        	if (preg_match("/^WIN/i", PHP_OS) && preg_match("/[\x80-\xff]./", $logo_file["name"])) {
		        		$logo_file["name"] = iconv('UTF-8', 'GBK//IGNORE', $logo_file["name"]);
		        	}
		        	if (move_uploaded_file($logo_file['tmp_name'], ROOT.'/upload/image/'.$logo_file['name'])) {
		        		ParamParser::fire_virus(ROOT.'/upload/image/'.$logo_file['name']);
		        		$logo_src = '../upload/image/'.$logo_file['name'];
		        	} else { $err = __('Uploading file failed!'); }
		        }
		        // show error
		        if ($err) {
		        	$this->assign('err', $err);
		        	$this->assign('act', 'btnsumbit');
					$this->assign('curr_loop', $loop);
					$this->assign('logo_src', $hid_logo_src);
					$this->assign('logo_width', $logo_width);
					$this->assign('logo_height', $logo_height);
		        } else {
		        	if (file_exists($hid_logo_src)) @unlink($hid_logo_src);
		        	// Write xml
		        	$dataXml = new DOMDocument('1.0','utf-8');
					$dataXml->load(ROOT.'/data/admin_block_config.xml');
			    	$xml = $dataXml->getElementsByTagName('node')->item($loop);
			    	if (preg_match("/^WIN/i", PHP_OS) && preg_match("/[\x80-\xff]./", $logo_src)) {
			    		$logo_src = iconv('GBK', 'UTF-8//IGNORE', $logo_src);
			    	}
			    	$xml->getElementsByTagName('logo_src')->item(0)->nodeValue = $logo_src;
			    	$xml->getElementsByTagName('logo_width')->item(0)->nodeValue = $logo_width;
			    	$xml->getElementsByTagName('logo_height')->item(0)->nodeValue = $logo_height;
			    	$dataXml->save(ROOT.'/data/admin_block_config.xml');
					echo '<script language="javascript">window.parent.location.href = "'.Html::uriquery('frontpage', 'dashboard').'"</script>';
		        }
			} else {
				$this->assign('act', 'btnsumbit');
				$this->assign('curr_loop', $loop);
				$this->assign('logo_src', $hid_logo_src);
				$this->assign('logo_width', $logo_width);
				$this->assign('logo_height', $logo_height);
				echo '<script language="javascript">window.parent.location.href = "'.Html::uriquery('frontpage', 'dashboard').'"</script>';
			}
		} else {
			$dataXml = new DOMDocument('1.0','utf-8');
			$dataXml->load(ROOT.'/data/admin_block_config.xml');
		    $xml = $dataXml->getElementsByTagName('node')->item($loop);
		    $logo_src = $xml->getElementsByTagName('logo_src')->item(0)->nodeValue;
		    $logo_width = $xml->getElementsByTagName('logo_width')->item(0)->nodeValue;
		    $logo_height = $xml->getElementsByTagName('logo_height')->item(0)->nodeValue;

			$this->assign('act', 'btnsumbit');
			$this->assign('curr_loop', $loop);
			$this->assign('logo_src', $logo_src);
			$this->assign('logo_width', $logo_width);
			$this->assign('logo_height', $logo_height);
		}
	}
	
	public function admin_foot() {
    	$this->_layout = 'blank';
    	
    	$loop = ParamHolder::get('_p', '0');
    	$dataXml = new DOMDocument('1.0','utf-8');
		$dataXml->load(ROOT.'/data/admin_block_config.xml');
	    $xml = $dataXml->getElementsByTagName('node')->item($loop);
	    $foot_info = $xml->getElementsByTagName('footer')->item(0)->nodeValue;
    	
    	$this->assign('curr_loop', $loop);
    	$this->assign('foot_info', $foot_info);
    	$this->assign('next_action', 'save_admin_foot');
	}
	
	public function save_admin_foot() {
		$loop = ParamHolder::get('_p', '0');
    	$foot_info = trim(ParamHolder::get('foot_info', ''));
    	if (!is_numeric($loop)) {
            $this->assign('json', Toolkit::jsonERR(__('Invalid ID!')));
            return '_result';
        }
        
        try {
	    	$dataXml = new DOMDocument('1.0','utf-8');
			$dataXml->load(ROOT.'/data/admin_block_config.xml');
	    	$xml = $dataXml->getElementsByTagName('node')->item($loop);
	    	$xml->getElementsByTagName('footer')->item(0)->nodeValue = htmlspecialchars($foot_info);
	    	$dataXml->save(ROOT.'/data/admin_block_config.xml');
	    } catch (Exception $ex) {
            $this->assign('json', Toolkit::jsonERR($ex->getMessage()));
			return '_result';
        }
        
        $this->assign('json', Toolkit::jsonOK());
        return '_result';
	}
	
	public function admin_cell() {
    	$this->_layout = 'blank';
    	
    	$status = ParamHolder::get('_t', '');
    	$loop = ParamHolder::get('_p', '0');
    	$dataXml = new DOMDocument('1.0','utf-8');
		$dataXml->load(ROOT.'/data/admin_block_config.xml');
		$xml = $dataXml->getElementsByTagName('node')->item($loop);
    	switch ($status) {
    		case 'bbs':
			    $title = $xml->getElementsByTagName('bbs_title')->item(0)->nodeValue;
			    $url = $xml->getElementsByTagName('bbs_url')->item(0)->nodeValue;
			    $description = $xml->getElementsByTagName('bbs_description')->item(0)->nodeValue;
    			break;
    		case 'host':
    			$title = $xml->getElementsByTagName('host_title')->item(0)->nodeValue;
			    $url = $xml->getElementsByTagName('host_url')->item(0)->nodeValue;
			    $description = $xml->getElementsByTagName('host_description')->item(0)->nodeValue;
    			break;
    	}
    	
    	$this->assign('title', $title);
    	$this->assign('url', $url);
    	$this->assign('description', $description);
    	$this->assign('curr_loop', $loop);
    	$this->assign('status', $status);
    	$this->assign('next_action', 'save_admin_cell');
	}
	
	public function save_admin_cell() {
		$loop = ParamHolder::get('_p', '0');
		$status = ParamHolder::get('_t', '');
    	if (!is_numeric($loop)) {
            $this->assign('json', Toolkit::jsonERR(__('Invalid ID!')));
            return '_result';
        }
        $title = trim(ParamHolder::get('title', ''));
        $url = trim(ParamHolder::get('link', ''));
        $description = trim(ParamHolder::get('description', ''));
        
        try {
	    	$dataXml = new DOMDocument('1.0','utf-8');
			$dataXml->load(ROOT.'/data/admin_block_config.xml');
	    	$xml = $dataXml->getElementsByTagName('node')->item($loop);
	    	switch ($status) {
    			case 'bbs':
    				$xml->getElementsByTagName('bbs_title')->item(0)->nodeValue = $title;
    				$xml->getElementsByTagName('bbs_url')->item(0)->nodeValue = $url;
    				$xml->getElementsByTagName('bbs_description')->item(0)->nodeValue = $description;
    				break;
    			case 'host':
    				$xml->getElementsByTagName('host_title')->item(0)->nodeValue = $title;
    				$xml->getElementsByTagName('host_url')->item(0)->nodeValue = $url;
    				$xml->getElementsByTagName('host_description')->item(0)->nodeValue = $description;
    				break;
    		}
	    	$dataXml->save(ROOT.'/data/admin_block_config.xml');
	    } catch (Exception $ex) {
            $this->assign('json', Toolkit::jsonERR($ex->getMessage()));
			return '_result';
        }
        
        $this->assign('json', Toolkit::jsonOK());
        return '_result';
	}
	/**
	 * Edit Module <<
	 */
	
    /**
     * Auto upgrade 
     */
    public function auto_upgrade()
    {
		try {
			// offical version
			$orgvn = trim(ParamHolder::get('orgvn'));
			// locale version
			$locvn = SYSVER;
			// general new version number
			$nstr = $nstr1 = $gstr = $gstr1 = '';
			$nstr1 = preg_replace('/[^\d]/', '', $orgvn);
			$nstr = strlen($nstr1) > 2 ? substr($nstr1, -4) : $nstr1;
			$gstr1 = preg_replace('/[^\d]/', '', $locvn);
			$gstr = strlen($gstr1) > 2 ? substr($gstr1, -4) : $gstr1;
			$archive = "upgrade{$nstr}_{$gstr}";
			
			$package_url = "http://upgrade.sitestar.cn/{$archive}.zip";
			if (ParamHolder::get('status') == 'agent') {
				$package_url = "http://upgrade.sitestar.cn/agent/{$archive}.zip";
			}
		    $tpl_info = array(
		                	'archive' => "{$archive}.zip",
		        			'package_url' => $package_url
		                );
		    
		    // Check whether the target download dir is writable
		    if (!is_writable(ROOT)) {
		        $this->setVar('json', Toolkit::jsonERR(__('The wwwroot can\'t write!')));
		    }

			// Check whether there is a template with the same name
		    $folder_name = substr($tpl_info['archive'], 0, -strlen('.zip'));
		    if(file_exists(ROOT.DS.$folder_name)) {
		        $this->remove_file(ROOT.DS.$folder_name);
		    }
		    
		    // Try to download the file
		    $remote_file = fopen($tpl_info['package_url'], 'rb');
		    if (!$remote_file) {
		        $this->setVar('json', Toolkit::jsonERR(__('The remote file(s) can\'t read!')));
		    }
		    $local_file = fopen(ROOT.DS.$tpl_info['archive'], 'wb');
		    while (!feof($remote_file)) {
		        fwrite($local_file, 
		            fread($remote_file, 4096), 
		            4096);
		    }
		    fclose($local_file);
		    fclose($remote_file);
		    
		    // Download finished. Now extract.
		    if (filesize(ROOT.DS.$tpl_info['archive'])) {
			    include_once(P_LIB.'/zip.php');
			    if (!file_exists(ROOT.DS.$folder_name)) mkdir(ROOT.DS.$folder_name, 0755);
			    $tpl_zip = new zipper();
				$tpl_zip->ExtractTotally(ROOT.DS.$tpl_info['archive'], ROOT.DS.$folder_name);
			    unlink(ROOT.DS.$tpl_info['archive']);
		    }
		} catch(SoapFault $fault) {
		    //echo "Error: ",$fault->faultcode,", string: ",$fault->faultstring;
		    $this->setVar('json', Toolkit::jsonERR($fault->faultstring));
		}
		
		/**
    	 * Update file(s)
    	 */
    	if (file_exists(ROOT.DS.$archive)) {
    		$this->update_file(ROOT.DS.$archive, "{$archive}/");
    	}
    	
    	/**
    	 * Update table(s)
    	 */
    	if (file_exists(ROOT.DS."{$archive}/basic.sql")) {
    		global $db;
    		$upgrade_sql = file_get_contents(ROOT.DS."{$archive}/basic.sql");
			$sql = <<<EOT
$upgrade_sql
EOT;
    		$this->dbupdate($sql, $db);
    	}
    	 
    	/**
    	 * Remove cache file(s)
    	 */
    	$this->remove_file(ROOT.DS.'cache', false);
    	
    	$this->setVar('json', Toolkit::jsonOK());
    	return '_result';
    }
        
    /**
     * Get the official version
     */
    public function get_version()
    {
		try {
    		$status = !Toolkit::getAgent() ? 'agent' : 'general';
    		if (($newvn = @file_get_contents("http://upgrade.sitestar.cn/default.php?vn=".urlencode(SYSVER)."&tag=".$status)) === false) {
    			$this->setVar('json', Toolkit::jsonERR(__('Remote request failed!')));
    		} else {
    			$this->setVar('json', Toolkit::jsonOK(array('vn'=>$newvn, 'curvn'=>SYSVER, 'tag'=>$status)));
    		}
    		return '_result';
    	} catch(SoapFault $fault) {
		    $this->setVar('json', Toolkit::jsonERR($fault->faultstring));
		}
    }
    
    /**
     * delete file(s)
     */
    private function remove_file($dirname, $rm = true)
	{
		if(!is_dir($dirname))
	    {
	   		@unlink($dirname);
	        return false;
	    }
	    $handle = @opendir($dirname);
	    while(($file = @readdir($handle)) !== false)
	    {
	        if($file != '.' && $file != '..')
	        {
	            $dir = $dirname.'/'.$file;
	            is_dir($dir) ? $this->remove_file($dir) : @unlink($dir);
	        }
	    }
	    closedir($handle);
	    return $rm ? rmdir($dirname) : true;
	}
	
	/**
	 * update file(s)
	 */
	private function update_file($topath, $replace)
	{
		$files = sizeof(glob($topath.'/*')) ? glob($topath.'/*') : array();
		foreach ($files as $file) {
			if ((strtolower(substr(strrchr($file, '.'), 1)) == 'txt') 
			    || (strtolower(substr(strrchr($file, '.'), 1)) == 'sql') 
			    || ($file == $topath.'/index.php')) {
				continue;
			} else {
				$dest = str_replace($replace, '', $file);
				if (is_dir($file)) {
					if (!file_exists($dest)) mkdir($dest, 0755);
					$this->update_file($file, $replace);
				} else {
					// for (un)install
					if (in_array($file, array($topath.'/load.php',$topath.'/admin/load.php'))) {
						$local = file_get_contents($dest);
						preg_match("/define\(\'IS_INSTALL\'\,\s[1|0]\)/i", $local, $match);
						if ($match[0]) {
							$upgrade = file_get_contents($file);
							$newstr = preg_replace("/define\(\'IS_INSTALL\'\,\s[1|0]\)/i", $match[0], $upgrade);
							file_put_contents($file, $newstr);
						}
					}
					if (!copy($file, $dest)) {
						$this->setVar('json', Toolkit::jsonERR(__('Upate file(s) failed!')));
					}
				}
			}
		}
	}
	
	/**
	 * Update table(s)
	 */
    private function dbupdate($query, $db) 
	{
		$query = str_replace("\r", "\n", str_replace(' `es_', ' `'.Config::$tbl_prefix, $query));
		$expquery = explode(";\n", $query);

		foreach($expquery as $sql) {
			$sql = trim($sql);
			
			if($sql == '' || $sql[0] == '#') continue;

			if(strtoupper(substr($sql, 0, 12)) == 'CREATE TABLE') {
				$db->query($this->createtable($sql, Config::$mysqli_charset));
			} elseif (strtoupper(substr($sql, 0, 11)) == 'ALTER TABLE') {
				$this->runquery_altertable($sql, $db);
			} else {
				$db->query($sql);
			}
		}
	}

	private function createtable($sql, $dbcharset) 
	{
		$type = strtoupper(preg_replace("/^\s*CREATE TABLE\s+.+\s+\(.+?\).*(ENGINE|TYPE)\s*=\s*([a-z]+?).*$/isU", "\\2", $sql));
		$type = in_array($type, array('MYISAM', 'HEAP')) ? $type : 'MYISAM';
		return preg_replace("/^\s*(CREATE TABLE\s+.+\s+\(.+?\)).*$/isU", "\\1", $sql).
		($this->version() > '4.1' ? " ENGINE=$type default CHARSET=".$dbcharset : " TYPE=$type");
	}

	private function runquery_altertable($sql, $db) 
	{
		$tablepre = Config::$tbl_prefix;
		$dbcharset = Config::$mysqli_charset;

		$updatesqls = $this->parse_alter_table_sql($sql);

		foreach($updatesqls as $updatesql) {
			$successed = TRUE;

			if(is_array($updatesql) && !empty($updatesql[0])) {

				list($table, $action, $field, $sql) = $updatesql;

				if(empty($field) && !empty($sql)) {
					$query = "ALTER TABLE {$tablepre}{$table} ";
					if($action == 'INDEX') {
						$successed = $db->query("$query $sql", "SILENT");
					} elseif ($action == 'UPDATE') {
						$successed = $db->query("UPDATE {$tablepre}{$table} SET $sql", 'SILENT');
					}
				} elseif($tableinfo = $this->get_table_columns($tablepre.$table, $db)) {
					$fieldexist = isset($tableinfo[$field]) ? 1 : 0;

					$query = "ALTER TABLE {$tablepre}{$table} ";

					if($action == 'MODIFY') {
						$query .= $fieldexist ? "MODIFY $field $sql" : "ADD $field $sql";
						$successed = $db->query($query, 'SILENT');
					} elseif($action == 'CHANGE') {
						$field2 = trim(substr($sql, 0, strpos($sql, ' ')));
						$field2exist = isset($tableinfo[$field2]);

						if($fieldexist && ($field == $field2 || !$field2exist)) {
							$query .= "CHANGE $field $sql";
						} elseif($fieldexist && $field2exist) {
							$db->query("ALTER TABLE {$tablepre}{$table} DROP $field2", 'SILENT');
							$query .= "CHANGE $field $sql";
						} elseif(!$fieldexist && $fieldexist2) {
							$db->query("ALTER TABLE {$tablepre}{$table} DROP $field2", 'SILENT');
							$query .= "ADD $sql";
						} elseif(!$fieldexist && !$field2exist) {
							$query .= "ADD $sql";
						}
						$successed = $db->query($query);
					} elseif($action == 'ADD') {
						$query .= $fieldexist ? "CHANGE $field $field $sql" :  "ADD $field $sql";
						$successed = $db->query($query);
					} elseif($action == 'DROP') {
						if($fieldexist) {
							$successed = $db->query("$query DROP $field", "SILENT");
						}
						$successed = TRUE;
					}
				} else {
					$successed = 'TABLE NOT EXISTS';
				}
			}
		}
		return $successed;
	}

	private function parse_alter_table_sql($s) 
	{
		$arr = array();
		// \`\` - for upgrade basic.sql
		preg_match("/ALTER TABLE \`(\w+)\`/i", $s, $m);
		$tablename = substr($m[1], strlen(Config::$tbl_prefix));
		preg_match_all("/add column (\w+) ([^\n;]+)/is", $s, $add);
		preg_match_all("/drop column (\w+)([^\n;]*)/is", $s, $drop);
		preg_match_all("/change (\w+) ([^\n;]+)/is", $s, $change);
		preg_match_all("/add key ([^\n;]+)/is", $s, $keys);
		preg_match_all("/add unique ([^\n;]+)/is", $s, $uniques);
		foreach($add[1] as $k => $colname) {
			$attr = preg_replace("/(.+),$/", "\\1", trim($add[2][$k]));
			$arr[] = array($tablename, 'ADD', $colname, $attr);
		}
		foreach($drop[1] as $k => $colname) {
			$attr = preg_replace("/(.+),$/", "\\1", trim($drop[2][$k]));
			$arr[] = array($tablename, 'DROP', $colname, $attr);
		}
		foreach($change[1] as $k => $colname) {
			$attr = preg_replace("/(.+),$/", "\\1", trim($change[2][$k]));
			$arr[] = array($tablename, 'CHANGE', $colname, $attr);
		}
		foreach($keys[1] as $k => $colname) {
			$attr = preg_replace("/(.+),$/", "\\1", trim($keys[0][$k]));
			$arr[] = array($tablename, 'INDEX', '', $attr);
		}
		foreach($uniques[1] as $k => $colname) {
			$attr = preg_replace("/(.+),$/", "\\1", trim($uniques[0][$k]));
			$arr[] = array($tablename, 'INDEX', '', $attr);
		}
		return $arr;
	}

	private function get_table_columns($table, $db) 
	{
		$tablecolumns = array();
		
		if($this->version() > '4.1') {
			$query =& $db->query("SHOW FULL COLUMNS FROM $table");
		} else {
			$query =& $db->query("SHOW COLUMNS FROM $table");
		}
		
		while($field =& $query->fetchRow()) {
			$tablecolumns[$field['Field']] = $field;
		}
		return $tablecolumns;
	}
	
	/**
	 * MySQL version
	 */
	private function version() {
		global $db;
		return mysql_get_server_info();
	}
	
	public static function frontpagemapping(){
		$mapping=array(
			1=>array('mod_article','admin_list'),
			2=>array('mod_product','admin_list'),
			3=>array('mod_user','admin_list'),
			4=>array('mod_message','admin_list'),
			5=>array('mod_bulletin','admin_list'),
			6=>array('mod_roles','admin_list')
		);	
		return $mapping;
	}
}
?>