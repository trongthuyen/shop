<?php

class admin extends controller {
    
    private $Admin;
    private $User;
    private $Category;
    private $Product;
    private $Feedback;
    private $Order;

    private $links;

    public function __construct() {

        $this->Admin = $this->model('adminModel');
        $this->User = $this->model('user');
        $this->Category = $this->model('category');
        $this->Product = $this->model('product');
        $this->Feedback = $this->model('feedback');
        $this->Order = $this->model('order');

        $userToken = json_decode($this->User->getUserToken(), true);

        if($userToken == null) {
            header('Location: '.DOMAIN.'/login');
        } else if($userToken["role_id"] == 3) {
            header('Location: '.DOMAIN);
        }
        $this->links = [
            "home" => DOMAIN,
            "admin" => DOMAIN."/admin",
            "adminCategory" => DOMAIN."/admin/category",
            "adminProduct" => DOMAIN."/admin/product",
            "adminOrder" => DOMAIN."/admin/order",
            "adminFeedback" => DOMAIN."/admin/feedback",
            "adminUser" => DOMAIN."/admin/user",
            "product" => DOMAIN."/home/product/get/page=1",
            "productDetail" => DOMAIN."/home/productDetail/id=",
            "myorder" => DOMAIN."/info/myorder",
            "account" => DOMAIN."/info",
            "logout" => DOMAIN."/login",
            "address" => "https://www.google.com/maps/place/Tr%C6%B0%E1%BB%9Dng+%C4%90%E1%BA%A1i+h%E1%BB%8Dc+B%C3%A1ch+khoa+-+%C4%90HQG+TP.HCM/@10.8796351,106.8024014,17.25z/data=!4m12!1m6!3m5!1s0x31752ec3c161a3fb:0xef77cd47a1cc691e!2zVHLGsOG7nW5nIMSQ4bqhaSBo4buNYyBCw6FjaCBraG9hIC0gxJDhuqFpIGjhu41jIFF14buRYyBnaWEgVFAuSENN!8m2!3d10.7733743!4d106.6606193!3m4!1s0x3174d8a5568c997f:0xdeac05f17a166e0c!8m2!3d10.8805585!4d106.8053863",
        ];
    }
    
    // http://localhost/shop/(home)
    public function init() {
        // model

        // view
        $this->view('admin', [
            "title" => "Dashboard",
            "header" => "header",
            "sidebar" => "sidebar",
            "footer" => "footer",
            "page" => "dashboard",
            "dashboard" => "active",
            "links" => json_encode($this->links),
            "controller" => "/admin/user",
        ]);
    }

    // http://localhost/shop/admin/user
    public function user($action = '', $id = '') {
        
        $title = "Quản lý tài khoản người dùng";
        $header = "header";
        $sidebar = "sidebar";
        $page = "user";
        $listUser = "";
        $userInfo = "";
        $cur_page = 1;
        $offset = 0;
        $totalPage = $this->Admin->getCountPage('user');
        if($action == 'get') {
            if($id != '') {
                $cur_page = str_replace('page=','', $id) + 0;
                $cur_page = $cur_page == 0 ? 1 : $cur_page;
            }
            $offset = ($cur_page - 1) * limit;
        }
        else if($action == 'getAjax') {
            $cur_page = str_replace('page=', '', $id) + 0;
            $offset = ($cur_page - 1) * limit;
            echo $this->Admin->getListUser($offset);
            die();
        }
        // hien thi danh sach tai khoan

        // them nguoi dung
        else if($action == 'add') {
            $title = "Thêm tài khoản";
            $page = "addUser";
        }
        else if($action == 'edit') {
            $id = str_replace('id=', '', $id) + 0;
            $userInfo = $this->Admin->getListUser(0, $id);
            $title = "Sửa thông tin tài khoản";
            $page = "editUser";
        }
        else if($action == 'del') {
            $id = str_replace('id=', '', $id) + 0;
            $this->processUser($action, $id);
        }
        $listUser = $this->Admin->getListUser($offset);
        $this->view('admin', [
            "title" => $title,
            "header" => $header,
            "sidebar" => $sidebar,
            "footer" => "footer",
            "page" => $page,
            "links" => json_encode($this->links),
            "listUser" => $listUser,
            "userInfo" => $userInfo,
            "user" => "active",
            "no_page" => $cur_page,
            "total_page" => $totalPage,
            "index" => $offset + 1,
            "controller" => "/admin/user",
        ]);
    }

