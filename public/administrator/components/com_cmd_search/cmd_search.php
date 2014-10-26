<?php
/**
 * @version     1.0.0
 * @package     com_cmd_search
 * @copyright   Copyright (C) 2013. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Alex Crawford <acrawford@cmdagency.com> http://cmdagency.com
 */


// no direct access
defined('_JEXEC') or die;

require 'vendor/autoload.php';

// Access check.
if (!JFactory::getUser()->authorise('core.manage', 'com_cmd_search')) 
{
	throw new Exception(JText::_('JERROR_ALERTNOAUTHOR'));
}

// Include dependancies
jimport('joomla.application.component.controller');

$controller	= JControllerLegacy::getInstance('cmd_search');
$controller->execute(JFactory::getApplication()->input->get('task'));
$controller->redirect();
