<?php

class info extends controller {

    // Model
    private $Home;
    private $InfoModel;
    private $InfoBehavior;

    // User info
    private $userToken;
    private $decodeJson;
    
    private $links;
    private $socialMedia;
    private $login;
    private $listCategory;
    function __construct() {
        $this->Home = $this->model('homeModel');
        $this->InfoModel = $this->model('infoModel');
        $this->InfoBehavior = $this->model('infoBehavior');
        $this->userToken = $this->InfoBehavior->getUserToken();
        if($this->userToken == "null") {
            header('Location: '.DOMAIN.'/login');
        }
        $this->decodeJson = json_decode($this->userToken, true);
        $this->socialMedia = [
            "facebook" => "https://www.facebook.com/than.the.169",
            "instagram" => "https://www.instagram.com/trong_thuyen/",
            "twitter" => "#",
        ];
        $this->links = [
            "home" => DOMAIN,
            "admin" => DOMAIN."/admin",
            "product" => DOMAIN."/home/product/get/page=1",
            "myorder" => DOMAIN."/info/myorder",
            "account" => DOMAIN."/info",
            "login" => DOMAIN."/login",
            "address" => "https://www.google.com/maps/place/Tr%C6%B0%E1%BB%9Dng+%C4%90%E1%BA%A1i+h%E1%BB%8Dc+B%C3%A1ch+khoa+-+%C4%90HQG+TP.HCM/@10.8796351,106.8024014,17.25z/data=!4m12!1m6!3m5!1s0x31752ec3c161a3fb:0xef77cd47a1cc691e!2zVHLGsOG7nW5nIMSQ4bqhaSBo4buNYyBCw6FjaCBraG9hIC0gxJDhuqFpIGjhu41jIFF14buRYyBnaWEgVFAuSENN!8m2!3d10.7733743!4d106.6606193!3m4!1s0x3174d8a5568c997f:0xdeac05f17a166e0c!8m2!3d10.8805585!4d106.8053863",
        ];
        $this->login = 'guest';
        $this->listCategory = $this->Home->getListCategory();

        if($this->userToken == "null") {

        }
        else {
            $role = $this->Home->getListRole($this->decodeJson["role_id"]);
            if(json_decode($role, true)["name"] == 'Admin') {
                $this->login = 'admin';
            } else {
                $this->login = 'user';
            }
        }
    }

    public function init() {
        header('Location: '.DOMAIN.'/info/general');
        die();
    }

    public function general() {
        $this->view('info',[
            "title" => "Thông tin tài khoản",
            "header" => "header_main",
            "sidebar" => "sidebar_info",
            "footer" => "footer",
            "page" => "info_general",
            "login" => $this->login,
            "account" => $this->userToken,
            "listCategory" => $this->listCategory,
            "links" => json_encode($this->links),
            "socialMedia" => json_encode($this->socialMedia),
            "userInfo" => $this->userToken,
            "listRole" => $this->InfoModel->getListRole(),
            "general" => "active",
        ]);
    }

    public function updateInfo() {
        if(isset($_POST)) {
            $fullname = $this->get_POST('fullname');
            $email = $this->get_POST('email');
            $phone_num = $this->get_POST('phone_num');
            $addr = $this->get_POST('addr');
            $oldpwd = $this->get_POST('old-pwd');
            $pwd = $this->get_POST('pwd');
            $pwdToken = $this->decodeJson["pwd"];
            if($oldpwd != '' && !password_verify($oldpwd, $pwdToken)) {
                echo "false";
            }
            // update token
            // update info
            $result = $this->InfoBehavior->updateInfo($this->decodeJson["id"], $fullname, $email, $pwd, $phone_num, $addr, $this->decodeJson["role_id"]);

            if($result == "true") {
                if($this->userToken = $this->InfoBehavior->updateUserToken($this->decodeJson['id'], $email) != "null") {
                    $this->userToken = $this->InfoBehavior->getUserToken();
                    $this->decodeJson = json_decode($this->userToken, true);
                }
            }
            echo $result;
            die();
        }
    }

    public function logout() {
        echo $this->InfoBehavior->clearUserToken();
    }

    public function delAccount() {

        // Xóa cart, order, feedback của user trước

        // Xóa tài khoản
        $this->InfoBehavior->clearUserToken();
        echo $this->InfoBehavior->deleteUser(json_decode($this->userToken, true)["id"] + 0, true);
    }

    // Phần của Huy
    public function myorder($order_id = null) {
        if($order_id != null) {
            $order_id = str_replace('order_id=', '', $order_id) + 0;
            echo $this->InfoModel->getListOrder($this->decodeJson["id"], $order_id);
            die();    
        }
        $listOrder = $this->InfoModel->getListOrder($this->decodeJson["id"]);

        $this->view('info', [
            "title" => "Giỏ hàng của tôi",
            "header" => "header_main",
            "sidebar" => "sidebar_info",
            "footer" => "footer",
            "page" => "info_myorder",
            "listOrder" => $listOrder,
            "login" => $this->login,
            "account" => $this->userToken,
            "listCategory" => $this->listCategory,
            "links" => json_encode($this->links),
            "socialMedia" => json_encode($this->socialMedia),
            "userInfo" => $this->userToken,
            "listRole" => $this->InfoModel->getListRole(),
            "myorder" => "active",
        ]);
    }
    public function processMyOrder($action, $id) {
        if($action == 'cancel') {
            $id = str_replace('id=', '', $id) + 0;
            echo $this->InfoBehavior->cancelOrder($id);
        }
    }



}

?>