    // xu ly them/sua tai khoan
    public function processUser($action,  $id = null) {
        
        if($id != null) {
            $id = str_replace('id=', '', $id) + 0;
        }
        
        $title = "Quản lý tài khoản người dùng";
        $header = "header";
        $sidebar = "sidebar";
        $page = "user";
        $listUser = "";
        $userInfo = "";
        $toast = [];
        $msg = "";
        // them tai khoan
        if($action == 'add') {
            if(isset($_POST)) {
                $name = $this->get_POST('name');
                $email = $this->get_POST('email');
                $pwd = $this->get_POST('pwd');
                $phone = $this->get_POST('phone_num');
                $addr = $this->get_POST('addr');
                $role = $this->get_POST('role');
    
                // insert into database user
                $result = $this->User->addUser($name, $email, $pwd, $phone, $addr, $role);

                // show Success/Fail
                if($result == "true"){
                    header("Location: ".DOMAIN."/admin/user");
                }
                else if($result == "false") {
                    $title = 'Thêm tài khoản';
                    $page = 'addUser';
                    $msg = 'Thông tin chưa phù hợp hoặc email đã được đăng ký, vui lòng kiểm tra lại!';
                    $toast = [
                        "type" => 'toast-error',
                        "icon" => 'fas fa-times',
                        "heading" => 'Thất bại',
                        "msg" => 'Email đã được đăng ký!',
                    ];
                }
            }
        }
        // sua tai khoan
        else if($action == 'edit') {
            if(isset($_POST)) {
                $name = $this->get_POST('name');
                $email = $this->get_POST('email');
                $pwd = $this->get_POST('pwd');
                $phone = $this->get_POST('phone_num');
                $addr = $this->get_POST('addr');
                $role = $this->get_POST('role');
    
                // insert into database user
                $result = $this->User->updateUser($id, $name, $email, $pwd, $phone, $addr, $role);

                // show Success/Fail
                if($result == "true"){
                    header("Location: ".DOMAIN."/admin/user");
                }
                else if($result == "false") {
                    $userInfo = $this->Admin->getListUser($id);
                    $title = 'Sửa thông tin tài khoản';
                    $page = 'editUser';
                    $msg = 'Thông tin chưa phù hợp, vui lòng kiểm tra lại!';
                    $toast = [
                        "type" => 'toast-error',
                        "icon" => 'fas fa-times',
                        "heading" => 'Thất bại',
                        "msg" => 'Cập nhật thất bại!',
                    ];
                }
            }
        }
        // xoa tai khoan
        else {
            $this->Feedback->deleteFeedback('user', $id);
            $this->Order->deleteOrder('user', $id);
            echo $this->User->deleteUser($id, true);
            die();
        }

        // lay lai danh sach user
        $listUser = $this->Admin->getListUser();

        $this->view('admin', [
            "title" => $title,
            "header" => $header,
            "sidebar" => $sidebar,
            "footer" => "footer",
            "page" => $page,
            "links" => json_encode($this->links),
            "msg" => $msg,
            "user" => "active",
            "listUser" => $listUser,
            "userInfo" => $userInfo,
            "toast" => $toast,
        ]);
    }

    // http://localhost/shop/admin/category
    public function category($action = '', $page = null) {
        $offset = 0;
        $totalPage = $this->Admin->getCountPage('category', false);

        if($page != null) {
            $page = str_replace('page=','',$page) + 0;
                $page = $page == 0 ? 1 : $page;
            } else $page = 1;
        $page = str_replace('page=','',$page) + 0;
        $offset = ($page - 1) * limit;
        $listCate = $this->Admin->getListCategory($offset);
        if($action == 'get' || $action == '') {
            if($page != null) {
                $this->view('admin', [
                    "title" => "Quản lý danh mục sản phẩm",
                    "header" => "header",
                    "sidebar" => "sidebar",
                    "footer" => "footer",
                    "page" =>"category",
                    "listCate" => $listCate,
                    "category" => "active",
                    "no_page" => $page,
                    "links" => json_encode($this->links),
                    "total_page" => $totalPage,
                    "index" => $offset + 1,
                    "controller" => "/admin/category",
                ]);
                die();
            }
        }
        else if($action == 'getAjax') {
            echo $listCate;
            die();
        }
    }

