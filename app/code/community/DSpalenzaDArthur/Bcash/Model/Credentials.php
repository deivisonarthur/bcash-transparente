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

/**
 * Bcash Standard Data Model
 *
 */
class DSpalenzaDArthur_Bcash_Model_Credentials extends DSpalenzaDArthur_Bcash_Model_Abstract
{

	protected $_consumerKey 	= null;
	protected $_token 			= null;
	protected $_sellerEmail 	= null;


	protected function _construct()
	{
		$this->_consumerKey 	= '1f5c18f0e65699f2568ca2751654fa7fc5ce94b0';
		$this->_token 			= 'lojamodelo@pagamentodigital.com.br';
		$this->_sellerEmail 	= '2948208E715B986F25A5E';

		$data = array(
			'consumer_key' 	=> $this->_consumerKey,
			'token' 		=> $this->_token,
			'seller_email' 	=> $this->_sellerEmail,
		);

		$this->setData($data);
	}


	/**
	 * Get all the informations by array
	 * 
	 * @return array
	 */
	public function getCredentials()
	{
		return $this->getData();
	}

}