<?php
/**
 * Módulo Bcash Free
 * 
 * @category   Payments
 * @package    DSpalenzaDArthur_Bcash
 * @license    OSL v3.0
 * @author	   Denis Spalenza e Deivison Arthur
 */
class DSpalenzaDArthur_Bcash_Model_Payment_Method_Standard extends Mage_Payment_Model_Method_Abstract
{

    protected $_code = 'bcash';
    
    protected $_formBlockType = 'bcash/form_cc';
    protected $_infoBlockType = 'bcash/info';

    protected $_isInitializeNeeded      = true;
    protected $_canUseInternal          = true;
    protected $_canUseForMultishipping  = true;
    protected $_canUseCheckout          = true;
    protected $_isGateway               = true;
    protected $_canOrder                = true;


    /**
     * Holds the order object
     * 
     * @var Mage_Sales_Model_Order
     */
    protected $_order = null;

    /**
     * Holds the quote object
     * 
     * @var Mage_Sales_Model_Quote
     */
    protected $_quote = null;
    
    public $formaPagamentoBandeira;
    public $formaPagamentoProduto;
    public $formaPagamento;
    

    /**
     *  Recupera order (pedido) para utilização do módulo
     *
     *  @return	Mage_Sales_Model_Order
     */
    public function getOrder()
    {
        if ($this->_order == null) {
            $this->_order = Mage::getModel('sales/order')->load(Mage::getSingleton('checkout/session')->getLastOrderId());
        }
        
        return $this->_order;
    }


    /**
     * Gets the quote object
     * 
     * @return Mage_Sales_Model_Quote
     */
    public function getQuote()
    {
        if(is_null($this->_quote)) {
            $this->_quote = Mage::getSingleton('checkout/session')->getQuote();
        }

        return $this->_quote;
    }
    

    /**
     * Recupera a forma de pagamento
     * 
     * @return string
     */
    public function getFormaPagamento()
    {
        return $this->formaPagamento;
    }


    /**     
     * Registra log de eventos/erros.
     * 
     * @param string $message
     * @param integer $level
     * @param string $file
     * @param bool $forceLog
     */
    public function log($message, $level = null, $file = 'bcash.log', $forceLog = false)
    {
        Mage::log("Bcash - " . $message, $level, 'bcash.log', $forceLog);
    }
    

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
     * Retorna ambiente da loja
     * 
     * @return int
     */
    public function getEnvironment()
    {
        return Mage::getStoreConfig('payment/bcash/environment');
    }

    
    /**
     * Sobrecarga da função assignData, acrecentado dados adicionais.
     * 
     * @return Mage_Payment_Model_Method_Cc
     */
    public function assignData($data)
    {
        $details = array();
        if (!($data instanceof Varien_Object)) {
            $data = new Varien_Object($data);
        }
        $info = $this->getInfoInstance();
        $additionaldata = array('cc_parcelas' => $data->getCcParcelas(), 'cc_cid_enc' => $info->encrypt($data->getCcCid()), 'cpf_titular' => $data->getCcCpftitular(), 'day_titular' => $data->getCcDobDay(), 'month_titular' => $data->getCcDobMonth(), 'year_titular' => $data->getCcDobYear(), 'tel_titular' => $data->getPhone(), 'forma_pagamento' => $data->getCheckFormapagamento());
        $info->setAdditionalData(serialize($additionaldata));
        $info->setCcType($data->getCcType());
        $info->setCcOwner($data->getCcOwner());
        $info->setCcExpMonth($data->getCcExpMonth());
        $info->setCcExpYear($data->getCcExpYear());
        $info->setCcNumberEnc($info->encrypt($data->getCcNumber()));
        $info->setCcCidEnc($info->encrypt($data->getCcCid()));
        $info->setCcLast4(substr($data->getCcNumber(), -4));
        
        $this->formaPagamento = $data->getCheckFormapagamento();
        
        return $this;
    }
    

