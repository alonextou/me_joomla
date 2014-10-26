<?php
/**
 * @version     1.0.0
 * @package     com_cmd_search
 * @copyright   Copyright (C) 2013. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Alex Crawford <acrawford@cmdagency.com> http://cmdagency.com
 */
// no direct access
defined('_JEXEC') or die('Restricted access');
$document = JFactory::getDocument();

JHtml::_('jquery.framework', true);

$document->addScript('components/com_cmd_search/assets/js/index.js');
?>

<button id="cmd-index-articles">Index Articles</button>
<button id="cmd-purge-articles">Purge Articles</button>