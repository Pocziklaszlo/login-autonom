<?php

class PdoHandler {

    protected $pdo = null;
    protected $config = [];

    public function __construct($config)
    {
        $this->config = $config;
    }

    public function createPdoInstance(){
        if($this->pdo == null){

            $dsn = "mysql:host={$this->config['host']};dbname={$this->config['db']};charset={$this->config['charset']}";

            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false
            ];

            try {
                $this->pdo = new PDO($dsn, $this->config['user'], $this->config['password'], $options);
           } catch (\PDOException $e) {
                throw new \PDOException($e->getMessage(), (int)$e->getCode());
           }
        }

        return $this->pdo;
    }

}