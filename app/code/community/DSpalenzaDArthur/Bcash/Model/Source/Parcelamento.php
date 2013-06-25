<?php
/**
 * Módulo Bcash Free
 *
 * @category   Payments
 * @package    DSpalenzaDArthur_Bcash
 * @license    OSL v3.0
 * @author	   Denis Spalenza e Deivison Arthur
 */
class DSpalenzaDArthur_Bcash_Model_Source_Parcelamento
{
    public function toOptionArray()
    {
        return array(
            array(
                'value' => 2,
                'label' => 'Loja'
            ),
            array(
                'value' => 3,
                'label' => 'Administradora'
            ),
        );
    }
}

