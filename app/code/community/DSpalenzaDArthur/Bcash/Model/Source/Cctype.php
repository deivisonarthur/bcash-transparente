<?php
/** 
 * Módulo Bcash Free
 *
 * @category   Payments
 * @package    DSpalenzaDArthur_Bcash
 * @license    OSL v3.0
 * @author	   Denis Spalenza e Deivison Arthur
 */
class DSpalenzaDArthur_Bcash_Model_Source_Cctype extends Mage_Payment_Model_Source_Cctype
{
  public function getAllowedTypes()
  {
      return array('VI', 'MC');
  }
}

