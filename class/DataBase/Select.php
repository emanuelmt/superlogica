<?php

class Select
{

    private $Result;
    private $Error;
    private $Query;
    private $Params;
    /** @var PDOStatement */
    private $Statement;
    /** @var PDO */
    private $Connection;

    public function __construct()
    {
        $this->Connection = Connection::GetConnection();
    }

    /**
     * @param string $sql Comando sql a ser realizado
     * @param array $params Array associativo do parametro e o valor a ser referenciado no comando sql 
     */
    public function Exec($sql, $params = [])
    {
        $this->Query = $sql;
        $this->Params = $params;

        try {
            $this->Statement = $this->Connection->prepare($this->Query);
            foreach ($this->Params as $param => $value) {
                $this->Statement->bindValue($param, $value, empty($value) ? PDO::PARAM_NULL : (is_int($value) ? PDO::PARAM_INT : (is_bool($value) ? PDO::PARAM_BOOL : PDO::PARAM_STR)));
            }
            $this->Statement->execute();
            $this->Result = $this->Statement->fetchAll();
        } catch (Exception $e) {
            $this->Result = false;
            $this->Error = $e->getMessage();
        }
        return ($this);
    }

    public function GetError()
    {
        return $this->Error;
    }

    public function GetResult()
    {
        return $this->Result;
    }
}
