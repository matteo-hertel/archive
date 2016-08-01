<?php
namespace Db;

class User{

    protected $connection;

    public function __construct(){
        $this->setConnection();
    }

    private function setConnection(){
        $this->connection = Connection::getConnection();
    }

    public function loadAll(){
        $q = $this->connection->prepare("SELECT * FROM user");
        $q->execute();

        if(!$q->rowCount()){
            return array();
        }

        return $q->fetchall();
    }
    public function findbyId($id){
        if(empty($id)){
            return array();
        }
        $q = $this->connection->prepare("SELECT * FROM user WHERE user_id = :id");
        $q->bindvalue(":id", $id);
        $q->execute();

        if(!$q->rowCount()){
            return array();
        }

        return $q->fetch();
    }

}
