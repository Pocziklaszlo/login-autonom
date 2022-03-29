<?php

class Data {
    protected $pdo = null;

    public function __construct($pdo)
    { 
        $this->pdo = $pdo;  
    }

    public function getPdo(){
        return $this->pdo;
    }

    public function setPdo($pdo){
        $this->pdo = $pdo;
    }

    public function selectData($query,$data = []){
        $stmt = $this->pdo->prepare($query);
        $result = $stmt->execute($data);

        if($result != false){
            return $stmt->fetchAll();
        } else {
            return [];
        }
    }

    public function updateData($table,$data,$where,$limit = 1){
        $query = 'UPDATE ' . $table . ' SET ';
        $realData = [];

        foreach($data as $key =>$val){
            $dataKey = ':' . $key;
            $realData[$dataKey] = $val;

            $query .= $key . '=' . $dataKey . ',';
        }

        $query = rtrim($query,',') . ' WHERE ' . $where['string'] . ' LIMIT ' . $limit . ';';

        //Bejárja a tömböt,és a callbak az adott elemmel dolgozik
        array_walk($where['data'],function(&$item,$key){
            $item = ':' . $item;
        });

        // Két tömb egyesítése array_merge();
        $realData = array_merge($realData,$where['data']);

        $stmt= $this->pdo->prepare($query);
        return $stmt->execute($realData);
    }

    public function deleteData($table,$where,$limit = 1){
        $query = 'DELETE FROM ' . $table . ' WHERE ' . $where['string'] . ' LIMIT ' . $limit . ';';

        //Bejárja a tömböt,és a callbak az adott elemmel dolgozik
        array_walk($where['data'],function(&$item,$key){
            $item = ':' . $item;
        });

        $stmt= $this->pdo->prepare($query);
        return $stmt->execute($where['data']);
    }


}