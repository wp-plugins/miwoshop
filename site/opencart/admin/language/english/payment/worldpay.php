<?php
/*
* @package		MiwoShop
* @copyright	2009-2014 Miwisoft LLC, miwisoft.com
* @license		GNU/GPL http://www.gnu.org/copyleft/gpl.html
* @license		GNU/GPL based on AceShop www.joomace.net
*/

// No Permission
defined('MIWI') or die('Restricted access');

// Heading
$_['heading_title']      = 'WorldPay';

// Text 
$_['text_payment']       = 'Payment';
$_['text_success']       = 'Success: You have modified WorldPay account details!';
$_['text_successful']    = 'On - Always Successful';
$_['text_declined']      = 'On - Always Declined';
$_['text_off']           = 'Off';
      
// Entry
$_['entry_merchant']     = 'Merchant ID:';
$_['entry_password']     = 'Payment Response Password:<br /><span class="help">This has to be set in the WorldPay control panel.</span>';
$_['entry_callback']     = 'Relay Response URL:<br /><span class="help">This has to be set in the WorldPay control panel. You will also need to check the "Enable the Shopper Response".</span>';
$_['entry_test']         = 'Test Mode:';
$_['entry_total']        = 'Total:<br /><span class="help">The checkout total the order must reach before this payment method becomes active.</span>';
$_['entry_order_status'] = 'Order Status:';
$_['entry_geo_zone']     = 'Geo Zone:';
$_['entry_status']       = 'Status:';
$_['entry_sort_order']   = 'Sort Order:';

// Error
$_['error_permission']   = 'Warning: You do not have permission to modify payment WorldPay!';
$_['error_merchant']     = 'Merchant ID Required!';
$_['error_password']     = 'Password Required!';
?>