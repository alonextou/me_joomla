<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla view library
jimport('joomla.application.component.view');

/**
 * HTML View class for the HelloWorld Component
 */
class Cmd_searchViewModal extends JViewLegacy
{
        function display($tpl = null) 
        {
        	//$this->result_id = $this->input->getCmd('id');
        	$input = JRequest::get();
        	$this->response = $this->getModel()->getItemById($input['id']);
            parent::display($tpl);
        }
}