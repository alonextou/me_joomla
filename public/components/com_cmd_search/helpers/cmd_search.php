
<?php
/**
 * @version     1.0.0
 * @package     com_cmd_search
 * @copyright   Copyright (C) 2013. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Alex Crawford <acrawford@cmdagency.com> - http://cmdagency.com
 */

defined('_JEXEC') or die;

abstract class Cmd_searchHelper
{
    public static function getAllTagFacets(){
        return [
            'categories',
            'topics',
            'types',
            'extensions',
            'flags',
            'media-types'
        ];
    }

    public static function getFacetFilters($facets)
    {
        // TODO: you really need to work on
        // error catching and return value consistency.
        if(!$facets){
            return array();
        }

        $tagHelper = new JHelperTags;
        $tmpFacets = array();

        $tmpFacets = array();
        // TODO: we are hacking, getTagNames only accepts array
        // array combine did not return an Assoc array proper order
        foreach($facets as $facet){
            $facetName = $tagHelper->getTagNames([$facet]);
            $tmpFacets[$facetName[0]] = $facet;
        }
        
        $facets = $tmpFacets;
        //$facetNames = $tagHelper->getTagNames($facets);
        //var_dump($facetNames);die;
        //$facets = array_combine($facetNames, $facets);

        $facetFilters = array();
        // TODO: Is SQL query on ID instead of tagNames better?
        foreach($facets as $name => $id){
            // TODO:: and you call this X times on each page load?
            $db = JFactory::getDBO();
            $query = $db->getQuery(true);
            $query
                ->select('title')
                ->from('#__tags')
                ->where('published = 1')
                ->where('parent_id = ' . $db->quote($id));
            $db->setQuery($query);
            $filterValues = $db->loadObjectList('title');

            $tagHelper = new JHelperTags;
            $facetFilters[$name] = array_keys($filterValues);
        }

        return $facetFilters;
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

        // TODO: Use dynamic J parameter, or helper method getAllTagFacets
       	$facets = array();
        $facets['phrase'] = $input->get('phrase', null, 'string');
        $facets['tags'] = $tags;
        $facets['category'] = $categories;
        $facets['asset-types'] = $input->get('types', [], 'array');
        $facets['topics'] = $input->get('topics', [], 'array');
        $facets['media-types'] = $input->get('media-types', [], 'array');
        $facets['extensions'] = $input->get('extensions', [], 'array');
        $facets['flags'] = $input->get('flags', [], 'array');
        $facets['keywords'] = $input->get('keywords', [], 'array');
        $facets = array_filter($facets);
        
        return $facets;
	}

}