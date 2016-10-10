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
            setcookie('user', $rs['id'], time() + 3600);
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

}
