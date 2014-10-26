<?php

defined('JPATH_BASE') or die;

jimport('joomla.form.formfield');

class JFormFieldRelproducts extends JFormField
{
    protected $type = 'relproducts';

    protected function getInput()
    {   
        /*
        $articleId = $this->form->getValue('id');

        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('id, title');
        $query->from('#__jw_content_relproducts_products');
        $db->setQuery($query);
        $results = $db->loadObjectList();

        $query->clear();
        $query = $db->getQuery(true);
        $query->select('product_id');
        $query->from('#__jw_content_relproducts_related');
        $query->where('article_id =' . $db->quote($articleId));
        $db->setQuery($query);
        $existingResults = $db->loadResultArray();

        $html = array();
        foreach ($results as $result) {
            $checked = in_array($result->id, $existingResults) ? "checked" : "";
            $html[] = '<label>' .
                '<input type="checkbox" name="'.$this->name.'" id="'.$this->id.'" value="' . $result->id . '"'. $checked .' style="position: relative; top: -3px;">' .
                $result->title . '</label>';
        }
        return implode("\n", $html);
        */
    }
}