    public function processCategory($action, $id = null) {
        if($id != null) {
            $id = str_replace('id=', '', $id) + 0;
        }
        if(isset($_POST)) {
            $name = $this->get_POST('name');
        }
        if($action == 'add') {
            echo $this->Category->addCategory($name);
            die();
        }
        else if($action == 'edit') {
            echo $this->Category->updateCategory($id, $name);
            die();
        }
        else if($action == 'del') {
            $this->Product->deleteProductOfCategoryId($id);
            echo $this->Category->deleteCategory($id);
            die();
        }
    }

    // http://localhost/shop/admin/product
    public function product($action = '', $id = '') {

        $listCategory = $this->Admin->getListCategory();
        $totalPage = $this->Admin->getCountPage('product');
        
        $offset = 0;
        if($action == 'get') {
            if($id != '') {
                $id = str_replace('page=', '', $id) + 0;
                $id = $id == 0 ? 1 : $id;
                $offset = ($id - 1) * limit;
                
                $listProduct = $this->Admin->getListProduct($offset);
                

                $this->view('admin', [
                    "title" => "Quản lý sản phẩm",
                    "header" => "header",
                    "sidebar" =>"sidebar",
                    "footer" => "footer",
                    "page" => "product",
                    "listProduct" => $listProduct,
                    "listCategory" => $listCategory,
                    "product" => "active",
                    "links" => json_encode($this->links),
                    "no_page" => $id,
                    "total_page" => $totalPage,
                    "index" => $offset + 1,
                    "controller" => "/admin/product",
                ]);
            }
            else {
            }
            die();
        }
        else if($action == 'getAjax') {
            $id = str_replace('page=', '', $id) + 0;
            $offset = ($id - 1) * limit;
            echo $this->Admin->getListProduct($offset);
            die();
        }
        else {
            $title = "Quản lý sản phẩm";
            $header = "header";
            $sidebar = "sidebar";
            $page = "product";
            $listProduct = "";
            $productInfo = "";
            $listCategory = "";
            // hien thi danh sach tai khoan
    
            // them nguoi dung
            if($action == 'add') {
                $title = "Thêm sản phẩm";
                $page = "addProduct";
                $listCategory = $this->Admin->getListCategory();
            }
            else if($action == 'edit') {
                $id = str_replace('id=', '', $id) + 0;
                $productInfo = $this->Admin->getListProduct(0, $id);
                $listCategory = $this->Admin->getListCategory();
                $title = "Sửa thông tin sản phẩm";
                $page = "editProduct";
            }
            else if($action == 'del') {
                $id = str_replace('id=', '', $id) + 0;
                $this->processProduct($action, $id);
            }
            $listProduct = $this->Admin->getListProduct();
            $this->view('admin', [
                "title" => $title,
                "header" => $header,
                "sidebar" => $sidebar,
                "footer" => "footer",
                "page" => $page,
                "listProduct" => $listProduct,
                "productInfo" => $productInfo,
                "listCategory" => $listCategory,
                "product" => "active",
                "links" => json_encode($this->links),
                "no_page" => 1,
                "total_page" => $totalPage,
                "index" => 1,
                "controller" => "/admin/product",
            ]);
        }
    }

