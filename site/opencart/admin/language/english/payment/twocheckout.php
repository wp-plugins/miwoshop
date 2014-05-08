<?php
/*
* @package		MiwoShop
* @copyright	2009-2014 Miwisoft LLC, miwisoft.com
* @license		GNU/GPL http://www.gnu.org/copyleft/gpl.html
*/

// No Permission
defined('MIWI') or die('Restricted access');

// Heading
$_['heading_title']      = '2Checkout';

// Text 
$_['text_payment']       = 'Payment';
$_['text_success']       = 'Success: You have modified 2Checkout account details!';
$_['text_twocheckout']	 = '<a href="https://www.2checkout.com/2co/affiliate?affiliate=1596408" target="_blank"><img src="view/image/payment/2checkout.png" alt="2Checkout" title="2Checkout" style="border: 1px solid #EEEEEE;" /></a>';

// Entry
$_['entry_account']      = '2Checkout Account ID:';
$_['entry_secret']       = 'Secret Word:<br /><span class="help">The secret word to confirm transactions with (must be the same as defined on the merchat account configuration page).</span>';
$_['entry_display']      = 'Direct Checkout:<span class="help">Enable Direct Checkout mode.</span>';
$_['entry_test']         = 'Test Mode:<span class="help">Enable demo mode.</span>';
$_['entry_total']        = 'Total:<br /><span class="help">The checkout total the order must reach before this payment method becomes active.</span>';
$_['entry_order_status'] = 'Order Status:';
$_['entry_geo_zone']     = 'Geo Zone:';
$_['entry_status']       = 'Status:';
$_['entry_sort_order']   = 'Sort Order:';

// Error
$_['error_permission']   = 'Warning: You do not have permission to modify payment 2Checkout!';
$_['error_account']      = 'Account No. Required!';
$_['error_secret']       = 'Secret Word Required!';
?>