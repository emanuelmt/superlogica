<?php

class Insert
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
     * @param array $params Array associativo da coluna da tabela e o valor a ser associado no comando sql 
     */
    public function Exec($table, $params = [])
    {
        $this->Params = $params;
        $sqlColumns = implode(",",array_keys($this->Params));
        $sqlValues = ":" . implode(", :",array_keys($this->Params));
        $sql = "INSERT INTO $table ($sqlColumns) VALUES ($sqlValues)";
        $this->Query = $sql;

        try {
            $this->Statement = $this->Connection->prepare($this->Query);
            foreach ($this->Params as $param => $value) {
                $this->Statement->bindValue(":" . $param, $value, empty($value) ? PDO::PARAM_NULL : (is_int($value) ? PDO::PARAM_INT : (is_bool($value) ? PDO::PARAM_BOOL : PDO::PARAM_STR)));
            }
            $this->Statement->execute();
            $this->Result = true;
        } catch (Exception $e) {
            $this->Result = false;
            $this->Error = $e->getMessage();
        }
        return $this;
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
