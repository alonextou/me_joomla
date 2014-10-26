<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla view library
jimport('joomla.application.component.view');

/**
 * HTML View class for the HelloWorld Component
 */
class Cmd_searchViewDefault extends JViewLegacy
{
        function display($tpl = null) 
        {
            //$this->state = $this->get('State');
            $app = JFactory::getApplication();
            $params = $app->getParams();
            $this->params = $params;

        	$facets = Cmd_searchHelper::getFacets();
        	$postInput = JRequest::get('post');
        	// TODO: Choose one request or the other!!
        	// The view is using $this->oldInput
        	$this->oldInput = array_merge($facets, $postInput);
        	// The filters module is using JRequest
        	JRequest::setVar('oldInput', $this->oldInput);
        	//$app = JFactory::getApplication();
        	//$app->setUserState( "$option.oldInput", json_encode($this->oldInput));

            

        	$this->response = $this->get('Items');
            parent::display($tpl);
        }
}