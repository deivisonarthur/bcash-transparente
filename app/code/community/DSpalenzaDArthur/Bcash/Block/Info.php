<?php  
/**
 * Módulo Bcash Free
 *
 * @category   Payments
 * @package    DSpalenzaDArthur_Bcash
 * @license    OSL v3.0
 * @author	   Denis Spalenza e Deivison Arthur
 */
class DSpalenzaDArthur_Bcash_Block_Info extends Mage_Payment_Block_Info_Ccsave
{

    protected function _construct()
    {
        parent::_construct();
        $this->setTemplate('bcash/info.phtml');
    }


	/**
     * Recebe instancia corrente de order
     *
     * @return Mage_Sales_Model_Order
     */
    public function getOrder() {
        $order = Mage::registry('current_order');

		if (!$order) {
			if ($this->getInfo() instanceof Mage_Sales_Model_Order_Payment) {
				$order = $this->getInfo()->getOrder();
			}
		}
        
        if(!$order) {
            $bcash = Mage::getSingleton('bcash/payment_method_standard');
            $order = $bcash->getOrder();
        }

		return $order;
    }
    

    /**
     * Retrieve the BCash Transaction ID stored in Payment Object
     * 
     * @return string
     */
    public function getTransactionId()
    {
        $order = $this->getOrder();

        if($order && $order->getId()) {
            return $this->getOrder()->getPayment()->getBcashTransactionId();
        }

        return;
    }
    

    /**
     * Recupera URL de destino para redirect
     *  
     * @return string
     */
    public function returnUrlToRedirect() {
        $order = $this->getOrder();

        if(Mage::getSingleton('checkout/session')->getUrlRedirect()) {
            return Mage::getSingleton('checkout/session')->getUrlRedirect();
        } elseif(isset($order)) {
            $payment = $order->getPayment();
            return $payment->getPaybrasOrderId();
        } else {
            return NULL;
        }
    }
    

    /**
     * Gera informações do pagamento para admin.
     */
    protected function _prepareInfo()
    {
        $pagseguro = $this->getPagSeguro();
        if (!$order = $this->getInfo()->getOrder()) {
            $order = $this->getInfo()->getQuote();
        }
        
        $transactionId = $this->getInfo()->getPaybrasTransactionId();
        $url_redirect = $this->getInfo()->getPaybrasOrderId();
        $data = $this->getInfo()->getAdditionalData();
        $data = unserialize($data);
        
        $paymentMethod = $data['forma_pagamento'];
        
        if ($paymentMethod == 'boleto' && ($order->getState() == Mage_Sales_Model_Order::STATE_HOLDED || $order->getState() == Mage_Sales_Model_Order::STATE_PENDING_PAYMENT)) {
            $paymentMethod .= ' (<a href="' . $url_redirect . '" onclick="this.target=\'_blank\'">Reemitir</a>)';
        }
        
        if ($paymentMethod == 'boleto' && ($order->getState() == Mage_Sales_Model_Order::STATE_HOLDED || $order->getState() == Mage_Sales_Model_Order::STATE_PENDING_PAYMENT)) {
            $paymentMethod .= ' (<a href="' . $url_redirect . '" onclick="this.target=\'_blank\'">Página do BB - TEF</a>)';
        }
        
        $this->addData(array(
            'show_paylink' => (boolean) !$transactionId && $order->getState() == Mage_Sales_Model_Order::STATE_NEW,
            'pay_url' => $url_redirect,
            'show_info' => (boolean) $transactionId,
            'transaction_id' => $transactionId,
            'payment_method' => $paymentMethod,
        ));
    }

}