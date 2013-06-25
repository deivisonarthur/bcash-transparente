<?php
/** 
 * Módulo Bcash Free
 *
 * @category   Payments
 * @package    DSpalenzaDArthur_Bcash
 * @license    OSL v3.0
 * @author	   Denis Spalenza e Deivison Arthur
 */
class DSpalenzaDArthur_Bcash_StandardController extends Mage_Core_Controller_Front_Action {

    /**
     * Header de Sessão Expirada
     *
     */
    protected function _expireAjax() {
        if (!Mage::getSingleton('checkout/session')->getQuote()->hasItems()) {
            $this->getResponse()->setHeader('HTTP/1.1', '403 Session Expired');
            exit;
        }
    }

    /**
     * Retorna singleton do Model do Módulo.
     *
     * @return Xpd_Paybras_Model_Standard
     */
    public function getStandard() {
        return Mage::getSingleton('bcash/standard');
    }
    
    /**
     * Processa pagamento - cria transação via WebService 
     * 
     */
    protected function redirectAction() {
        
    }
    
    /**
     * Captura Notificação do Pagamento
     * 
     */
    public function capturaAction() { //Código reaproveitado, deverá ser modificado.
        if($this->getRequest()->isPost() && Mage::getStoreConfig('payment/bcash/notification')) {
            $bcash = $this->getStandard();
            $bcash->log($json);
            $json = $_POST['data'];
            
            if(!$json) {
                $json = $_POST;
                $transactionId = $json['transacao_id'];
                $pedidoId = $json['pedido_id'];
                $pedidoIdVerifica = $pedidoId;
                $valor = $json['valor_original'];
                $status_codigo = $json['status_codigo'];
                $status_nome = $json['status_nome'];
                $recebedor_api = $json['recebedor_api_token'];
            }
            else {
                $json = json_decode($json);
                $transactionId = $json->{'transacao_id'};
                $pedidoId = $json->{'pedido_id'};
                $pedidoIdVerifica = $pedidoId;
                $valor = $json->{'valor_original'};
                $status_codigo = $json->{'status_codigo'};
                $status_nome = $json->{'status_nome'};
                $recebedor_api = $json->{'recebedor_api_token'};
            }
            
            //var_dump($transactionId);
//            var_dump($pedidoId);
//            var_dump($valor);
//            var_dump($status_codigo);
//            var_dump($status_nome);
//            var_dump($recebedor_api);
            
            $bcash->log($pedidoId);
            $bcash->log($status_codigo);
            
            if($transactionId && $status_codigo && $pedidoId) {
                if(strpos($pedidoId,'_') !== false) {
                    $pedido = explode("_",$pedidoId);
                    $orderId = $pedido[0];
                }
                else {
                    $orderId = $pedidoId;
                }
                
                $order = Mage::getModel('sales/order')
                  ->getCollection()
                  ->addAttributeToFilter('increment_id', $orderId)
                  ->getFirstItem();
                
                $status = (int)$status_codigo;
                                
                if($bcash->getEnvironment() == '1') {
                    $url = 'https://service';
                }
                else {
                    $url = 'https://sandbox';
                }
                
                $fields = array(
                    'recebedor_email' => $bcash->getEmailStore(),
                    'recebedor_api_token' => $bcash->getToken(),
                    'transacao_id' => $transactionId,
                    'pedido_id' => $pedidoId
                );
                
                //var_dump($fields);
                $curlAdapter = new Varien_Http_Adapter_Curl();
                $curlAdapter->setConfig(array('timeout'   => 20));
                $curlAdapter->write(Zend_Http_Client::POST, $url, '1.1', array(), $fields);
                $resposta = $curlAdapter->read();
                $retorno = substr($resposta,strpos($resposta, "\r\n\r\n"));
                $curlAdapter->close();
                
                $json = json_decode($retorno);
                if($json->{'sucesso'} == '1') {
                    if($json->{'pedido_id'} == $pedidoIdVerifica && $json->{'valor_total'} == $valor && $json->{'status_codigo'} == $status_codigo) {
                        $result = $bcash->processStatus($order,$status,$transactionId);
                        if($result >= 0) {
                            echo '{"retorno"."OK"}';
                        }
                    }
                }
                else {
                    $bcash->log('Erro resposta de Consulta');
                }
            }
            else {
                $bcash->log('Erro na Captura - Nao foi possivel pergar os dados');
                $bcash->log($json);
                echo 'Erro na Captura - Nao foi possivel pergar os dados';
            }
        }
    }
}
