<?php
namespace ext;
use \PDO;
use \ext\Db;
abstract class Model extends Db
{
    public $pdo;
    public function __construct()
    {
        $this->dsn = TYPE.":dbname=".Dbname.";host=".Host.";charset=".Charset.";port=".Port;
        //实例化MYSQLI库
        $this->pdo = new PDO($this->dsn,User,Pass);
    }
    public function  deleteSql($tbname = null,$where=null){
        $sql = "DELETE FROM ".Prefix.$tbname." WHERE {$where}";
        return  $sql;
    }
    public function insertSql($tbname = null,array $data=[]){
       $strData = implode("','",$data);
       $sql = "INSERT INTO ".Prefix.$tbname." VALUES ('{$strData}')";
       return  $sql;
    }
    public function updateSql($tbname=null,array $data=[],$where=null){
        $strData = "";
        foreach ($data as $key=>$value){
            $strData .= $key."='".$value."',";
        }
        $sql = "UPDATE ".Prefix.$tbname." SET ".substr($strData,0,-1)." WHERE {$where} ";
        return  $sql;
    }
    public function  action($sql){
         if(stripos($sql,"SELECT") !==  false){
              $result = $this->pdo->query($sql);
              $data = $result->fetchAll($this->pdo::FETCH_ASSOC);
              return $data;
         }else{
              $bool = $this->pdo->exec($sql);
              return $bool;
         }
    }




}