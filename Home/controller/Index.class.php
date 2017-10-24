<?php
namespace Home\controller;
use \ext\Controller;
use \Home\model\Shop_user;

class Index extends Controller
{
    public $user;
    public function __construct()
    {
        //parent::__construct();
        $this->user = new Shop_user();
    }

    public function home(){

       $user = new Shop_user();
       $data['ArrData'] = $user->find("shop_logo");
       $ArrData2 = $user->find("shop_product AS P","PL.pc_id,P.title,PL.name,PL.pic,P.id","INNER JOIN shop_product_info AS PL ON P.id = PL.p_id WHERE P.id=3");
       $ArrData3 = $user->find("shop_product AS P","PL.pc_id,P.title,PL.name,PL.pic,P.id","INNER JOIN shop_product_info AS PL ON P.id = PL.p_id WHERE P.id=1");
       $data['ArrData2'] = [
           $ArrData2,
           $ArrData3
       ];
//       print_r();
       viewS("Home","Index","home",$data);
    }

    public function search(){

       $search = addslashes(trim($_POST['index_none_header_sysc']));
        $data['arrData'] = $this->user->find("shop_product_info","*","WHERE name like '%{$search}%'");
        viewS("Home","Index","search",$data);
    }
    public function sendSearch(){
        $search = $_POST['d'];
        $arrData = $this->user->find("shop_product_info","*","WHERE name like '%{$search}%'");
        echo json_encode($arrData);
    }

    public function introduction(){
        $user = new Shop_user();
        $data['arrData'] = $user->find("shop_product_info AS PL","*","INNER JOIN shop_product_content AS PC ON PL.pc_id = PC.pl_id WHERE PL.pc_id = {$_GET['id']}");

        viewS("Home","Index","introduction",$data);
    }

    public function login(){
        if(!empty($_POST)){
           $tel = addslashes($_POST['tel']);
           $password = md5($_POST['password']);
           $user = new Shop_user();
           $sql = "SELECT * FROM shop_user WHERE username= :user AND userpass= :pass ";
           $stmt = $user->pdo->prepare($sql);
           $stmt->execute([':user'=>$tel,':pass'=>$password]);
           $data = $stmt->fetchAll();
           if(!empty($data)){
               setcookie("tel",$tel,time()+3600);
               $this->success("登录成功",BASE_URL."/Home/Index/home");
           }else{
               $this->error("登录失败");
           }
        }else{
            viewS("Home","Index","login");
        }
    }

    public function loginout(){
        setcookie("tel","",time()-1);
        $this->success("退出成功",BASE_URL."/Home/Index/home");
    }

    public function register(){
         if(!empty($_POST)){
             //攻击  XSS  SQL  CSRF（POST攻击）  DDOS(哈希碰撞)
             $tel = addslashes($_POST['tel']);
             $password = md5($_POST['password']);
             $user = new Shop_user();
             $sql = "INSERT INTO shop_user VALUES(null,'{$tel}','{$password}')";
             $date = $user->pdo->exec($sql);
             if($date){
                 $this->success("注册成功",BASE_URL."/Home/Index/login");
             }else{
                 $this->error("注册失败");
             }
         }else{
             viewS("Home","Index","register");
         }
    }
}