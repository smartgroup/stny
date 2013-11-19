<?php


if (!defined('IN_CONTEXT')) die('access violation error!');

class ModAuth extends Module {
    protected $_filters = array(
        'check_login' => '{loginform}{loginregform}{dologin}{dologout}'
    );
    
    public function loginform() {
    	$this->_layout = 'frontpage';
    	$this->assign('page_title', __('Login'));
        if (SessionHolder::get('user/s_role', '{guest}') != '{guest}') {
            // Do simply action override
            $this->userinfo();
            return 'userinfo';
        } else {
            $forward_url = ParamHolder::get('_f', '');
            if (strlen(trim($forward_url)) == 0) {
                $forward_url = 'index.php';
            }
            $this->setVar('forward_url', $forward_url);
        }
    }
    
    public function loginregform() {
    	$this->_layout = 'frontpage';
    	$this->assign('page_title', __('Login'));
        $forward_url = ParamHolder::get('_f', '');
        /**
         * for bugfree 350 14:38 2010-7-23 Add start
         */
        $goto =& SessionHolder::get('goto');
        if ((MOD_REWRITE == 2) && !empty($goto)) {
        	$forward_url = $goto;
        	// destroy session
        	SessionHolder::set('goto', '');
        }
        /**
         * for bugfree 350 14:38 2010-7-23 Add end
         */
        if (strlen(trim($forward_url)) == 0) {
            $forward_url = 'index.php';
        }
        $this->setVar('forward_url', $forward_url);
    }
    
    public function userinfo() {
        $curr_user = new User(SessionHolder::get('user/id', '0'));
        $this->setVar('curr_user', $curr_user);
    }

    public function dologin() {
    	$captcha = ParamHolder::get('rand_rs') ? ParamHolder::get('rand_rs') : ParamHolder::get('rand_rs_reglogn');
        if (!RandMath::checkResult($captcha)) {
            $this->setVar('json', Toolkit::jsonERR(__('Sorry! Please have another try with the math!')));
            return '_result';
        }

        if (ACL::loginUser(ParamHolder::get('login_user', ''), 
            ParamHolder::get('login_pwd', ''),'client')) {
            // 26/04/2010 Add <<
//            if (SessionHolder::get('role', '{guest}') == '{admin}') {
            if (ACL::isRoleAdmin()) {
            	$this->setVar('json', Toolkit::jsonERR(__('Administrator prohibit login!')));
            } else if(MEMBER_VERIFY=='1' && SessionHolder::get('user/member_verify')!='1'){
				SessionHolder::destroy();
				$this->setVar('json', Toolkit::jsonERR(__('being reviewed')));
			}else if(SessionHolder::get('user/active')!='1'){
				SessionHolder::destroy();
				$this->setVar('json', Toolkit::jsonERR(__('This account was prohibited from login, please contact the administrator.')));
			}else{// 26/04/2010 Add <<
            	$forward_url = ParamHolder::get('_f', '');
	            if (strlen(trim($forward_url)) == 0) {
	                $forward_url = 'index.php';
	            }
	            $this->setVar('json', Toolkit::jsonOK(array('forward' => $forward_url)));
            }
            
        } else {
            $this->setVar('json', Toolkit::jsonERR(__('Username and password mismatch!')));
        }
        
        return '_result';
    }
    
    public function dologout() {
        SessionHolder::destroy();
        // TODO: We need a logged out page and countdown redirecting to index.php
        //Content::redirect(Html::uriquery('mod_auth', 'loginform'));
        Content::redirect('index.php');
    }
}
?>