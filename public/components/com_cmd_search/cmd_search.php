<?php
/**
 * @version     1.0.0
 * @package     com_cmd_search
 * @copyright   Copyright (C) 2013. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Alex Crawford <acrawford@cmdagency.com> - http://cmdagency.com
 */

defined('_JEXEC') or die;

require 'vendor/autoload.php';

// Include dependancies
jimport('joomla.application.component.controller');

JLoader::register('Cmd_searchHelper', dirname(__FILE__) . '/helpers/cmd_search.php');

// Execute the task.
$controller	= JControllerLegacy::getInstance('cmd_search');
$controller->execute(JFactory::getApplication()->input->get('task'));
$controller->redirect();