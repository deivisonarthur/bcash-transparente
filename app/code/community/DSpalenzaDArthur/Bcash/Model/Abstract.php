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

abstract class DSpalenzaDArthur_Bcash_Model_Abstract extends Mage_Core_Model_Abstract
{

	/**
     * Gets the module helper instance
     * 
     * @return DSpalenzaDArthur_Bcash_Helper_Data
     */
    protected function _helper()
    {
        return Mage::helper('bcash');
    }


    /**
     * Get any configuration of the module
     * 
     * @param string $field
     * 
     * @return string
     */
    protected function _getConfig($field = null)
    {
    	if(!is_null($field)) {
    		return $this->_helper()->getConfig($field);
    	}

    	return;
    }


    /**
     * Get any configuration flag of the module
     * 
     * @param string $field
     * 
     * @return string
     */
    protected function _getConfigFlag($field = null)
    {
        if(!is_null($field)) {
            return $this->_helper()->getConfigFlag($field);
        }

        return;
    }

}