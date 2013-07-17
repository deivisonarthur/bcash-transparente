<?php
/**
 * Módulo Bcash Free
 *
 * @category   Payments
 * @package    DSpalenzaDArthur_Bcash
 * @license    OSL v3.0
 * @author	   Denis Spalenza e Deivison Arthur 
 */
class DSpalenzaDArthur_Bcash_Block_Standard_Redirect extends Mage_Core_Block_Abstract
{
    
    protected function _toHtml()
    {
        $session = Mage::getSingleton('checkout/session');
        $html = '<html><body>';
        $html.= $this->__('<center>Processando</center>');
				$html.= '<script type="text/javascript">window.location.href = "' . $session->getRedirectUrl() . '"</script>';
        $html.= '</body></html>';

        return $html;
    }
    
}