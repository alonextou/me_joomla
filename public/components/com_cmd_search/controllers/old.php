<?php
header('Content-Type: application/json');
/**
 * @version     1.0.0
 * @package     com_cmd_search
 * @copyright   Copyright (C) 2013. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Alex Crawford <acrawford@cmdagency.com> - http://cmdagency.com
 */

// No direct access.
defined('_JEXEC') or die;

require_once JPATH_COMPONENT.'/controller.php';

class Cmd_searchControllerResult extends Cmd_searchController
{
	/**
	 * Proxy for getModel.
	 * @since	1.6
	 */
	public function &getModel($name = 'Result', $prefix = 'Cmd-searchModel')
	{
		$model = parent::getModel($name, $prefix, array('ignore_request' => true));
		return $model;
	}

}
