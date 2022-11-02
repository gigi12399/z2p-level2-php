<?php 

    require "query/Dbconnect.php";

    class Queries extends Dbconnect{
        public function __construct(){
            parent::__construct();
        }

        public function select($table,$row="*", $join=null, $where=null, $order=null, $limit=null){
            $sql = "SELECT $row FROM $table";
            if($join != null){
                $sql .= " JOIN $join";
            }
            if($where != null){
                $sql .= " WHERE $where";
            }
            if($order != null){
                $sql .= " ORDER BY $order";
            }
            if($limit != null){
                $sql .= " LIMIT $limit";
            }
            $stmt = $this->pdo->prepare($sql); // delivered sql
            $stmt->execute(); // to work with data
            $result = $stmt->fetchAll(); // fetchAll -> to get data as a array
            return $result;
        }

        public function store($table, $data = []){
            $table_columns = implode(',', array_keys($data));
            //echo $table_columns;
            $sql = "INSERT INTO $table($table_columns) VALUES(:".implode(', :', array_keys($data)).")";
            //echo $sql;
            $stmt = $this->pdo->prepare($sql);
            foreach ($data as $key=> &$d) {
                //echo $key;
                //echo $d;
                $stmt->bindParam(":$key", $d, PDO::PARAM_STR);
            };
            $stmt->execute();
        }

    }

?>