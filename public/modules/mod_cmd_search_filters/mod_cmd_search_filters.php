<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_cmd_search_filters
 *
 * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

// Include the syndicate functions only once
require_once __DIR__ . '/helper.php';
require_once JPATH_ROOT . '/components/com_cmd_search/helpers/cmd_search.php';

$searchFacets = $params->get('cmd_search_facets');
$facetFilters = Cmd_searchHelper::getFacetFilters($searchFacets);

//$list = &ModBannersHelper::getList($params);

require JModuleHelper::getLayoutPath('mod_cmd_search_filters', $params->get('layout', 'default'));