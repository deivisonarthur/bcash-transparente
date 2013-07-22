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
class DSpalenzaDArthur_Bcash_Model_Payment_Method_Standard_Data extends DSpalenzaDArthur_Bcash_Model_Abstract
{
	
	const RESULT_TYPE_ARRAY 	= 'array';
	const RESULT_TYPE_JSON 		= 'json';

	protected $_data = array();

	protected $_quote = null;
	protected $_paymentInfo = null;


	/**
	 * Starts the data prepare for transaction creation in BCash!
	 * 
	 * @param Mage_Sales_Model_Quote $quote
	 * @param Mage_Payment_Model_Info $paymentInfo
	 * @param string $resultType
	 * Allowed Types:
	 * - json
	 * - array
	 * 
	 * @return array
	 */
    public function getDataForTransaction(Mage_Sales_Model_Quote $quote, Mage_Payment_Model_Info $paymentInfo, $resultType = self::RESULT_TYPE_JSON)
    {
    	$this->_quote = $quote;
    	$this->_paymentInfo = $paymentInfo;

    	$this->_prepareData();

    	switch ($resultType) {
    		case self::RESULT_TYPE_ARRAY:
    			return $this->_data;

    		case self::RESULT_TYPE_JSON:
    		default:
    			return json_encode($this->_data);
    	}
    }


    /**
     * Gets the quote object
     * 
     * @return Mage_Sales_Model_Quote
     */
    protected function _getQuote()
    {
    	return $this->_quote;
    }


    /**
     * Gets the quote address.
     * If shipping is not available use billing address.
     * 
     * @return Mage_Sales_Model_Quote_Address
     */
    protected function _getQuoteAddress()
    {
    	$address = $this->_getQuote()->getShippingAddress();
    	if(!$address) {
    		$this->_getQuote()->getBillingAddress();
    	}

    	return $address;
    }


    /**
     * Gets the payment object
     * 
     * @return Mage_Payment_Model_Info
     */
    protected function _getPaymentInfo()
    {
    	return $this->_paymentInfo;
    }


    /**
     * Prepares all the information. Entry method.
     * 
     * @return DSpalenzaDArthur_Bcash_Model_Payment_Method_Standard_Data
     */
    protected function _prepareData()
    {
    	$this->_prepareDependentTransactions()
    		 ->_prepareProducts()
    		 ->_prepareBuyer()
    		 ->_prepareFreight()
    		 ->_preparePayment()
    		 ->_prepareSellerMail()
    		 ->_prepareOrderId()
			 ->_prepareAcceptedContract()
			 ->_prepareViewedContract()
			 ->_prepareUrlNotification()
			 ->_prepareUrlReturn()
    	;

    	return $this;
    }


    /**
     * Prepares 'dependentTransactions'
     * 
     * @return DSpalenzaDArthur_Bcash_Model_Payment_Method_Standard_Data
     */
    protected function _prepareDependentTransactions()
    {
    	/*
    	$this->_data['dependentTransactions'][] = array(
    		'email' => 'email@dependente.com.br',
            'value' => 5.00
    	);
    	*/

    	return $this;
    }


    /**
     * Prepares 'products'
     * 
     * @return DSpalenzaDArthur_Bcash_Model_Payment_Method_Standard_Data
     */
    protected function _prepareProducts()
    {
    	$items = $this->_getQuote()->getAllVisibleItems();

    	foreach($items as $item) {
    		$this->_data['products'][] = array(
    			'code' 				=> $item->getProductId(),
    			'description'		=> $item->getName(),
    			'amount'			=> $item->getQty(),
    			'value'				=> $item->getRowTotalInclTax(),
    			'extraDescription'	=> $item->getName(),
    		);
    	}

    	return $this;
    }


