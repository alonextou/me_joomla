<?php
header('Content-Type: application/json');
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla modelitem library
jimport('joomla.application.component.modelitem');

class Cmd_searchModelResult extends JModelItem
{
    var $debug = false;

    public function getItemById($id){
        $esClient = new Elasticsearch\Client();
        $query = array();
        $esParams['index'] = 'joomla';
        $esParams['type'] = 'article';
        $esParams['id'] = $id;
        $results = $esClient->get($esParams);
        return $results;
    }

    public function getItems(){
        
        $facets = Cmd_searchHelper::getFacets();
        $results = $this->searchFacets($facets);
  
        $response = array();
        if(!empty($results['hits']['hits'])){
            $response['hits'] = $results['hits']['total'];
            $response['time'] = $results['took'];
            $response['max_score'] = $results['hits']['max_score'];
            $response['results'] = $results['hits']['hits'];
            //var_dump(json_encode($response));die;
        }

        return $response;
    }

    public function searchFacets($facets = array()) {
        $input = new JInput;
        $this->debug = $input->get('debug', $this->debug, 'boolean');
        
        $tagHelper = new JHelperTags;
        // TODO: allow must/should and and/or dynamicity parameters!
        $filterMustArray = array();
        foreach($facets as $facet => $value){
            switch($facet){
                case 'phrase':
                    $queryMatch = new stdClass;
                    $queryMatch->multi_match = new stdClass;
                    $queryMatch->multi_match->query = $facets['phrase'];
                    $queryMatch->multi_match->fields = [
                        'title', 
                        'introtext'
                    ];
                    break;
                case 'category':
                case 'tags':
                case 'asset-types':
                    // TODO: you should juse use tagHelper in helper!!!
                    //$tagNames = $tagHelper->getTagNames($value);
                    //$value = $tagNames;
                    // look at that no break;.
                case 'topics':
                case 'extensions':
                case 'media-types':
                case 'flags':
                    $filterMust = new stdClass;
                    $filterMust->terms = new stdClass;
                    $filterMust->terms->{$facet} = $value;
                    $filterMust->terms->execution = 'and';
                    $filterMustArray[] = $filterMust;
                    break;
            }
        }
        //var_dump($filterMustArray);die;

        $esClient = new Elasticsearch\Client();
        $query = array();
        $esParams['index'] = 'joomla';
        $esParams['type'] = 'article';
        //var_dump($filterShould);die;
        $esParams['size'] = 1000; // TODO: lol
        if(isset($queryMatch)) {
            $esParams['body']['query']['filtered']['query'] = $queryMatch;
        }
        $esParams['body']['query']['filtered']['filter']['bool']['must'] = $filterMustArray;
        /*
        $esParams['body']['query']['filtered']['filter']['bool']['should'][] = [
            "terms" => [
                "topics" => ['test'],
                "execution" => 'and'
            ]
        ];
        */
        /*
        $esParams['body']['query']['filtered'] = [
            "filter" => [
                "bool" => [
                    "should" => new stdClass()
                ]
            ],
            "query"  => $queryMatch
        ];
        */
        //$esParams['body']['query']['filtered'] =  json_decode($queryMatchJson);
        /*
        $esParams['body']  = '{
            "query": {
                "filtered" : {
                    "query": {
                        "multi_match": {
                            "query": "'. $facets['phrase'] .'",
                            "fields": ["title", "introtext"]
                        }
                    },
                    "filter" : {
                        "bool" : {
                            "should" : [
                                '.$filterShouldJson.'
                            ]
                        }
                    }
                }
            }
        }';
        */

        /*
        $esParams['body']  = '{
            "query": {
                "bool": {
                    "should": [
                        {
                            "multi_match": {
                                "query": "'. $facets['phrase'] .'",
                                "fields": ["title", "topics", "types", "keywords", "introtext"]
                            }
                        },
                        {
                            "terms" : { 
                                "topics" : '. $facets['topics'] .'
                            }
                        }
                    ]
                }
            }
        }';
        */
        /*
        $esParams['body']  = '{
            "query": {
                "filtered": {
                    "query": {
                        "multi_match": {
                            "query": "'. $facets['phrase'] .'",
                            "fields": ["title", "topics", "types", "keywords", "introtext"]
                        },
                    },
                    "filter": {
                        "bool": {
                            "should": [
                                {
                                    "terms" : { 
                                        "topics" : '. $facets['topics'] .'
                                    }
                                }
                            ]
                        }
                    }
                }
            }
        }';
        */
        /*
        $esParams['body']  = '{
            "query" : {
                "bool" : {
                    "should": [
                        {
                            "multi_match": {
                                "query": "'. $facets['phrase'] .'",
                                "fields": ["title", "topics", "types", "keywords", "introtext"]
                            }
                        },
                        {
                            "match": {
                                "extensions": {
                                    "query": "'. $facets['extensions'] .'",
                                    "minimum_should_match": "100%"
                                }
                            }
                        }
                    ]
                }
            }
        }';
        */

        $results = $esClient->search($esParams);
    
        //var_dump($results);die;

        if($this->debug === true){
            var_dump((object)$results);
            die;
        }
        return $results;

        /* simplest examples
        $esParams['body']  = '{
            "query" : {
                "multi_match": {
                  "query": "'.  $facets['phrase'] .'",
                  "fields": ["title", "tags", "types", "keywords", "introtext"]
                }            
            }
        }';
        */
        
    }

