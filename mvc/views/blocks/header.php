<?php
if(isset($data["links"])) {
  $links = json_decode($data["links"], true);
}
?>
<nav class="mynavbar bg-dark" id="mynavbar">
  <div class="nav-category padding-0-12 width-330px">

    <form action="<?=DOMAIN?>/admin/search/<?=$data["page"]?>/get/page=1" method="POST" class="search" id="search">
      <input class="search-item" id="search-keyword" name="search-keyword" type="search" placeholder="Search..." aria-label="Search">
      <button  class="btn btn-bg btn-search" id="btn-search" name="btnSearch" type="submit"><i class="fas fa-search searching-icon"></i></button>
    </form>

  </div>
  <label for="navSelect">
      <i class="fas fa-bars nav-item-icon" id="checkox-nav-select"></i>
    </label>
    <input type="checkbox" name="navSelect" id="navSelect">
  <ul class="nav-select" id="nav-admin">
    <li class="nav-option">
      <a href="<?=$links["home"]?>" class="nav-link">Trang chủ</a>
    </li>
    <li class="nav-option">
      <a href="<?=$links["product"]?>" class="nav-link">Sản phẩm</a>
    </li>
    <li class="nav-option">
      <a href="<?=$links["account"]?>" class="nav-link">Profile</a>
    </li>
    <li class="nav-option">
      <a href="<?=$links["logout"]?>" class="nav-link">Đăng xuất</a>
    </li>
  </ul>
</nav>