    // xu ly them/sua tai khoan
    public function processProduct($action,  $id = null) {
        if($id != null) {
            $id = str_replace('id=', '', $id) + 0;
        }
        $title = "Quản lý sản phẩm";
        $header = "header";
        $sidebar = "sidebar";
        $page = "product";
        $listProduct = "";
        $listCategory = "";
        $productInfo = "";
        $toast = [];
        $msg = "";
        // them tai khoan
        if($action == 'add') {
            if(isset($_POST)) {
                $titProduct = $this->get_POST('title');
                $category = $this->get_POST('category');
                $price = $this->get_POST('price');
                $discount = $this->get_POST('discount');
                $describe = $this->get_POST('describe');
                
                $category_name = $this->Admin->getListCategory($category);
                $category_name = json_decode($category_name, true);
                $folder = $this->getScurityMD5($category_name[0]["name"]);

                if(!file_exists(DOMAIN.'/mvc/views/assets/thumbnail/product/'.$folder)) {
                    mkdir('./mvc/views/assets/thumbnail/product/'.$folder);
                }
                $thumbnail = $this->moveFile('thumbnail', 'product/'.$folder.'/');

                // insert into database product
                $result = $this->Product->addProduct($titProduct, $category, $price, $discount, $thumbnail, $describe);

                // show Success/Fail
                if($result == "true"){
                    header('Location: '.DOMAIN.'/admin/product/get/page=1');
                    die();
                }
                else if($result == "false") {
                    $title = 'Thêm sản phẩm';
                    $page = 'addProduct';
                    $listCategory = $this->Admin->getListCategory();
                    $msg = 'Thông tin chưa phù hợp, vui lòng kiểm tra lại!';
                    $toast = [
                        "type" => 'toast-error',
                        "icon" => 'fas fa-times',
                        "heading" => 'Thất bại',
                        "msg" => 'Xem lại thông tin nội dung!',
                    ];
                }
            }
        }
        // sua tai khoan
        else if($action == 'edit') {
            if(isset($_POST)) {
                $titProduct = $this->get_POST('title');
                $category = $this->get_POST('category');
                $price = $this->get_POST('price');
                $discount = $this->get_POST('discount');
                $describe = $this->get_POST('describe');
                
                $category_name = $this->Admin->getListCategory($category);
                $category_name = json_decode($category_name, true);
                $folder = $this->getScurityMD5($category_name["name"]);
                
                if(!file_exists(DOMAIN.'/mvc/views/assets/thumbnail/product/'.$folder)) {
                    mkdir('./mvc/views/assets/thumbnail/product/'.$folder);
                }
                $thumbnail = $this->moveFile('thumbnail', 'product/'.$folder.'/');

                // insert into database product
                $result = $this->Product->updateProduct($id, $titProduct, $category, $price, $discount, $thumbnail, $describe);

                // show Success/Fail
                if($result == "true"){
                    header('Location: '.DOMAIN.'/admin/product/get/page=1');
                    die();
                }
                else if($result == "false") {
                    $productInfo = $this->Admin->getListProduct(0, $id);
                    $title = 'Sửa thông tin sản phẩm';
                    $page = 'editProduct';
                    $msg = 'Thông tin chưa phù hợp, vui lòng kiểm tra lại!';
                    $toast = [
                        "type" => 'toast-error',
                        "icon" => 'fas fa-times',
                        "heading" => 'Thất bại',
                        "msg" => 'Cập nhật thất bại!',
                    ];
                }
            }
        }
        // xoa sản phẩm
        else {
            $this->Feedback->deleteFeedback('product', $id);
            $this->Order->deleteOrder('product', $id);
            echo $this->Product->deleteProduct($id, true);
            die();
        }

        // lay lai danh sach product
        $listProduct = $this->Admin->getListProduct();

        $this->view('admin', [
            "title" => $title,
            "header" => $header,
            "sidebar" => $sidebar,
            "footer" => "footer",
            "page" => $page,
            "msg" => $msg,
            "product" => "active",
            "links" => json_encode($this->links),
            "listProduct" => $listProduct,
            "listCategory" => $listCategory,
            "productInfo" => $productInfo,
            "toast" => $toast,
        ]);
    }

    // http://localhost/shop/admin/feedback
    public function feedback($action = '', $page = '') {
        if($page != '') {
            $page = str_replace('page=', '', $page) + 0;
            $page = $page == 0? 1 : $page;
        } else $page = 1;
        $offset = ($page - 1) * limit;
        $listFeedback = $this->Admin->getListFeedback($offset);
        $totalPage = $this->Admin->getCountPage('feedback');
        if($action == 'getAjax') {
            echo $listFeedback;
            die();
        }
        $this->view('admin', [
            "title" => "Quản lý phản hồi",
            "header" => "header",
            "sidebar" => "sidebar",
            "footer" => "footer",
            "page" => "feedback",
            "listFeedback" => $listFeedback,
            "feedback" => "active",
            "no_page" => $page,
            "links" => json_encode($this->links),
            "total_page" => $totalPage,
            "index" => $offset + 1,
            "controller" => "/admin/feedback",
        ]);
    }
    
