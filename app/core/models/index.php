<?php

namespace models;

class index extends model implements \interfaces\model {
    
    public function get(){
        $this->setTable('category');
        
        $s = array(
            'name',
            '`limit`',
            '(SELECT SUM(`value`) FROM bill WHERE bill.idCategory = category.id) as total'
        );
        
        $rs = $this->select($s)->exec('ALL');
        return $rs;
    }
    
    public function test(){
        
        $this->setTable('bill');

        $i = array(
            'idCategory' => 1,
            'value' => 40,
            'description' => 'Aniversário do Igor'
        );
        
        $rs = $this->insert($i)->exec();
        
        debug($this->getProperties());
        
    }
}
