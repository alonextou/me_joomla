<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla modelitem library
jimport('joomla.application.component.modelitem');
 
/**
 * HelloWorld Model
 */
class Cmd_searchModelResult extends JModelItem
{
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
}