    public function getResults($facets = null){
        $input = new JInput;

        // You should change the following logic, so that the pre_ menu item filters are ONLY used if
        // there are no manual selections

        $preQuery = array();
        $preQuery['pre_phrase'] = !is_string($input->get('pre_phrase', null, 'string')) ? null : $input->get('pre_phrase', null, 'string');
        $preQuery['pre_tags'] = !is_string($input->get('pre_tags', null, 'string')) ? null : array_map('trim', explode(',', $input->get('pre_tags', null, 'string')));
        $preQuery['pre_types'] = !is_string($input->get('pre_types', null, 'string')) ? null : array_map('trim', explode(',', $input->get('pre_types', null, 'string')));
        $preQuery['pre_keywords'] = !is_string($input->get('pre_keywords', null, 'string')) ? null : array_map('trim', explode(',', $input->get('pre_keywords', null, 'string')));

        $facets = array();
        $facets['phrase'] = $input->get('phrase', $preQuery['pre_phrase'], 'string');
        $facets['tags'] = isset($preQuery['pre_tags']) ? $preQuery['pre_tags'] : $input->get('tags', null, 'array');
        $facets['types'] = isset($preQuery['pre_types']) ? $preQuery['pre_types'] : $input->get('types', null, 'array');
        $facets['keywords'] = isset($preQuery['pre_keywords']) ? $preQuery['pre_keywords'] : $input->get('keywords', null, 'array');
        $facets = array_filter($facets);

        $esClient = new Elasticsearch\Client();
        $query = array();
        $esParams['index'] = 'joomla';

        // cheap way to search on everything
        if(!empty($facets)){
            $esParams['body']  = '{
                "query" : {
                    "multi_match" : {
                      "query": "'.  $facets['phrase'] .'",
                      "fields": ["title", "tags", "types", "keywords", "introtext"]
                    }
                }
            }';     
        }

        // phrase
        /*
        if(!empty($facets['phrase'])){
            $esParams['body']['query']['multi_match']['query'] = array(
                $facets['phrase']
            );

            $esParams['body']['query']['multi_match']['fields'] = array(
                "title", "tags", "types", "keywords", "introtext"
            );
        }
        */

        // tags
        /*
        if(!empty($facets['tags'])){
            $esParams['body']['query']['match']['tags'] = $facets['tags'];
        }
        */

        //var_dump($esParams);die;

        // types
        
        /*
        if(!empty($facets)){
            $esParams['body']  = '{
                "query" : {
                    "multi_match" : {
                      "query": "'.  $facets['phrase'] .'",
                      "fields": ["title", "tags", "types", "keywords", "introtext"]
                    }
                }
            }';     
        }
        */
        

        //$esParams['body']['query']['match']['articles'] = $facets['phrase'];

        /*
        $filter = array();
        $filter['terms']['tags'] = $facets['tags'];
        $filter['terms']['types'] = $facets['types'];
        $filter['terms']['types'] = $facets['keywords'];
        $query['match_phrase']['tags'] = 'android';
        $query['multi_match']['query'] = 'example';
        $query['multi_match']['fields'] = '["input"]';
        $esParams['index'] = 'joomla';
        $esParams['body']['query']['match']['articles'] = $facets['phrase'];
        $esParams['body']['query']['filtered'] = array(
            "filter" => $filter,
            "query"  => $query
        );
        */
       
        $results = $esClient->search($esParams);

        $response = array();
        if(!empty($results['hits']['hits'])){
            $response['hits'] = $results['hits']['total'];
            $response['time'] = $results['took'];
            $response['max_score'] = $results['hits']['max_score'];
            $response['results'] = $results['hits']['hits'];
            //var_dump(json_encode($response));die;
        }

        return $response;
    }

    /*
    public function getResults($facets = null){
        $input = new JInput;
        $facets['phrase'] = $input->get('phrase', '', 'string');
        $facets['tags'] = $input->get('tags', '[]', 'array');
        $facets['types'] = $input->get('types', '[]', 'array');
        $facets['keywords'] = $input->get('keywords', '[]', 'array');

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
            'images'
        );
        $db = JFactory::getDBO();
        $query = $db->getQuery(true);
        $query->select($db->quoteName($returnValues));
        $query->from($db->quoteName('#__content'));
        $query->where($db->quoteName('state') . ' = '. $db->quote('1'));
        // TODO: filter categories
        //$query->where(?);
        $db->setQuery($query); 
        $results = $db->loadObjectList();

        // prepare each article
        foreach($results as $article){

            // add category alias (also type)
            $categories = JCategories::getInstance('content');
            $category = $categories->get($article->catid);
            $article->category = $category->alias;

            // add tags
            $tags = new JHelperTags;
            $tags->getItemTags('com_content.article', $article->id);
            $article->tags = array();
            foreach ($tags->itemTags as $tag){
                $article->tags[] = $tag->title;
            }

            // add keywords
            $keywords = preg_split('/[\s,]+/', $article->metakey);
            $article->keywords = $keywords;

            // decode json for json encoding...
            $article->images = json_decode($article->images);
        }

        // TODO: filterResults is a TEMPORARY hack
        return $this->filterResults($results, $facets);
    }
    */

    public function filterResults($results, $facets){
        foreach($results as $result){

        }
        return $results;
    }

    /*
    public function getResults() {
        $db = $this->getDbo();
        $query = $db->getQuery(true);
        $query
            ->select('id, title, ordering')
            ->from('#__jw_egresscalc_products')
            ->order('ordering ASC');
        $db->setQuery($query);
        $results = $db->loadObjectList();
        return $results;
    }

    public function getResultsByThingId($material_id) {
        $db = $this->getDbo();
        $query = $db->getQuery(true);
        $query
            ->select('id, title, ordering')
            ->from('#__jw_egresscalc_products')
            ->where('material_id = ' . $material_id)
            ->order('ordering ASC');
        $db->setQuery($query);
        $results = $db->loadObjectList();
        return $results;
    }
    */
}