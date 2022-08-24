<?php

require_once 'model/AbstractClassModel.php';

class Finance extends AbstractClassModel {
    
    public function table() {
        return 'transaction'; 
    }
      
}

?>