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
$_['heading_title']      = 'SagePay Direct';

// Text 
$_['text_payment']       = 'Payment'; 
$_['text_success']       = 'Success: You have modified SagePay account details!';
$_['text_sagepay']       = '<a href="https://support.sagepay.com/apply/default.aspx?PartnerID=E511AF91-E4A0-42DE-80B0-09C981A3FB61" target="_blank"><img src="view/image/payment/sagepay.png" alt="SagePay" title="SagePay" style="border: 1px solid #EEEEEE;" /></a>';
$_['text_sim']           = 'Simulator';
$_['text_test']          = 'Test';
$_['text_live']          = 'Live';
$_['text_defered']       = 'Defered';
$_['text_authenticate']  = 'Authenticate';

// Entry
$_['entry_vendor']       = 'Vendor:';
$_['entry_test']         = 'Test Mode:';
$_['entry_transaction']  = 'Transaction Method:';
$_['entry_total']        = 'Total:<br /><span class="help">The checkout total the order must reach before this payment method becomes active.</span>';
$_['entry_order_status'] = 'Order Status:';
$_['entry_geo_zone']     = 'Geo Zone:';
$_['entry_status']       = 'Status:';
$_['entry_sort_order']   = 'Sort Order:';

// Error
$_['error_permission']   = 'Warning: You do not have permission to modify payment SagePay!';
$_['error_vendor']       = 'Vendor ID Required!';
?>