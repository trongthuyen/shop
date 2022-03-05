<?php
// Phần của Hoàng
class home extends controller {

    private $Home;
    private $HomeBehavior;

    private $userToken;
    private $decodeJson;
    private $links;
    private $socialMedia;
    private $login;
    private $listProduct;
    private $listCategory;
    function __construct() {
        $this->Home = $this->model('homeModel');
        $this->HomeBehavior = $this->model('homeBehavior');
        $this->userToken = $this->Home->getUserToken();
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
            "productDetail" => DOMAIN."/home/productDetail/id=",
            "myorder" => DOMAIN."/info/myorder",
            "account" => DOMAIN."/info",
            "login" => DOMAIN."/login",
            "address" => "https://www.google.com/maps/place/Tr%C6%B0%E1%BB%9Dng+%C4%90%E1%BA%A1i+h%E1%BB%8Dc+B%C3%A1ch+khoa+-+%C4%90HQG+TP.HCM/@10.8796351,106.8024014,17.25z/data=!4m12!1m6!3m5!1s0x31752ec3c161a3fb:0xef77cd47a1cc691e!2zVHLGsOG7nW5nIMSQ4bqhaSBo4buNYyBCw6FjaCBraG9hIC0gxJDhuqFpIGjhu41jIFF14buRYyBnaWEgVFAuSENN!8m2!3d10.7733743!4d106.6606193!3m4!1s0x3174d8a5568c997f:0xdeac05f17a166e0c!8m2!3d10.8805585!4d106.8053863",
        ];
        $this->login = 'guest';
        $this->listCategory = $this->Home->getListCategory();
        $this->listProduct = $this->Home->getListProduct();

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
    // http://localhost/shop/(home)
    public function init() {
        // model

        // view
        $this->view('home', [
            "title" => "Website bán đồ công nghệ cao",
            "header" => "header_main",
            "footer" => "footer",
            "page" => "home_general",
            "login" => $this->login,
            "account" => $this->userToken,
            "listCategory" => $this->listCategory,
            "listProduct" => $this->listProduct,
            "links" => json_encode($this->links),
            "socialMedia" => json_encode($this->socialMedia),
        ]);
    }

    // Phần của Tín
    public function product($action = 'get', $page = '', $category_id = '') {
        if($page != '') {
            $page = str_replace('page=', '', $page) + 0;
        } else $page = 1;
        $offset = ($page - 1) * limit;
        $category = "";
        if($category_id != '') {
            $category_id = str_replace('category_id=', '', $category_id) + 0;
            $category = $this->Home->getListCategory($category_id);
        }
        $this->listProduct = $this->Home->getListProduct($offset, $category_id);
        $totalPage = $this->Home->getCountPage('product', $category_id);

        if($action == 'get') {
            $this->view('home', [
                "title" => "Danh sách sản phẩm",
                "header" => "header_main",
                "footer" => "footer",
                "page" => "home_product",
                "login" => $this->login,
                "account" => $this->userToken,
                "listCategory" => $this->listCategory,
                "category" =>$category,
                "listProduct" => $this->listProduct,
                "links" => json_encode($this->links),
                "socialMedia" => json_encode($this->socialMedia),
                "no_page" => $page,
                "total_page" => $totalPage,
                "index" => $offset + 1,
                "controller" => "/home/product",
            ]);
        }
    }

    public function productDetail($id, $action = '') {
        $id = str_replace('id=', '', $id) + 0;
        $product = $this->Home->getProduct($id);

        if($action == 'viewFeedback') {
            echo $this->Home->getListFeedback($id, true);
            die();
        } else if($action == 'viewFeedbackPart') {
            echo $this->Home->getListFeedback($id);
        } else {
            $listFeedback = $this->Home->getListFeedback($id);
        }

        $this->view('home', [
            "title" => "Chi tiết sản phẩm",
            "header" => "header_main",
            "page" => "productDetail",
            "footer" => "footer",
            "login" => $this->login,
            "account" => $this->userToken,
            "listCategory" => $this->listCategory,
            "listProduct" => $this->listProduct,
            "links" => json_encode($this->links),
            "socialMedia" => json_encode($this->socialMedia),
            "listProduct" => $this->listCategory,
            "product" => $product,
            "listFeedback" => $listFeedback,
        ]);
    }
    public function processOrder($product_id) {
        $product_id = str_replace('product_id=', '', $product_id) + 0;
        if(isset($_POST)) {
            $quantity = $this->get_POST('quantity');
            $phone_number = $this->get_POST('phone_number');
            $address = $this->get_POST('address');
            $note = $this->get_POST('note');
            $total_money = $this->get_POST('total_money');
            echo $this->HomeBehavior->processOrder($this->decodeJson["id"], $product_id, $quantity, $phone_number, $address, $note, $total_money);
            die();
        }
    }
    public function processFeedback($action, $product_id) {
        if($action == 'add') {
            $product_id = str_replace('product_id=', '', $product_id) + 0;
            if(isset($_POST)) {
                $content = $this->get_POST('content');
                echo $this->HomeBehavior->addFeedback($this->decodeJson["id"], $product_id, $content);
                die();
            }
        }
        else if($action == 'edit') {
            $id = str_replace('id=', '', $product_id) + 0;
            if(isset($_POST)) {
                $content = $this->get_POST('content');
                echo $this->HomeBehavior->editFeedback($id, $content);
                die();
            }
        }
        else if($action == 'delete') {
            $id = str_replace('id=', '', $product_id) + 0;
            echo $this->HomeBehavior->deleteFeedback($id);
            die();
        }
    }

    public function search($action = 'get', $page = '', $category_id = '') {
        $kw = '';
        if($category_id != '') {
            $category_id = str_replace('category_id=', '', $category_id) + 0;
        }
        if(isset($_POST["btn-search"])) {
            $kw = $this->get_POST('search-keyword');
            if($kw == '') {
                setcookie('keyword-1', $kw, time() - 1, '/');
                if($category_id != '') {
                    header("Location: ".DOMAIN."/home/product/get/page=1/category_id=".$category_id);
                } else {
                    header("Location: ".DOMAIN."/home/product/get/page=1");
                }
                die();
            }
            else setcookie('keyword-1', $kw, time() + 7*24*60*60, '/');
        }
        else if($_COOKIE["keyword-1"]) {
            $kw = $this->get_COOKIE('keyword-1');
        }
        $kw = '%'.$kw.'%';
        $kw = str_replace(' ', '%', $kw);
        if($page != '') {
            $page = str_replace('page=', '', $page) + 0;
        } else $page = 1;
        $offset = ($page - 1) * limit;
        $this->listProduct = json_decode($this->Home->getListData('product', $kw), true);
        $totalPage = ceil(count($this->listProduct) / limit);
        $this->listProduct = json_encode(array_slice($this->listProduct, $offset, limit));
        
        if($action == 'get') {
            if($category_id != '') {
                $category = $this->Home->getListCategory($category_id);
            } else {
                $category = "";
            }
            $this->view('home', [
                "title" => "Danh sách sản phẩm",
                "header" => "header_main",
                "footer" => "footer",
                "page" => "home_product",
                "login" => $this->login,
                "account" => $this->userToken,
                "listCategory" => $this->listCategory,
                "category" =>$category,
                "listProduct" => $this->listProduct,
                "links" => json_encode($this->links),
                "socialMedia" => json_encode($this->socialMedia),
                "no_page" => $page,
                "total_page" => $totalPage,
                "index" => $offset + 1,
                "controller" => "/home/search/",
            ]);
        }
    }
}

?>