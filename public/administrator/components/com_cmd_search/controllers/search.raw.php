<?php
header('Content-Type: application/json');
/**
 * @version     1.0.0
 * @package     com_cmd_search
 * @copyright   Copyright (C) 2013. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Alex Crawford <acrawford@cmdagency.com> http://cmdagency.com
 */

// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.categories');

JLoader::register('fieldattach', 'components/com_fieldsattach/helpers/fieldattach.php');

class Cmd_searchControllerSearch extends JControllerLegacy
{
	var $debug = true;

	function indexAll(){
		$index['articles'] = $this->indexAllArticles();
		echo json_encode($index);
		if($this->debug)die;
	}

	function indexAllArticles(){

		$esClient = new Elasticsearch\Client();

		$returnValues = array(
            'id',
            'catid',
            'title',
            'alias',
            'publish_up',
            'modified',
            'introtext',
            'fulltext',
            'metadesc',
            'metakey',
            'access',
            'images',
            'attribs'
        );
        $db = JFactory::getDBO();
        $query = $db->getQuery(true);
        $query->select($db->quoteName($returnValues));
        $query->from($db->quoteName('#__content'));
        $query->where($db->quoteName('state') . ' = '. $db->quote('1'));
        $db->setQuery($query); 
        $results = $db->loadObjectList();

        // prepare each article
        foreach($results as $article){

        	// add associations... later
        	// $attributes = (array)json_decode($article->attribs);
        	// $associates = preg_grep('/^associate_(.*)/', array_keys($attributes));

            // add category alias (also type)
            $categories = JCategories::getInstance('content');
            $category = $categories->get($article->catid);
            $article->category = $category->alias;

            // add tags
            $tagHelper = new JHelperTags;
            $tags = $tagHelper->getItemTags('com_content.article', $article->id);
            $article->tags = array();
            //var_dump($tags);die;
            foreach ($tags as $tag){
            	$path = explode('/', $tag->path);
            	// use nested tags for top level filters
            	// TODO: should be recursive
            	if(count($path) == 2){
            		$tagParent = $path[0];
        			if(!isset($article->{$path[0]})){
            			$article->{$path[0]} = array();
            		}
            		array_push($article->{$path[0]}, $tag->title);
            	}
            	$article->tags[] = $tag->title;
            }
            
            // add keywords
            if(!$article->metakey){
            	$keywords = array();
            } else {
            	$keywords = array_map('trim', explode(',', $article->metakey));
            }
           	$article->keywords = $keywords;

            // decode json for json encoding...
            $article->images = json_decode($article->images);

            // index
			$esParams = array();
			$esParams['index'] = 'joomla';
			$esParams['type']  = 'article';
			$esParams['id'] = $article->id;
			$esParams['body'] = (array)$article;
			$esResult = $esClient->index($esParams);
        }

		return $results;
	}

	function indexAllDocuments(){

		// get articles
		$returnValues = array(
			'docman_document_id',
			'title',
			'slug',
			'docman_category_id',
			'description',
			'image',
			'storage_path',
			'access',
			'params'
		);
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		$query->select($db->quoteName($returnValues));
		$query->from($db->quoteName('#__docman_documents'));
		$query->where($db->quoteName('enabled') . ' = '. $db->quote('1'));
		$db->setQuery($query); 
		$results = $db->loadObjectList();

		// prepare each result
		foreach($results as $result){

			$result->params = json_decode($result->params);
		}

		return $results;
	}

	/*
    function getProductsByMaterialId() {
    	$materialId = (empty($_GET['materialId']) ? null : $_GET['materialId']);

    	if(is_numeric($materialId)) {

	    	$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query
			    ->select(array('id', 'title'))
			    ->from('#__cmd_search_products')
			    ->where('material_id = ' . $materialId)
			    ->order('ordering ASC');
		    $db->setQuery($query);
		    $results = $db->loadObjectList();

	    }

	    $results = (isset($results) ? $results : array());
	    return json_encode($results);
    }

    function getStylesByProductId() {
    	$productId = (empty($_GET['productId']) ? null : $_GET['productId']);

    	if(is_numeric($productId)) {

	    	$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query
			    ->select(array('id', 'title'))
			    ->from('#__cmd_search_styles')
			    ->where('product_id = ' . $productId)
			    ->order('ordering ASC');
		    $db->setQuery($query);
		    $results = $db->loadObjectList();

	    }

	    $results = (isset($results) ? $results : array());
	    return json_encode($results);
    }
	*/
}