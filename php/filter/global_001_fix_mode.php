<?php
if (!defined('IN_CONTEXT')) die('access violation error!');

class FixMode {
    public function execute() {
        if (ACL::isRoleAdmin()) {
            SessionHolder::set('page/status', 'edit');
        } else {
            SessionHolder::set('page/status', 'view');
        }
    }
}
?>
