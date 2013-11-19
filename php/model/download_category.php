<?php
if (!defined('IN_CONTEXT')) die('access violation error!');

/**
 * Download category object
 * 
 */
class DownloadCategory extends RecordObject {
    public $has_many = array('DownloadCategory', 'Download');
    
    protected $no_validate = array(
        'isEmpty' => array(
            array('name', 'Missing download category name!'), 
            array('s_locale', 'Missing locale!'),
            array('alias', 'Missing category alias!'),
            array('published', 'Missing publish status!'),
            array('for_roles', 'Missing access property!')
        )
    );
    
    protected $yes_validate = array(
        '_regexp_' => array(
            array('/^0|1$/', 'published', 'Invalid publish status!'),
            array('/^(\{\w+\})+$/', 'for_roles', 'Invalid access property!')
        )
    );
    
    public static function toSelectArray(&$category_tree, &$select_array, $level = 0, 
        $ignore_ids = array(), $first_option = array()) {
        if ($level == 0 && sizeof($first_option) > 0) {
            foreach ($first_option as $key => $val) {
                $select_array[$key] = $val;
            }
        }
        foreach ($category_tree as $category) {
            if (in_array(intval($category->id), $ignore_ids)) {
                continue;
            }
            $select_array[$category->id] = $category->name;
        }
    }
}
?>