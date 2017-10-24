<?php
/**
 * Created by PhpStorm.
 * User: redstart
 * Date: 2017/10/9
 * Time: 11:39
 */
namespace Home\model;
use \ext\Model;

class Shop_user extends Model
{

    public function find($table,$from = "*",$where=null){
        if(is_null($where)){
            $sql = "SELECT {$from} FROM {$table}";
        }else{
            $sql = "SELECT {$from} FROM {$table} {$where}" ;
        }
//        echo $sql;
//        exit;
        $result = $this->pdo->query($sql);
        $data = $result->fetchAll($this->pdo::FETCH_ASSOC);
        return $data;
    }

}