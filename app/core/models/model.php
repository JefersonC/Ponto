<?php

namespace models;

class model {

    private $host = 'localhost';
    private $user = 'root';
    private $pass = '';
    private $db = 'ponto';
    private $conn;
    private $values = [];
    private $sql;
    private $table;
    private $properties = [];
    private $error = [];

    function __construct() {

        try {
            $this->conn = new \PDO('mysql:host=' . $this->host . ';dbname=' . $this->db . ';charset=utf8', $this->user, $this->pass, array(
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION
            ));
        } catch (PDOException $e) {
            debug($e);
        }
    }

    public function setTable($tableName, $alias = null) {
        $this->table = $tableName . ($alias ? ' AS ' . $alias : '');
    }

    protected function insert($args = array()) {

        $this->sql = "INSERT INTO $this->table ";

        $index = array_keys($args);
        $values = array_values($args);

        $this->sql .= "(`" . implode("`, `", $index) . "`) VALUES ('" . implode("', '", $values) . "')";

        return $this;
    }

    /**
     * Método para montar a cláusula SELECT seguindo padrões MySQl
     *  
     * -------------------------------------------------------------------------
     *  Método trata a entrada, se nula, acrescenta um asterisco para pegar 
     * todos os campos, se for uma string a adiciona diretamente na query
     * e se for um array, percorre-o montando o código sql.
     * -------------------------------------------------------------------------
     * 
     * @method select
     * @depends setTable
     * @access protected
     * @author Jeferson Capobianco <jefersoncapobianco@gmail.com>
     * @example array('id', 'name') //out: SELECT id, name FROM....
     * @param array $fields                 campos para serem listados na consulta.
     * @return \models\model
     */
    protected function select($fields = null) {

        $this->sql = "SELECT ";

        if ($fields === null) {
            $this->sql .= "*";
        } elseif (is_array($fields)) {

            $query = '';
            foreach ($fields as $f) {
                $query .= $f . ', ';
            }

            $this->sql .= substr($query, 0, -2);
        } else {
            $this->sql .= $fields;
        }

        $this->sql .= " FROM " . $this->table;
        return $this;
    }

    protected function update($args = array(), $strict = false) {

        $this->sql = "UPDATE $this->table SET ";

        $query = '';

        foreach ($args as $k => $v) {
            if (!$strict) {
                if (!empty($v)) {
                    $value = (is_numeric($v) ? $v : "'" . $v . "'");
                    $query .= "`$k` = $value, ";
                }
            } else {
                if (!empty($v)) {
                    $value = (is_numeric($v) ? $v : "'" . $v . "'");
                    $query .= "`$k` = $value, ";
                } else {
                    $query .= "`$k` = NULL, ";
                }
            }
        }

        $this->sql .= substr($query, 0, -2);

        return $this;
    }

    protected function delete() {
        $this->sql = "DELETE FROM " . $this->table;
        return $this;
    }

    /**
     * Método para montar a cláusula WHERE seguindo padrões MySQl
     *  
     * -------------------------------------------------------------------------
     *  Método para montar a condição na hora de elaborar a query
     * -------------------------------------------------------------------------
     * 
     * @method where
     * @depends select, delete or update
     * @access protected
     * @author Jeferson Capobianco <jefersoncapobianco@gmail.com>
     * @example array('id = ?' => 1, "name LIKE '%?'" => "Jeff") //out: WHERE id = 1 AND name LIKE '%Jeff'....
     * @param array $condition array com indices e valores correspondentes a condição que será executada
     * @param string $method Tipo de concatenação entre os parâmetros, podendo ser OR ou AND
     * @return \models\model
     */
    protected function where($condition = null, $method = null) {

        $method = ($method ? $method : 'AND');

        if ($condition === null) {
            return $this;
        }

        $this->sql .= " WHERE";

        if (is_array($condition)) {

            $query = '';
            foreach ($condition as $k => $v) {
                $query .= ' ' . $k . ' ' . $method;
                $this->values[] = $v;
            }

            $len = strlen($method) + 1;

            $this->sql .= substr($query, 0, $len * -1);
        } else {
            $this->sql .= " " . $condition;
        }

        return $this;
    }

    public function debug() {
        echo $this->sql;
        exit;
    }

    protected function query($query) {
        $this->sql = $query;
        return $this;
    }

    protected function exec($fetch = NULL, $fethMethod = \PDO::FETCH_ASSOC) {
        
        try{
        $exec = $this->conn->prepare($this->sql);
        $exec->execute($this->values);
        }catch(Exception $e){
            debug($e);
        }

        $rs = null;

        switch ($fetch) {
            case "ROW":
                $rs = $exec->fetch($fethMethod);
                break;
            case "ALL":
                $rs = $exec->fetchAll($fethMethod);
                break;
        }

        $this->properties['rowCount'] = $exec->rowCount();
        $this->properties['lastId'] = $this->conn->lastInsertId();
        $this->properties['error'] = $exec->errorCode();
        $this->error = $exec->errorInfo();

        if (empty($this->error)) {
            return $rs;
        } else {
            return false;
        }
    }

    public function getError() {
        return $this->error;
    }

    public function getProperties() {
        return $this->properties;
    }

}