    /**
     * Analisa o status e em caso de pagamento aprovado, cria a fatura. No caso do status recusado ou não aprovado, cancela o pedido.
     * 
     * @return integer
     */
    public function processStatus($order,$status,$transactionId)
    {
        if ($status == 4) {
            if ($order->canUnhold()) {
        	    $order->unhold();
        	}
            if ($order->canInvoice()) {
                $invoice = $order->prepareInvoice();
                $invoice->register()->pay();
                $invoice_msg = utf8_encode(sprintf('Pagamento confirmado. Transa&ccedil;&atilde;o: %s', $transactionId));
                $invoice->addComment($invoice_msg, true);
                $invoice->sendEmail(true, $invoice_msg);
                $invoice->setEmailSent(true);
                
                Mage::getModel('core/resource_transaction')
                   ->addObject($invoice)
                   ->addObject($invoice->getOrder())
                   ->save();
                $comment = utf8_encode(sprintf('Fatura %s criada.', $invoice->getIncrementId()));
                $this->changeState($order,$status,NULL,$comment);
                Mage::getSingleton("core/session")->clear();
                return 1;
            }
            else {
                $this->log("Fatura nao pode ser criada");
                return -1;
            }
        }
        elseif ($status == 3 || $status == 5) {
            if ($order->canUnhold()) {
	           $order->unhold();
            }
            if ($order->canCancel()) {
                $order_msg = "Pedido Cancelado. Transação: ". $transactionId;
        		$this->changeState($order,$status,NULL,$order_msg);
        		$order->cancel();
                $this->log("Pedido Cancelado: ".$order->getRealOrderId() . ". Transação: ". $transactionId);
                return 0;
            }
            else {
                $this->log("Pedido não pode ser Cancelada.");
                return -1;
            }
        }
        elseif($status == 2) {
            $order_msg = "Pedido em análise. Transação: ". $transactionId;
    		$this->changeState($order,$status,NULL,$order_msg);
            $this->log("Pedido em analise: ".$order->getRealOrderId() . ". Transação: ". $transactionId);
            return 0;
        }
        elseif($status == 1) {
            $order_msg = "Aguardando Pagamento. Transação: ". $transactionId;
    		$this->changeState($order,$status,NULL,$order_msg);
            $this->log("Aguardando Pagamento, pedido: ".$order->getRealOrderId() . ". Transação: ". $transactionId);
            return 0;
        }
        
        return -1;
    }
    

    /**
     * Altera estado de um pedido
     * 
     */
    public function changeState($order,$cod_state,$status,$comment)
    {
        $state = $this->convertState($cod_state);
        $status = $this->convertStatus($cod_state);

        $order->setState($state, $status, $comment, true);
        $order->getPayment()->setMessage($comment);    
        $order->save();
    }
    

    /**
     * Converte número de estado do pagamento para estado do Magento
     * 
     * @return Mage_Sales_Model_Order
     */
    public function convertState($num)
    {
        switch($num) {
            case 1: return Mage_Sales_Model_Order::STATE_PENDING_PAYMENT;
            case 2: return Mage_Sales_Model_Order::STATE_HOLDED;
            case 3: return Mage_Sales_Model_Order::STATE_CANCELED;
            case 4: return Mage_Sales_Model_Order::STATE_PROCESSING;
            case 5: return Mage_Sales_Model_Order::STATE_CANCELED;
            default: return Mage_Sales_Model_Order::STATE_PENDING_PAYMENT;
        }
    }
    

    /**
     * Converte número de status do meio de pagamento para status do Magento
     * 
     * @return string
     */
    public function convertStatus($num)
    {
        $num = (int)$num;
        switch($num) {
            case 1: return 'pending_payment';
            case 2: return 'holded';
            case 3: return 'canceled';
            case 4: return 'processing';
            case 5: return 'canceled';
            default: return 'pending_payment';
        }
    }


    /**
     * Method that will be executed instead of authorize or capture
     * if flag isInitializeNeeded set to true
     *
     * @param string $paymentAction
     * @param Varien_Object $stateObject
     *
     * @return Mage_Payment_Model_Abstract
     */
    public function initialize($paymentAction, $stateObject)
    {
        return $this->$paymentAction();
    }


    /**
     * Makes the real transaction request.
     * 
     * @author Tiago Sampaio
     */
    public function createTransaction()
    {
        $data = Mage::getModel('bcash/payment_method_standard_data')->getDataForTransaction($this->getQuote(), $this->getInfoInstance());

        Mage::log(json_decode($data), null, '$data.log');

        $result = Mage::getModel('bcash/connection')->createTransaction($data);

        if($this->_helper()->getConfigFlag('checkout_stop_processing')) {
            if(!$this->_helper()->getConfigFlag('checkout_stop_processing_use_default_message')) {
                Mage::throwException($result->message);
            } elseif ($result->status == DSpalenzaDArthur_Bcash_Model_Connection::TRANSACTION_STATUS_CANCELED) {
                $message = $this->_helper()->getConfigFlag('checkout_stop_processing_message');

                if(!$message) {
                    $message = $this->_helper()->__('Your payment was refused. Please try again selecting another payment method.');
                }

                Mage::throwException($message);
            }
        }

        $this->getInfoInstance()->setBcashTransactionId($result->transactionId);
    }


    public function validate()
    {
    	parent::validate();
        
        $info = $this->getInfoInstance();
        
    	$cartaobandeira     = str_replace("cc_", "", $info->getCcType());
        $nomecartao         = $info->getCcOwner();
    	$numerocartao       = $info->decrypt($info->getCcNumberEnc());
    	$expiracaomes       = $info->getCcExpMonth();
    	$expiracaoano       = $info->getCcExpYear();
    	$codseguranca       = $info->decrypt($info->getCcCidEnc());
    	$tefbandeira        = $info->getBandeiraTef();
    	//$formapagamento     = $info->getCheckFormapagamento();
        $additionaldata     = $info->getAdditionalData();
        
    	if(!$additionaldata['forma_pagamento']) {
    		$errorCode = 'invalid_data';
    		$errorMsg = $this->_getHelper()->__('Selecione uma forma de pagamento');
    		Mage::throwException($errorMsg);
    	}
        
    	return $this;
    }
    
}
