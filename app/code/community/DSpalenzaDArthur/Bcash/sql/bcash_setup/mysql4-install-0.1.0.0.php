<?php 

$installer = $this;
$installer->startSetup();

$attribute = array(
    'type'           	=> 'text',
    'backend_type'   	=> 'text',
    'frontend_input' 	=> 'text',
    'is_user_defined' 	=> true,
    'label'       		=> 'Bacash Transaction ID',
    'visible'         	=> true,
    'required'         	=> false,
    'user_defined'     	=> false,   
);

$installer->addAttribute('quote_payment', 'bcash_transaction_id', $attribute);
$installer->addAttribute('order_payment', 'bcash_transaction_id', $attribute);

$installer->endSetup();