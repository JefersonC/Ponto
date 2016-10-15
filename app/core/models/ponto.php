<?php

namespace models;

class ponto extends model implements \interfaces\model {

    public function get() {
        $this->setTable('ponto');

        $s = array('estado', 'id');

        $rs = $this->select($s)->exec('ALL');

        debug($rs);

        return $rs;
    }

    public function getPontos($data = null) {

        if (empty($_COOKIE['user'])) {
            throw new \Exception('Token inválido, por favor relogue-se');
        }

        if ($data == null) {
            $mes = date('m');
            $ano = date('Y');
        } else {
            $mes = date('m', strtotime($data));
            $ano = date('Y', strtotime($data));
        }

        $pontos = $this->getPontosPersistent($ano, $mes);

        if (empty($pontos)) {
            return null;
        }

        $rs = [];
        foreach ($pontos as $ponto) {

            $indice = substr($ponto['dataAbertura'], 0, 10);

            if (!isset($rs[$indice])) {
                $rs[$indice]['pontos'] = [];
                $rs[$indice]['total'] = 0;
                $rs[$indice]['totalFormatado'] = '00:00';
            }

            $rs[$indice]['total'] += strtotime($ponto['horas']);
            $rs[$indice]['totalFormatado'] = date('H:i', $rs[$indice]['total']);
            $rs[$indice]['pontos'][] = $ponto;
        }

        return $rs;
    }

    private function getPontosPersistent($ano, $mes) {
        $this->setTable('pontofechado');
        $w = array(
            'idUsuario = ?' => $_COOKIE['user'],
            'YEAR(dataAbertura) = ?' => $ano,
            'MONTH(dataAbertura) = ?' => $mes
        );

        return $this->select()->where($w)->exec('ALL');
    }

    public function getIndicadores() {
        if (empty($_COOKIE['user'])) {
            throw new \Exception('Token inválido, por favor relogue-se');
        }

        return array(
            'estado' => $this->checkEstado(),
            'horasDiarias' => $this->getHorasDiaria(),
            'horasMensais' => $this->getHorasMensais(),
            'horasNecessarias' => $this->getHorasNecessarias()
        );
    }

    private function checkEstado($retorneId = false) {
        $this->setTable('ponto');
        $w = array(
            'idUsuario = ?' => $_COOKIE['user'],
            'estado = ?' => 1
        );

        $s = array('id');

        $id = $this->select($s)->where($w)->exec('ROW');

        $rs = $this->getProperties();
        
        if($retorneId){
            return $id['id'];
        }
        
        return $rs['rowCount'];
    }

    private function getHorasDiaria() {
        $this->setTable('pontofechado');
        $w = array(
            'idUsuario = ?' => $_COOKIE['user'],
            "DATE_FORMAT(dataAbertura, '%Y-%c-%d') = '?'" => date('Y-m-d')
        );
        $s = 'SEC_TO_TIME( SUM( TIME_TO_SEC( horas ) ) ) as total';

        $rs = $this->select($s)->where($w)->exec('ROW');

        return $rs['total'];
    }

    private function getHorasMensais() {
        $this->setTable('pontofechado');
        $w = array(
            'idUsuario = ?' => $_COOKIE['user'],
            'YEAR(dataAbertura) = ?' => date('Y'),
            'MONTH(dataAbertura) = ?' => date('m')
        );
        $s = 'SEC_TO_TIME( SUM( TIME_TO_SEC( horas ) ) ) as total';

        $rs = $this->select($s)->where($w)->exec('ROW');

        return $rs['total'];
    }

    private function getHorasNecessarias() {
        $user = new \models\user();
        return $user->getCargaHoraria();
    }

    public function fechar() {
        
        if (empty($_COOKIE['user'])) {
            throw new \Exception('Token inválido, por favor relogue-se');
        }
        
        $estado = $this->checkEstado(true);

        if(empty($estado)){
            throw new \Exception("Nenhum apontamento em aberto.");
        }
        
        $w = array(
            'id = ?' => $estado
        );
        
        $u = array(
            'dataFechamento' => date('Y-m-d H:i:s'),
            'estado' => 2
        );
        
        $this->setTable('ponto');
        
        $this->update($u)->where($w)->exec();
        
        $rs = $this->getProperties();
        
        return empty($rs['error']);
    }
    
     public function abrir() {
        
        if (empty($_COOKIE['user'])) {
            throw new \Exception('Token inválido, por favor relogue-se');
        }
        
        $estado = $this->checkEstado(true);

        if(!empty($estado)){
            throw new \Exception("Existem apontamentos abertos.");
        }

        $i = array(
            'dataAbertura' => date('Y-m-d H:i:s'),
            'idUsuario' => $_COOKIE['user']
        );
        
        $this->setTable('ponto');
        
        $this->insert($i)->exec();
        
        $rs = $this->getProperties();
        
        return $rs['rowCount'] !== 0;
    }

}
