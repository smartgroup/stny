<?php if (!defined('IN_CONTEXT')) die('access violation error!'); ?>
<table width="100%" border="0" cellspacing="1" cellpadding="0" class="form_table_list" style="line-height:24px;">
    <tbody>
        <tr>
            <th><?php _e('Order No.'); ?></th>
            <th><?php _e('Login Name'); ?></th>
            <th><?php _e('Total Price'); ?></th>
            <th><?php _e('Order Time'); ?></th>
            <th><?php _e('Status'); ?></th>
            <th><?php _e('Operation'); ?></th>
        </tr>
    <?php
    if (sizeof($orders) > 0) {
        $row_idx = 0;
        foreach ($orders as $order) {
            $order->loadRelatedObjects(REL_PARENT, array('User'));
    ?>
        <tr>
            <td><a href="<?php echo Html::uriquery('mod_order', 'admin_view', array('o_id' => $order->id)); ?>" title="<?php echo $order->oid; ?>">
                        <?php echo $order->oid; ?></a></td>
            <td><?php if (isset($order->masters['User']->login)) {
            	echo $order->masters['User']->login;
            } ?></td>
            <td class="aligncenter"><?php echo CURRENCY_SIGN; ?><?php echo number_format($order->total_amount, 2); ?></td>
            <td class="aligncenter"><?php echo date("Y-m-d H:i", $order->order_time); ?></td>
            <td class="aligncenter">
                <?php echo Toolkit::switchText($order->order_status, 
                    array('1' => __('Not Paid'), '2' => __('Paid'), '3' => __('In Delivery'), '100' => __('Finished'), '101' => __('Cancelled'))); ?></td>
            <td class="aligncenter">
                <span class="medium">
                    <a href="<?php echo Html::uriquery('mod_order', 'admin_view', array('o_id' => $order->id)); ?>" title="<?php _e('View'); ?>"><img style="border:none;position:relative;top:2px;" alt="<?php _e('View');?>" src="<?php echo P_TPL_WEB; ?>/images/view.gif"/></a>
                </span>
            </td>
        </tr>
    <?php
            $row_idx = 1 - $row_idx;
        }
    } else {
    ?>
        <tr class="row_style_0">
            <td colspan="6" class="aligncenter"><?php _e('No Records!'); ?></td>
        </tr>
    <?php } ?>
    </tbody>
</table>
<?php
include_once(P_TPL.'/common/pager.php');
?>
