<?php
namespace Admin\controller;
use Admin\model\User_model;
use \ext\Controller;
use \ext\Image;
use \ext\Page;
use Home\model\Shop_user;

class Index extends Controller
{
    public function index(){
        viewS("Admin","Index","index");
    }
    public function prd(){
        $db = new User_model();
        $sql = $db
            ->select("count(*) as total")
            ->from("shop_product_info AS PL")
            ->join("product AS P","PL.p_id = P.id")
            ->getSql();
        $total = $db->action($sql);


        $page = new Page();



        $page->init($total[0]['total'],6);


        $db->delSql();

        $sqlPage = $db
            ->select("PL.id,PL.name,PL.pic,PL.price,P.title")
            ->from("shop_product_info AS PL")
            ->join("product AS P","PL.p_id = P.id")
            ->limit($page->start,6)
            ->getSql();
        $data['arrData'] = $db->action($sqlPage);
        $data['show'] = $page->show();
        viewS("Admin","Menu","index",$data);
    }
    public function menu_del(){
        $id = $_GET['id'];
        $page = $_GET['page'];
        $db = new User_model();
        $sql = $db->deleteSql("product_info","id={$id}");
        $bool = $db->action($sql);
        if($bool){
            $this->success("删除成功",BASE_URL."/Admin/Index/prd?page={$page}");
        }else{
            $this->error("删除失败");
        }
//        1、两次sql
//        2、触发器
//        3、外键
//        4、存储过程
    }
    public function login(){
        viewS("Admin","Index","login");
    }
    public function piebase(){
        viewS("Admin","Highcharts6","examples/pie-basic/index");
    }
    public function pie(){
        $db = new Shop_user();
        $sql = $db->select("name,price AS y")->from("shop_product_info")->getSql();
        $data = $db->action($sql);

        foreach ($data as $k=>$v){
            $data[$k]['y'] = (int)$v['y'];
        }
        echo json_encode($data);
    }
    public function code(){

       $img = new Image();
       header("content-type:image/png");
       $img::code(230,50);
    }
}