    /**
     * Prepares 'buyer'
     * 
     * @return DSpalenzaDArthur_Bcash_Model_Payment_Method_Standard_Data
     */
    protected function _prepareBuyer()
    {
    	$customer = $this->_getQuote()->getCustomer();

        $address = array();

        $quoteAddress = $this->_getQuoteAddress();

        switch($this->_getConfig('address_format')) {
            case DSpalenzaDArthur_Bcash_Model_System_Config_Source_Address_Format::ADDRESS_FORMAT_MULTILINE:
                $streetLine = $quoteAddress->getStreet();

                $address['street']          = $streetLine[(int) $this->_getConfig('address_format_multiline_street')];
                $address['number']          = $streetLine[(int) $this->_getConfig('address_format_multiline_number')];
                $address['neighborhood']    = $streetLine[(int) $this->_getConfig('address_format_multiline_neighborhood')];
                $address['complement']      = $streetLine[(int) $this->_getConfig('address_format_multiline_complement')];

                break;
            case DSpalenzaDArthur_Bcash_Model_System_Config_Source_Address_Format::ADDRESS_FORMAT_ATTRIBUTES:

                $address['street']          = $quoteAddress->getData($this->_getConfig('address_format_attribute_street'));
                $address['number']          = $quoteAddress->getData($this->_getConfig('address_format_attribute_number'));
                $address['neighborhood']    = $quoteAddress->getData($this->_getConfig('address_format_attribute_neighborhood'));
                $address['complement']      = $quoteAddress->getData($this->_getConfig('address_format_attribute_complement'));

                break;
            case DSpalenzaDArthur_Bcash_Model_System_Config_Source_Address_Format::ADDRESS_FORMAT_SINGLELINE:
            default:

                /**
                 * @todo Refactory for this case
                 * 
                 */
                $streetLine = $quoteAddress->getStreet();

                $address['street']          = $streetLine[0];
                $address['number']          = $streetLine[1];
                $address['neighborhood']    = $streetLine[2];
                $address['complement']      = $streetLine[3];
                
                break;
        }

    	$this->_data['buyer'] = array(
    		'address' => Array (
                'address' 		=> $address['street'],
                'number' 		=> $address['number'],
                'neighborhood' 	=> $address['neighborhood'],
                'complement' 	=> $address['complement'],
                'city' 			=> $this->_getQuoteAddress()->getCity(),
                'state' 		=> $this->_helper()->getRegionCode($this->_getQuoteAddress()->getRegion()),
                'zipCode' 		=> $this->_helper()->onlyNumbers($this->_getQuoteAddress()->getPostcode()),
            ),

            'mail' 		=> $customer->getEmail(),
            'name' 		=> $customer->getName(),
            'phone' 	=> $this->_helper()->onlyNumbers($this->_getQuoteAddress()->getTelephone()),
            'cellPhone' => $this->_helper()->onlyNumbers($this->_getQuoteAddress()->getTelephone()),
            //'gender' 	=> 'M',
            //'birthDate' => '21/09/1988',
            'cpf' 		=> $this->_helper()->onlyNumbers($customer->getTaxvat()),
            //'rg' 		=> '435627842',
    	);

    	return $this;
    }


    /**
     * Prepares freight information
     * 
     * @return DSpalenzaDArthur_Bcash_Model_Payment_Method_Standard_Data
     */
    protected function _prepareFreight()
    {
    	if($this->_getQuoteAddress()->getShippingAmount() > 0) {
	    	$this->_data['freight'] = $this->_getQuoteAddress()->getShippingAmount();
	    	$this->_data['freightType'] = $this->_getQuoteAddress()->getShippingDescription();
	    }

    	return $this;
    }


    /**
     * Prepares payment information
     * 
     * @return DSpalenzaDArthur_Bcash_Model_Payment_Method_Standard_Data
     */
    protected function _preparePayment()
    {
        $config = Mage::getSingleton('bcash/config');

        $cc = $config->getByCode($this->_getPaymentInfo()->getCcType());

    	$paymentMethodCode = $cc['method_code'];

    	$this->_data['paymentMethod'] = array(
    		'code' => $paymentMethodCode,
    	);

    	switch($paymentMethodCode) {
    		case 1:
    		case 2:
    		case 37:
    		case 45:
    			$this->_data['creditCard'] = array(
    				'number' 		=> $this->_helper()->onlyNumbers($this->_getPaymentInfo()->getCcNumber()),
		            'holder' 		=> $this->_getPaymentInfo()->getCcOwner(),
		            'maturityMonth' => $this->_helper()->onlyNumbers($this->_getPaymentInfo()->getCcExpMonth()),
		            'maturityYear' 	=> $this->_helper()->onlyNumbers($this->_getPaymentInfo()->getCcExpYear()),
		            'securityCode' 	=> $this->_getPaymentInfo()->getCcCid(),
    			);
    			$this->_data['installments'] = 1;
    			break;
    	}

    	return $this;
    }


    /**
     * Prepares 'sellerMail'
     * 
     * @return DSpalenzaDArthur_Bcash_Model_Payment_Method_Standard_Data
     */
    protected function _prepareSellerMail()
    {
    	$this->_data['sellerMail'] = $this->_getConfig('seller_email');

    	return $this;
    }


    /**
     * Prepares 'orderId'
     * 
     * @return DSpalenzaDArthur_Bcash_Model_Payment_Method_Standard_Data
     */
    protected function _prepareOrderId()
    {
    	$this->_data['orderId'] = $this->_getQuote()->getReservedOrderId();

    	return $this;
    }
	

	/**
     * Prepares 'acceptedContract'
     * 
     * @return DSpalenzaDArthur_Bcash_Model_Payment_Method_Standard_Data
     */
    protected function _prepareAcceptedContract()
    {
    	$this->_data['acceptedContract'] = 'S';

    	return $this;
    }


    /**
     * Prepares 'viewedContract'
     * 
     * @return DSpalenzaDArthur_Bcash_Model_Payment_Method_Standard_Data
     */
    protected function _prepareViewedContract()
    {
    	$this->_data['viewedContract'] = 'S';

    	return $this;
    }


    /**
     * Prepares 'urlNotification'
     * 
     * @return DSpalenzaDArthur_Bcash_Model_Payment_Method_Standard_Data
     */
    protected function _prepareUrlNotification()
    {
    	$this->_data['urlNotification'] = Mage::getUrl('bcash/standard/notification');

    	return $this;
    }


    /**
     * Prepares 'urlReturn'
     * 
     * @return DSpalenzaDArthur_Bcash_Model_Payment_Method_Standard_Data
     */
    protected function _prepareUrlReturn()
    {
    	$this->_data['urlReturn'] = Mage::getUrl('bcash/standard/return', array('order_id' => $this->_getQuote()->getReservedOrderId()));

    	return $this;
    }

}