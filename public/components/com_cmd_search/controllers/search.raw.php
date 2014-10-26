<?php

/**
 * @version     1.0.0
 * @package     com_cmd_search
 * @copyright   Copyright (C) 2013. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Alex Crawford <acrawford@cmdagency.com> - http://cmdagency.com
 */

header('Content-Type: application/json');
defined('_JEXEC') or die;

require_once JPATH_COMPONENT.'/controller.php';

class Cmd_searchControllerSearch extends Cmd_searchController
{
	var $debug = false;
	var $facets = array();

	public function getResults()
	{
		$input = new JInput;
       	$tags = $input->get('tags', null, 'string');
		
       	$facets = array();
        $facets['phrase'] = $input->get('phrase', null, 'string');
        $facets['tags'] = $input->get('tags', null, 'string');
        $facets['types'] = $input->get('types', null, 'string');
        $facets['keywords'] = $input->get('keywords', null, 'string');
        $facets = array_filter($facets);

		echo json_encode($facets);
	}

	public function setInput()
	{
		$input = new JInput;
		$this->debug = $input->get('debug', $this->debug, 'boolean');
		$this->facets['phrase'] = $input->get('phrase', null, 'string');
		$this->facets['categories'] = $input->get('categories', null, 'array');
		$this->facets['mediatypes'] = $input->get('mediatypes', null, 'array');
		$this->facets['tags'] = $input->get('tags', null, 'array');
	}

	public function search()
	{
		$this->setInput();
		$model = $this->getModel('Result');
		$facets = array_filter($this->facets);
		var_dump($facets);die;
		$thing = $model->getItems($facets);
		die;

		//$index['articles'][] = $this->getArticles($this->facets);
		//echo json_encode(array($phrase, $categories, $tags, $mediatypes));
		echo json_encode($index);
		if($this->debug)die;
	}

	public function postForm() {
		$input = new JInput;
		$facets['phrase'] = $input->get('phrase', '', 'string');
		$facets['categories'] = $input->get('categories', '[]', 'array');
		$facets['mediatypes'] = $input->get('mediatypes', '[]', 'array');
		$facets['tags'] = $input->get('tags', '[]', 'array');

		$index['articles'][] = $this->getArticles($facets);

		//echo json_encode(array($phrase, $categories, $tags, $mediatypes));
		echo json_encode($index);
		if($this->debug)die;
	}	
}