    public function processFeedback($action, $id) {
        $id = str_replace('id=', '', $id) + 0;
        if(isset($_POST)) {
            $value = $this->get_POST('value');
            $result = "false";
            $result = $this->Feedback->processFeedback($action, $id, $value);
            echo $result;
        }
    }

    // http://localhost/shop/admin/order
    public function order($action = '', $page = '') {
        if($page != '') {
            $page = str_replace('page=', '', $page) + 0;
            $page = $page == 0? 1 : $page;
        } else $page = 1;
        $offset = ($page - 1) * limit;
        $listOrder = $this->Admin->getListOrder($offset);
        $totalPage = $this->Admin->getCountPage('orders');
        
        if($action == 'getAjax') {
            echo $listOrder;
            die();
        }

        $this->view('admin', [
            "title" => "Quản lý đơn hàng",
            "header" => "header",
            "sidebar" => "sidebar",
            "footer" => "footer",
            "page" => "order",
            "order" => "active",
            "listOrder" => $listOrder,
            "no_page" => $page,
            "links" => json_encode($this->links),
            "total_page" => $totalPage,
            "index" => $offset + 1,
            "controller" => "/admin/order",
        ]);
    }

    public function processOrder($id = null) {
        if($id != null) {
            $id = str_replace('id=', '', $id) + 0;
        }

        if(isset($_POST)) {
            $value = $this->get_POST('value') + 0;
            echo $this->Order->processOrder($id, $value);
        }
    }

    public function search($pageName, $action = 'get', $page = '') {
        $kw = '';
        if(isset($_POST["btnSearch"])) {
            $kw = $this->get_POST('search-keyword');
            if($kw == '') {
                setcookie('keyword', $kw, time() - 1, '/');
                header("Location: ".DOMAIN."/admin/".$pageName."/get/page=1");
                die();
            }
            else setcookie('keyword', $kw, time() + 7*24*60*60, '/');
        }
        else if($_COOKIE["keyword"]) {
            $kw = $this->get_COOKIE('keyword');
        }

        $kw = '%'.$kw.'%';
        $kw = str_replace(' ', '%', $kw);
        $title = '';
        $table = '';
        $nameList = '';
        $active = '';
        switch ($pageName) {
            case 'user':
                $table = 'user';
                $nameList = 'listUser';
                $title = "Quản lý người dùng";
                $active = 'user';
                break;
            case 'feedback':
                $table = 'feedback';
                $nameList = 'listFeedback';
                $title = "Quản lý phản hồi";
                $active = 'feedback';
                break;
            case 'order':
                $table = 'orders';
                $nameList = 'listOrder';
                $title = "Quản lý đơn hàng";
                $active = 'order';
                break;
            case 'category':
                $table = 'category';
                $nameList = 'listCate';
                $title = "Quản lý danh mục sản phẩm";
                $active = 'category';
                break;
            default:
                $table = 'product';
                $nameList = 'listProduct';
                $title = "Quản lý sản phẩm";
                $active = 'product';
        }

        if($page != '') {
            $page = str_replace('page=', '', $page) + 0;
            $page = $page == 0? 1 : $page;
        } else $page = 1;
        $offset = ($page - 1) * limit;
        $listData = json_decode($this->Admin->getListData($table, $kw), true);
        $totalPage = ceil(count($listData) / limit);
        $listData = json_encode(array_slice($listData, $offset, limit));
        $this->view('admin', [
            "title" => $title,
            "header" => "header",
            "sidebar" => "sidebar",
            "footer" => "footer",
            "page" => $pageName,
            $active => "active",
            $nameList => $listData,
            "no_page" => $page,
            "links" => json_encode($this->links),
            "total_page" => $totalPage,
            "index" => $offset + 1,
            "controller" => "/admin/search/".$pageName,
        ]);
    }
}

?>