<?php

/**
 * Algolia custom sort order field
 */
class Algolia_Algoliasearch_Block_System_Config_Form_Field_Facets extends Mage_Adminhtml_Block_System_Config_Form_Field_Array_Abstract
{
    protected $selectFields = array();

    /**
     * Creates and populates a select block to represent each column in the configuration property.
     *
     * @param $columnId String The name of the column defined in addColumn
     * @return Algolia_Algoliasearch_Block_System_Config_Form_Field_Select
     * @throws Exception
     */
    protected function getRenderer($columnId) {
        if (!array_key_exists($columnId, $this->selectFields) || !$this->selectFields[$columnId]) {
            $aOptions = array();
            switch($columnId) {
                case 'attribute': // Populate the attribute column with a list of searchable attributes
                    $searchableAttributes = Mage::helper('algoliasearch')->getAllProductAttributes();

                    foreach ($searchableAttributes as $key => $label) {
                        $aOptions[$key] = $key ? $key : $label;
                    }
                    break;
                case 'type':
                    $aOptions = array(
                        'conjunctive'   => 'Conjunctive',
                        'disjunctive'   => 'Disjunctive',
                        'slider'        => 'Slider',
                        'other'         => 'Other ->'
                    );
                    break;
                default:
                    throw new Exception('Unknown attribute id ' . $columnId);
            }

            $selectField = Mage::app()->getLayout()->createBlock('algoliasearch/system_config_form_field_select')->setIsRenderToJsTemplate(true);
            $selectField->setOptions($aOptions);
            $selectField->setExtraParams('style="width:160px;"');
            $this->selectFields[$columnId] = $selectField;
        }
        return $this->selectFields[$columnId];
    }

    public function __construct()
    {
        $this->addColumn('attribute', array(
            'label' => Mage::helper('adminhtml')->__('Attribute'),
            'renderer'=> $this->getRenderer('attribute'),
        ));

        $this->addColumn('type', array(
            'label' => Mage::helper('adminhtml')->__('Facet type'),
            'renderer'=> $this->getRenderer('type'),
        ));

        $this->addColumn('other_type', array(
            'label' => Mage::helper('adminhtml')->__('Other facet type'),
        ));

        $this->addColumn('label', array(
            'label' => Mage::helper('adminhtml')->__('Label'),
        ));

        $this->_addAfter = false;
        $this->_addButtonLabel = Mage::helper('adminhtml')->__('Add Attribute');
        parent::__construct();
    }

    protected function _prepareArrayRow(Varien_Object $row)
    {
        $row->setData(
            'option_extra_attr_' . $this->getRenderer('attribute')->calcOptionHash(
                $row->getAttribute()),
            'selected="selected"'
        );
    }
}
