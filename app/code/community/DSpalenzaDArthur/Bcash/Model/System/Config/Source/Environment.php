<?php
/**
 * Módulo Bcash Free
 * 
 * @category   Payments
 * @package    DSpalenzaDArthur_Bcash
 * @license    OSL v3.0
 * @author	   Denis Spalenza e Deivison Arthur
 */

class DSpalenzaDArthur_Bcash_Model_System_Config_Source_Environment
{

    const ENVIROMENT_MODE_SANDBOX       = 0;
    const ENVIROMENT_MODE_PRODUCTION    = 1;

    public function toOptionArray()
    {
        return array(
            /**
             * The Sandbox environment is not ready for tests
             * Need to use Production mode
             * 
            array(
                'value' => self::ENVIROMENT_MODE_SANDBOX,
                'label' => Mage::helper('bcash')->__('Sandbox'),
            ),
            */
            array(
                'value' => self::ENVIROMENT_MODE_PRODUCTION,
                'label' => Mage::helper('bcash')->__('Production'),
            ),
        );
    }

}