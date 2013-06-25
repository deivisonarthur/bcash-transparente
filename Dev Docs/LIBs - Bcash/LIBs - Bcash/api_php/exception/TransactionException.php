<?php 


class TransactionException extends Exception{
	
    public function __construct($message, $code = 0, Exception $previous = null) {
        parent::__construct($message, $code);
    }

    public function __toString() {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }
	
	
}

?>