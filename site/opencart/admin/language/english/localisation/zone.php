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
$_['heading_title']          = 'Zones';

// Text
$_['text_success']           = 'Success: You have modified zones!';

// Column
$_['column_name']            = 'Zone Name';
$_['column_code']            = 'Zone Code';
$_['column_country']         = 'Country';
$_['column_action']          = 'Action';

// Entry
$_['entry_status']           = 'Zone Status:';
$_['entry_name']             = 'Zone Name:';
$_['entry_code']             = 'Zone Code:';
$_['entry_country']          = 'Country:';

// Error
$_['error_permission']       = 'Warning: You do not have permission to modify zones!';
$_['error_name']             = 'Zone Name must be between 3 and 128 characters!';
$_['error_default']          = 'Warning: This zone cannot be deleted as it is currently assigned as the default store zone!';
$_['error_store']            = 'Warning: This zone cannot be deleted as it is currently assigned to %s stores!';
$_['error_address']          = 'Warning: This zone cannot be deleted as it is currently assigned to %s address book entries!';
$_['error_affiliate']        = 'Warning: This zone cannot be deleted as it is currently assigned to %s affiliates!';
$_['error_zone_to_geo_zone'] = 'Warning: This zone cannot be deleted as it is currently assigned to %s zones to geo zones!';
?>