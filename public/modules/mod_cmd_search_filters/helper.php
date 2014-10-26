<?php

defined('_JEXEC') or die;

class ModCmd_search_filtersHelper
{
	public static function getFacetTags($facet)
	{
		// TODO: Deprecated, using component helper
		// TODO:: you call this X times on each page load?
		$db = JFactory::getDBO();
		var_dump($db);die;
        $query = $db->getQuery(true);
        $query
            ->select('*')
            ->from('#__tags');
        $db->setQuery($query);
        $results = $db->loadObjectList();
        var_dump($results);
        echo 'here';die;
	}

	public static function getFacets()
	{
		// TODO: ! convert inpout from params into array!!! not string menu item
		$input = new JInput;
        $tagHelper = new JHelperTags;
        //$tagNames = $tagHelper->getTagNames($input->get('tags', [], 'array'));
        $tagNames = $tagHelper->getTagNames($input->get('cmd_search_tags', [], 'array'));
        $tags = array_merge($tagNames, $input->get('tags', [], 'array'));
        /*var_dump($tags);die;
        foreach($tagNames as $tag){
        	//var_dump($tagHelper->getTypeId('Android'));die;
        	//var_dump($tagHelper->getTagTreeArray($tag->id));
        }
        */

        // TODO: Watch out!
        // category comes in as single int, converted to array
        $categoryId = $input->get('cmd_search_category', 0, 'int');
        $jCategories = JCategories::getInstance('Content');
        $categoryNames = ($categoryId == 0) ? [] : [$jCategories->get($categoryId)->alias];
        $categories = array_merge($categoryNames, $input->get('category', [], 'array'));
        //die;
        /*
        $tags->getItemTags('com_content.article', $article->id);
        $article->tags = array();
        foreach ($tags->itemTags as $tag){
        	$path = split('/', $tag->path);
        	// use nested tags for top level filters
        	// TODO: needs to be recursive
        	if(count($path) == 2){
        		if(!is_array($article->$path[0])){
        			$article->$path[0] = array();
        		}
        		array_push($article->$path[0], $tag->title);
        	}
        	$article->tags[] = $tag->title;
        }
        */

		// TODO: move them to dynamic from J component parameter
		
       	//$tags = $input->get('tags', null, 'string');

       	$facets = array();
        $facets['phrase'] = $input->get('phrase', null, 'string');
        $facets['tags'] = $tags;
        $facets['category'] = $categories;
        $facets['types'] = $input->get('types', [], 'array');
        $facets['topics'] = $input->get('topics', [], 'array');
        $facets['extensions'] = $input->get('extensions', [], 'array');
        $facets['flags'] = $input->get('flags', [], 'array');
        $facets['keywords'] = $input->get('keywords', [], 'array');
        $facets = array_filter($facets);

        return $facets;
	}
}
