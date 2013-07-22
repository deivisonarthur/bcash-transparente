<?php
/**
 * Tiago Sampaio
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License (AFL 3.0)
 * that is bundled with this package in the file LICENSE_AFL.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/afl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@tiagosampaio.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.tiagosampaio.com for more information.
 *
 * @category    DSpalenzaDArthur
 * @package     DSpalenzaDArthur_Bcash
 * @author      Tiago Sampaio (tiago@tiagosampaio.com)
 * @copyright   Copyright (c) 2012 Tiago Sampaio. (http://tiagosampaio.com)
 * @license     http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 */
abstract class DSpalenzaDArthur_Bcash_Model_System_Config_Source_Attribute_Abstract extends DSpalenzaDArthur_Bcash_Model_Abstract
{

	protected $_resourceModel = null;
	protected $_resourceClass = null;


	abstract protected function _getCollection();

    public function toOptionArray()
    {
        $collection = $this->_getCollection();

        $data = array();

        foreach($collection as $row) {

        	Mage::log($row->debug(), null, '$row.log');
        	
        	
        	$data[] = array(
        		'value' => $row->getAttributeCode(),
        		'label' => ($row->getFrontendLabel() ? $row->getFrontendLabel() : $row->getAttributeCode()),
        	);
        }


        return $data;
    }
    
}