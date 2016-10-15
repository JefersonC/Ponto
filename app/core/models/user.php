<?php

namespace models;

class user extends model implements \interfaces\model {

    public function get() {
        
    }

    public function login($user) {
        $this->setTable('usuario');

        $w = array(
            "email = '?'" => $user['user'],
            "senha = '?'" => md5($user['password']),
        );

        $s = array(
            'id'
        );
        $rs = $this->select($s)->where($w)->exec('ROW');

        if (!empty($rs['id'])) {
            setcookie('user', $rs['id'], (time() + (15 * 24 * 3600)), '/');
            return true;
        }
        return false;
    }

    public function check() {
        return !empty($_COOKIE['user']);
    }

    public function logout() {
        unset($_COOKIE["user"]);
        setcookie("user", false, time() - 1);
        return true;
    }
    
     public function getCargaHoraria() {
        if(empty($_COOKIE['user'])){
            throw new \Exception('Token inválido, por favor relogue-se');
        }
        
        $this->setTable('usuario u');
        $s = ('c.cargaHoraria');
        $j = array(
            'table' => 'cargo c',
            'cond' => 'u.idCargo = c.id'
        );
        $w = array(
            'u.id = ?' => $_COOKIE['user']
        );
        
        $rs = $this->select($s)->join($j)->where($w)->exec('ROW');
        
        return $rs['cargaHoraria'];
    }
    

}
