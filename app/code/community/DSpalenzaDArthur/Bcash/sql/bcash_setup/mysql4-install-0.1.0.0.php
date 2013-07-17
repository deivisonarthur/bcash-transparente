<?php 

$installer = $this;

$installer->startSetup();

$installer->addAttribute('order_payment', 'bcash_transaction_id', array(
        'type'                  => 'text',
        'backend_type'          => 'text',
        'frontend_input'        => 'text',
        'is_user_defined'       => true,
        'label'                 => 'Bacash Transaction ID',
        'visible'               => true,
        'required'              => false,
        'user_defined'          => false,   
));

$installer->endSetup();
