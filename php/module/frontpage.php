<?php
class Frontpage extends Module {
    public function index() {
    	$this->setVar('page_title', __('Frontpage'));

		//counter 
		if(SITE_COUNTER == 1) {
			if(SessionHolder::get('counter', '0') == 0) {
				$o_param = new Parameter();
				$param =& $o_param->find('`key`=?', array("SITE_COUNTER_NUM"));
				$param->val = $param->val + 1;
				$param->save();
				SessionHolder::set('counter', '1');
			}
		}
    }
}
?>