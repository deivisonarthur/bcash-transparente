<?php
/**
 * Módulo Bcash Free
 *
 * @category   Payments
 * @package    DSpalenzaDArthur_Bcash
 * @license    OSL v3.0
 * @author	   Denis Spalenza e Deivison Arthur
 */
class DSpalenzaDArthur_Bcash_Model_Source_Environment
{
    public function toOptionArray()
    {
        return array(
            array(
                'value' => 0,
                'label' => 'Sandbox'
            ),
            array(
                'value' => 1,
                'label' => 'Produção'
            ),
        );
    }
}

