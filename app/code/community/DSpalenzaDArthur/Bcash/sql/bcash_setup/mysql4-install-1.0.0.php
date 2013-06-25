<?php 

$installer = $this;

$installer->startSetup();

$installer->addAttribute('order_payment', 'bcash_transaction_id', array());
$installer->addAttribute('order_payment', 'bcash_field', array());

/*$attribute  = array( 
        'type'          => 'text',
        'backend_type'  => 'text',
        'frontend_input' => 'text',
        'is_user_defined' => true,
        'label'         => 'Paybras Transaction',
        'visible'       => true,
        'required'      => false,
        'user_defined'  => false,   
        'searchable'    => false,
        'filterable'    => true,
        'comparable'    => true,
        'default'       => ''
);
$installer->addAttribute('order', 'paybras_transaction', $attribute);*/

$installer->endSetup();
