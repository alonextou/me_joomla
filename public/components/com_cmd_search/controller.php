<?php
/**
 * @version     1.0.0
 * @package     com_cmd_search
 * @copyright   Copyright (C) 2013. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Alex Crawford <acrawford@cmdagency.com> - http://cmdagency.com
 */
 
// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.controller');

class Cmd_searchController extends JControllerLegacy
{
	public function display($cachable = false, $urlparams = false)
	{
		//$this->result_id = $this->input->getCmd('id');
		$viewName = $this->input->getCmd('view', 'default');
		$view = $this->getView($viewName, 'html');
		//$view = $this->input->getCmd('view');
		switch($viewName){
			case 'default':
				$view->setModel($this->getModel('Result'), true);
				break;
			case 'result':
			case 'modal':
				$view->setModel($this->getModel('Result'), true);
				break;
		}
		$view->display();
		return $this;
	}
}
