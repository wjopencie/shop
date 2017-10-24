<?php
/**
 * Created by PhpStorm.
 * User: redstart
 * Date: 2017/10/12
 * Time: 11:20
 */
namespace Home\controller;

use \ext\Controller;
use ext\Db;
use \Home\model\Shop_user;

class Data extends Controller
{
     public function index(){
        $db = new Shop_user();
//        $sql = $db->select()->from("user")->getSql();
//        $data = $db->action($sql);
//        dump($data);
//         $sql = $db->deleteSql("user","username='小明3'");
//         $data = $db->action($sql);
//         dump($data);
//        exit;

         $sql = $db->updateSql("user",['username'=>"小米","userpass"=>md5(123456)],"id=14");
         $data = $db->action($sql);
         dump($data);

     }


}