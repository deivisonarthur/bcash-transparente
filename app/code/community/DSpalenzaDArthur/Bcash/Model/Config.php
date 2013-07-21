<?php
/** 
 * Módulo Bcash Free
 *
 * @category   Payments
 * @package    DSpalenzaDArthur_Bcash
 * @license    OSL v3.0
 * @author	   Denis Spalenza e Deivison Arthur
 */
class DSpalenzaDArthur_Bcash_Model_Config extends Mage_Payment_Model_Config
{
    
    protected $_ccTypes = array();

    /**
     * Retrieve array of credit card types
     *
     * @return array
     */
    public function getCcTypes()
    {
        $_types = $this->getCcTypesArray();
        uasort($_types, array('DSpalenzaDArthur_Bcash_Model_Config', 'compareCcTypes'));

        $types = array();
        
        foreach ($_types as $data) {
            $types[$data['code']] = $data['name'];
        }

        return $types;
    }


    /**
     * Retrieve the global/bcash/cc/types node from config
     * 
     * @return array
     */
    public function getCcTypesArray()
    {
        if(!$this->_ccTypes) {
            $this->_ccTypes = Mage::getConfig()->getNode('global/bcash/cc/types')->asArray();
        }

        return $this->_ccTypes;
    }


    /**
     * Retrieve the global/bcash/cc/types node from config by code
     * 
     * @return array
     */
    public function getByCode($code = null)
    {
        $data = array();

        if(!is_null($code)) {
            $data = $this->getCcTypesArray();
            return $data[$code];
        }

        return $data;
    }

}