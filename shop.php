<?php

require __DIR__ . "/__connect_db.php";

$where = "WHERE cat2 = '聯名合作'";
if (isset($_GET['price']) && $_GET['price']) {
    $where = " WHERE price <= '".$_GET['price']."'";
}
if (isset($_GET['cat1']) && $_GET['cat1']) {
    $where = " WHERE cat1 = '".$_GET['cat1']."'";
}
if (isset($_GET['cat2']) && $_GET['cat2']) {
    $where = " WHERE cat2 = '".$_GET['cat2']."'";
}
if (isset($_GET['keyword']) && $_GET['keyword']) {
    $where = " WHERE title2 like '%".$_GET['keyword']."%'";
}

$orderby = "ORDER BY hot DESC";

if (isset($_GET['o']) && $_GET['o'] == 'price') {
    $orderby = "ORDER BY ".$_GET['o']." ASC";
} else if (isset($_GET['o']) && $_GET['o']) {
    $orderby = "ORDER BY ".$_GET['o']." DESC";
}

$shop_order = isset($_GET['o'])?$_GET['o']:"";
$cat1 = isset($_GET['cat1'])?$_GET['cat1']:"";
$cat2 = isset($_GET['cat2'])?$_GET['cat2']:"";


//分頁算法
$page = (isset($_GET['page']) && $_GET['page'])?$_GET['page']:1;

//當前頁數
$per_page = 6; //一頁幾筆
$sql = "SELECT COUNT(0) FROM shops {$where} ";
$total = $pdo->query($sql)->fetch(PDO::FETCH_NUM)[0]; //總筆數
$total_pages = ceil($total / $per_page); //總頁數


//如果筆數非大於0則頁數為1
if($total_pages > 0) {
    $page = ($page > $total_pages)?$total_pages:$page;
} else {
    $page = 1;
}
$limit = sprintf("LIMIT %s, %s", ($page - 1)*$per_page, $per_page);
//組合SQL(查詢)
//SELECT * FROM shops ORDER BY hot DESC LIMIT 0, 6
//SELECT * FROM shops ORDER BY hot DESC LIMIT 6, 6
//SELECT * FROM shops ORDER BY hot DESC LIMIT 12, 6
$sql = "SELECT * FROM shops {$where} {$orderby} {$limit}"; //組合SQL指令
$stmt = $pdo->prepare($sql);
$stmt->execute();
$shops = $stmt->fetchAll(PDO::FETCH_ASSOC);

// 取分頁連結
function getPageLink($page) {
    parse_str($_SERVER['QUERY_STRING'], $data); 
    $data['page'] = $page;
    return "shop.php?" . http_build_query($data);
}


?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/271f30e909.js" crossorigin="anonymous"></script>
    <title>Document</title>
    <link rel="stylesheet" href="./css/reset.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css"
        integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/11.0.2/css/bootstrap-slider.min.css"
        integrity="sha512-3q8fi8M0VS+X/3n64Ndpp6Bit7oXSiyCnzmlx6IDBLGlY5euFySyJ46RUlqIVs0DPCGOypqP8IRk/EyPvU28mQ=="
        crossorigin="anonymous" />
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <link rel="stylesheet" href="./css/nav_footer.css">
    <link rel="stylesheet" href="./css/nav2.css">
    <link rel="stylesheet" href="./css/breadcrumb.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link
        href="https://fonts.googleapis.com/css2?family=Faustina:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet">
    <style>
        body {
            font-family: 'Faustina', serif;
            background-image: url(./img/bcc.png);
            color: #707070;
            font-size: 16px;
        }

        h3 {
            font-size: 24px;
            font-weight: bold;
            color: #707070;
        }



        .shop-breadcrumb .breadcrumb-item+.breadcrumb-item::before {
            content: "\f054";
            font-family: "Font Awesome 5 Pro";
            font-weight: 900;
            color: #707070;
            font-size: 12px;
        }


        .shop_search {
            border-bottom: 2px solid #c0c0c0;
            font-size: 24px;
        }

        .shop_search input {
            font-size: 20px;
            color: #707070;
        }

        .shop_search i {
            font-size: 24px;
            color: #c0c0c0;
            position: absolute;
            right: 0px;
            top: 15px;
        }

        .shop_category a{
            color: #707070;
        }

        .shop_category ul li a{
            font-size: 20px;
        }

        .shop_category ul li ul li a{
            font-weight: normal;
        }

        .shop_category ul li a:hover,
        .shop_category ul li a.active{
            font-weight: bold;
            text-decoration:none;
        }

        #shop_price_range .slider-selection {
            background: #cc543a;
        }

        #shop_price_range .slider-handle {
            border: 5px solid #cc543a;
            background: #FFF;
        }

        #shop_price_range .arrow {
            display: none;
        }

        #shop_price_range .tooltip-inner {
            font-family: 'Sitka Display', NSimSun, 'sans-serif';
            font-size: 20px;
            padding: 0;
            color: #000;
            background-color: transparent;
        }

        .shop_sort {
            font-size: 20px;
            color: #707070;
        }

        .shop_sort select {
            font-size: 20px;
            border-radius: 5px;
            color: #707070;
        }

        .shop_like {
            width: 42px;
            height: 42px;
            border: 2px solid #cc543a;
            background-color: #FFF;
            border-radius: 50%;
            top: 0;
            right: 0;
        }

        .shop_like i {
            font-size: 26px;
            color: #cc543a;
        }

        .shop_like .fas {
            font-size: 20px;
            color: #FFF;
        }

        .shop_like.active {
            background-color: #cc543a;
        }

        .shop_like.active i {
            font-weight: 900;
            font-size: 20px;
            color: #FFF;
        }

        .shop_re_img {
            position: relative;
            width: 100%;
            overflow: hidden;
            border-radius: 5px 5px 0px 0px;
        }

        .shop_re_card {
            background-color: #fff;
            border-radius: 0px 0px 5px 5px;
            overflow: hidden;
        }

        .shop_re_img_card {
            border-radius: 5px;

        }

        .shop_re_img:hover .shop_re_more {
            display: flex;
            justify-content: center;
            position: absolute;
            top: 0;
            left: 0;
            background-color: rgb(0, 0, 0, 0.5);
            width: 100%;
            height: 100%;
        }

        .shop_re_card {
            background-color: #fff;
        }

        .shop_re_text {
            font-weight: bold;
            font-size: 22px;
        }

        .shop_re_text1 {
            font-size: 16px;

        }

        .shop_re_price {
            font-size: 22px;
        }

        .shop_page_item {
            color: #707070;
            font-size: 24px;
            background-color: transparent;
            padding: .5rem 1rem;
            border: 1px solid #cdcdcd;
        }

        .shop_page_item:hover,
        .shop_page_item.active {
            background-color: #c0c0c0;
            color: #FFF;
            font-weight: bold;
        }


        .shop_page_item1 {
            color: #707070;
            font-size: 24px;
            background-color: transparent;
        }

        .shop_page_item1:focus {
            background-color: #c0c0c0;
            color: #FFF;
            font-weight: bold;
        }


        .shop_re_more {
            display: none;
        }



        .shop_scrolling_wrapper .shop_re_img:hover img {
            transform: scale(1.1, 1.1);
        }

        select.shop_item_body_more {
            align-items: right;
            text-align: center;
            text-align-last: center;
        }

        .shop_item_body_more {
            border: none;
            border-radius: 50px;
            font-size: 18px;
            color: #707070;
            font-weight: bold;
            padding: 8px 20px;

        }

        .shop_price_txt {
            font-size: 24px;
            font-weight: bold;
        }

        .shop_price_txt_mobile {
            font-size: 20px;
            font-weight: bold;

        }
        .shop_price_mobile{
            margin: auto;
        }

        .shop_price_mobile .card {
            border-radius: 20px;
            background-color: #fff;
        }

        .shop_price_mobile .slider {
            width: 270px;
        }

        #shop_price_range .slider-selection {
            background: #cc543a;
        }

        #shop_price_range .slider-handle {
            border: 5px solid #cc543a;
            background: #FFF;
        }

        #shop_price_range .arrow {
            display: none;
        }

        #shop_price_range .tooltip-inner {
            font-family: 'Sitka Display', NSimSun, 'sans-serif';
            font-size: 20px;
            padding: 0;
            color: #000;
            background-color: transparent;
        }

        .shop_card{
            
        }

        @media (min-width: 992px) {
            .shop_container {
                width: 1400px;
            }

            .shop_like:hover i {
                font-weight: 900;
                font-size: 25px;
                color: #cc543a;
            }

            .shop_like.active i {
                color: #fff;
                font-size: 25px;
            }

            .shop_body_bg {
                position: relative;
            }

            .shop_body_bg:before {
                content: '';
                display: block;
                width: 208px;
                height: 386px;
                position: absolute;
                bottom: 300px;
                left: 300px;
                background-size: cover;
                background-image: url(img/nav_shop.png);
                opacity: 0.39;
            }
        }



        @media (max-width: 991px) {
            .shop_like {
                width: 30px;
                height: 30px;
                font-size: 18px;
                color: #cc543a;
            }

            .shop_like i {
                font-size: 18px;
            }

            .shop_like .fas {
                font-size: 18px;
            }

            .shop_like.active {
                background-color: #cc543a;
            }

            .shop_like.active i {
                font-size: 16px;
            }

            .shop_scrolling_wrapper {
                overflow-x: auto;
            }

            .shop_re_text {
                font-size: 18px;
            }

            .shop_re_text1 {
                font-size: 16px;
            }

            .shop_re_price {
                font-size: 18px;
            }

        }

    </style>
</head>

<body>
    <div class="nav_burgurBar">
        <div class="nav_burgurBar_img">
            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="20" viewBox="0 0 25 20">
                <g id="Group_135" data-name="Group 135" transform="translate(-341.5 -1313.5)">
                    <line id="Line_50" data-name="Line 50" x2="23" transform="translate(342.5 1314.5)" fill="none"
                        stroke="#707070" stroke-linecap="round" stroke-width="2" />
                    <line id="Line_51" data-name="Line 51" x2="23" transform="translate(342.5 1323.5)" fill="none"
                        stroke="#707070" stroke-linecap="round" stroke-width="2" />
                    <line id="Line_52" data-name="Line 52" x2="23" transform="translate(342.5 1332.5)" fill="none"
                        stroke="#707070" stroke-linecap="round" stroke-width="2" />
                </g>
            </svg>
        </div>

        <div class="nav_logo_mobile">
            <img src="./img/nav_logo_mobile.svg" alt="">
        </div>

    </div>

    <div class="nav_overlayNav">
        <div class="nav_closeBtn mb-4">
            <svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 20 20">
                <title>close</title>
                <path fill='#fff'
                    d="M10 8.586l-7.071-7.071-1.414 1.414 7.071 7.071-7.071 7.071 1.414 1.414 7.071-7.071 7.071 7.071 1.414-1.414-7.071-7.071 7.071-7.071-1.414-1.414-7.071 7.071z">
                </path>
            </svg>
        </div>
        <div class="nav_overlayNavBox">
            <ul>
                <a href="">
                    <li>最新消息</li>
                </a>
                <a href="">
                    <li>探索灣廟</li>
                </a>
                <li class="nav_ser_mobile">
                    線上服務
                    <i class="fas fa-angle-down"></i>
                </li>
                <ul class="nav_dropDownMenu_mobile">
                    <a class="dropdown-item nav_ser_item_mob" href="#">祈福點燈</a>
                    <a class="dropdown-item nav_ser_item_mob" href="#">求神問卜</a>
                </ul>
                <a href="">
                    <li>聖地行旅</li>
                </a>
                <a href="">
                    <li>祈福商店</li>
                </a>
                <a href="">
                    <li>購物車</li>
                </a>
                <a href="" data-toggle="modal" data-target="#loginCenter">
                    <li>登入 | 註冊</li>
                </a>
            </ul>
        </div>
    </div>
    <!-- 電腦螢幕大小的navbar -->
    <nav class="nav_navbar_com">
        <div class="nav_navbar_com_container">
            <!-- 請依檔案位置修改logo路徑 -->
            <img src='./img/nav_logo.svg'>

            <div class="nav_navbar">
                <div class="nav_navbarBox">
                    <div class="nav_nav_left">
                        <a href="" class="nav_navbar_item">
                            <div class="nav_hide_ch">最新消息</div>
                            <div class="nav_hide_en">NEWS</div>
                        </a>
                        <a href="" class="nav_navbar_item">
                            <div class="nav_hide_ch">探索灣廟</div>
                            <div class="nav_hide_en">EXPLORE</div>
                        </a>
                        <a href="#" class="nav_navbar_item nav_ser">
                            <div class="nav_hide_ch">線上服務</div>
                            <div class="nav_hide_en">SERVICE</div>

                            <ul class="nav_dropDownMenu">
                                <a class="dropdown-item nav_ser_item" href="#">祈福點燈</a>
                                <a class="dropdown-item nav_ser_item" href="#">求神問卜</a>
                            </ul>
                        </a>

                        <a href="" class="nav_navbar_item">
                            <div class="nav_hide_ch">聖地行旅</div>
                            <div class="nav_hide_en">TRIP</div>
                        </a>
                        <a href="" class="nav_navbar_item">
                            <div class="nav_hide_ch">祈福商店</div>
                            <div class="nav_hide_en">SHOP</div>
                        </a>
                        <a href="" class="nav_navbar_item">
                            <div class="nav_hide_ch">購物車</div>
                            <div class="nav_hide_en">CART</div>
                        </a>
                    </div>
                    <div class="nav_nav_right">
                        <a href="" data-toggle="modal" data-target="#loginCenter" class="nav_navbar_item">
                            <div>登入</div>
                        </a>
                        <span class="nav_navbar_item">|</span>
                        <a href="" data-toggle="modal" data-target="#registerCenter" class="nav_navbar_item">
                            <div>註冊</div>
                        </a>
                    </div>
                </div>
            </div>

        </div>

        <hr class="nav_navline">
    </nav>
    <div class="breadcrumb_style backgroundimg_1">
        <div class="d-flex flex-wrap breadcrumb_style_1 ">
            <a href="" class="astlyep">首頁</a>
            <!-- 共用雲端找箭頭icon-->
            <img src="./img/nav_arrow_right.svg">
            祈福商店
        </div>
    </div>
    <div class="container-fluid shop_body_bg">
        <div class="shop_container container-fluid px-lg-5 px-3 px-0">
            <div class="d-flex justify-content-between mb-2 d-lg-none">
                <select class="shop_item_body_more shadow bg-white text-center <?=($cat2||$cat1)?'active':''?>" id="exampleFormControlSelect1">
                    <option>商品分類</option>
                    <option value="飾品" <?=($cat1=='飾品')?'selected':''?>>飾品</option>
                    <option value="擺飾" <?=($cat1=='擺飾')?'selected':''?>>擺飾</option>
                    <option value="平安符"<?=($cat1=='平安符')?'selected':''?>>平安符</option>
                    <option value="聯名合作"<?=($cat2=='聯名合作')?'selected':''?>>聯名合作</option>
                    <option value="熱門商品"<?=($cat2=='熱門商品')?'selected':''?>>熱門商品</option>
                </select>
                <div class="shop_item_body_more shadow bg-white d-flex align-items-center justify-content-center"
                    data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false"
                    aria-controls="collapseExample">
                    價錢範圍
                </div>
            </div>
            <div class="row d-block d-lg-none">
                <div class="collapse shop_price_mobile <?=isset($_GET['price'])?' show':''?>" id="collapseExample">
                    <div class="card card-body">
                        <ul>
                            <li class="py-1">
                                <div class="shop_price_txt_mobile">價錢範圍</div>
                                <div><input class="shop_price_range_mobile" id="ex8" data-slider-id='shop_price_range'
                                        type="text" data-slider-min="0" data-slider-max="5000" data-slider-step="200"
                                        data-slider-value="5000" /></div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-3 d-none d-lg-block">
                    <div style="max-width:210px;">
                        <div class="shop_search position-relative mb-5">
                            <input type="text" class="form-control border-0 bg-transparent px-1"
                                id="keyword" placeholder="找商品..">
                            <i class="fa fa-search fa-lg"></i>
                        </div>
                        <div class="d-none">
                            <div class="rounded-circle"><i class="far fa-heart rounded-circle p-2"
                                    style="background-color: #FFF; color:red;"></i></div>
                        </div>
                        <div class="shop_category">
                            <h3 class="py-2">商品分類 |</h3>
                            <ul>
                                <li class="py-1"><a <?=(isset($_GET['cat1']) && $_GET['cat1'] == '飾品')?'class="active"':''?>href="shop.php?cat1=飾品">飾品</a></li>
                                <li class="py-1"><a <?=(isset($_GET['cat1']) && $_GET['cat1'] == '擺飾')?'class="active"':''?>href="shop.php?cat1=擺飾">擺飾</a></li>
                                <li class="py-1"><a <?=(isset($_GET['cat1']) && $_GET['cat1'] == '平安符')?'class="active"':''?>href="shop.php?cat1=平安符">平安符</a></li>
                                <li class="py-1"><a <?=(isset($_GET['cat2']) && $_GET['cat2'] == '聯名合作')?'class="active"':''?>href="shop.php?cat2=聯名合作">聯名合作</a></li>
                                <li class="py-1"><a <?=(isset($_GET['cat2']) && $_GET['cat2'] == '熱門商品')?'class="active"':''?>href="shop.php?cat2=熱門商品">熱門商品</a></li>
                            </ul>
                            <ul>
                                <li class="py-1">
                                    <h3 class="shop_price_txt">價錢範圍 |</h3>
                                    <div><input class="shop_price_range" id="ex8" data-slider-id='shop_price_range'
                                            type="text" data-slider-min="0" data-slider-max="5000"
                                            data-slider-step="200" data-slider-value="5000" /></div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-9">
                    <div class="d-lg-flex justify-content-end d-none d-lg-block">
                        <div class="shop_sort d-flex justify-content-end mb-5 ">
                            <div class="form-inline">
                                <label class="pr-3" for="exampleFormControlSelect1">排序方式</label>
                                <select class="form-control bg-transparent" id="shop_order">
                                    <option value="hot" <?=($shop_order=='hot')?'selected':''?>>熱門商品</option>
                                    <option value="created_at" <?=($shop_order=='created_at')?'selected':''?>>最新商品</option>
                                    <option value="price" <?=($shop_order=='price')?'selected':''?>>價格(從低到高)</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row shop_scrolling_wrapper"
                    data-aos="fade-up" data-aos-duration="2000">
                    <?php
if(count($shops) > 0) {
    foreach($shops as $shop){
?>
                       <div class="shop_card col-lg-4 col-6 mt-4 mt-lg-0 ">
                            <div class="shop_re_img_card shadow ">
                                <div class="shop_re_img">
                                    <img src="img/<?=$shop['img1']?>" width="100%" />
                                    <div class="shop_re_more">
                                    </div>
                                </div>
                                <div class="shop_re_card mb-lg-5 mb-0">
                                    <div class="shop_re_text pt-2 pl-3"><?=$shop['title1']?>
                                    </div>
                                    <div class="shop_re_text1 pl-3"><?=$shop['title2']?></div>
                                    <div class="pb-3 shop_re_price pl-3"><span>NTD <?=number_format($shop['price'],0,".",",")?></span>元</div>
                                </div>
                            </div>
                            <div
                                class="shop_like position-absolute d-flex justify-content-center align-items-center mr-lg-4 mt-lg-2 mr-3 mt-1">
                                <i class="far fa-heart"></i>
                            </div>
                        </div>
<?php
    }
} else { 
?>
                       <div class=" text-center">不好意思，我們沒有找到相關的商品</div>
<?php
}
?>
                        

                        <!-- <div class="col-lg-4 col-6 mt-4 mt-lg-0">
                            <div class="shop_re_img_card shadow">
                                <div class="shop_re_img">
                                    <img src="/img/011.png" width="100%" />
                                    <div class="shop_re_more">
                                    </div>
                                </div>
                                <div class="shop_re_card mb-4">
                                    <div class="shop_re_text pt-2 pl-3">媽祖胸針
                                    </div>
                                    <div class="shop_re_text1 pl-3">Charlene 創作 </div>
                                    <div class="pb-3 shop_re_price pl-3"><span>NTD 250</span>元</div>
                                </div>
                            </div>
                            <div
                                class="shop_like position-absolute d-flex justify-content-center align-items-center mr-lg-4 mt-lg-2 mr-3 mt-1">
                                <i class="far fa-heart"></i>
                            </div>
                        </div>
                        <div class="col-lg-4 col-6 mt-4 mt-lg-0">
                            <div class="shop_re_img_card shadow ">
                                <div class="shop_re_img">
                                    <img src="/img/013.png" width="100%" />
                                    <div class="shop_re_more">
                                    </div>
                                </div>
                                <div class="shop_re_card mb-4 ">
                                    <div class="shop_re_text pt-2 pl-3">藝術廟宇戒指
                                    </div>
                                    <div class="shop_re_text1 pl-3">TIMBEE 限量版 </div>
                                    <div class="pb-3 shop_re_price pl-3"><span>NTD 1,109</span>元</div>
                                </div>
                            </div>
                            <div
                                class="shop_like position-absolute d-flex justify-content-center align-items-center mr-lg-4 mt-lg-2 mr-3 mt-1">
                                <i class="far fa-heart"></i>
                            </div>
                        </div>
                        <div class="col-lg-4 col-6 mt-4 mt-lg-0">
                            <div class="shop_re_img_card shadow">
                                <div class="shop_re_img">
                                    <img src="/img/011.png" width="100%" />
                                    <div class="shop_re_more">
                                    </div>
                                </div>
                                <div class="shop_re_card mb-4">
                                    <div class="shop_re_text pt-2 pl-3">媽祖胸針
                                    </div>
                                    <div class="shop_re_text1 pl-3">Charlene 創作 </div>
                                    <div class="pb-3 shop_re_price pl-3"><span>NTD 250</span>元</div>
                                </div>
                            </div>
                            <div
                                class="shop_like position-absolute d-flex justify-content-center align-items-center mr-lg-4 mt-lg-2 mr-3 mt-1">
                                <i class="far fa-heart"></i>
                            </div>
                        </div>
                        <div class="col-lg-4 col-6 mt-4 mt-lg-0">
                            <div class="shop_re_img_card shadow ">
                                <div class="shop_re_img">
                                    <img src="/img/013.png" width="100%" />
                                    <div class="shop_re_more">
                                    </div>
                                </div>
                                <div class="shop_re_card mb-4 ">
                                    <div class="shop_re_text pt-2 pl-3">藝術廟宇戒指
                                    </div>
                                    <div class="shop_re_text1 pl-3">TIMBEE 限量版 </div>
                                    <div class="pb-3 shop_re_price pl-3"><span>NTD 1,109</span>元</div>
                                </div>
                            </div>
                            <div
                                class="shop_like position-absolute d-flex justify-content-center align-items-center mr-lg-4 mt-lg-2 mr-3 mt-1">
                                <i class="far fa-heart"></i>
                            </div>
                        </div>
                        <div class="col-lg-4 col-6 mt-4 mt-lg-0">
                            <div class="shop_re_img_card shadow">
                                <div class="shop_re_img">
                                    <img src="/img/011.png" width="100%" />
                                    <div class="shop_re_more">
                                    </div>
                                </div>
                                <div class="shop_re_card mb-4">
                                    <div class="shop_re_text pt-2 pl-3">媽祖胸針
                                    </div>
                                    <div class="shop_re_text1 pl-3">Charlene 創作 </div>
                                    <div class="pb-3 shop_re_price pl-3"><span>NTD 250</span>元</div>
                                </div>
                            </div>
                            <div
                                class="shop_like position-absolute d-flex justify-content-center align-items-center mr-lg-4 mt-lg-2 mr-3 mt-1">
                                <i class="far fa-heart"></i>
                            </div>
                        </div>
                        <div class="col-lg-4 col-6 mt-4 mt-lg-0">
                            <div class="shop_re_img_card shadow ">
                                <div class="shop_re_img">
                                    <img src="/img/013.png" width="100%" />
                                    <div class="shop_re_more">
                                    </div>
                                </div>
                                <div class="shop_re_card mb-4 ">
                                    <div class="shop_re_text pt-2 pl-3">藝術廟宇戒指
                                    </div>
                                    <div class="shop_re_text1 pl-3">TIMBEE 限量版 </div>
                                    <div class="pb-3 shop_re_price pl-3"><span>NTD 1,109</span>元</div>
                                </div>
                            </div>
                            <div
                                class="shop_like position-absolute d-flex justify-content-center align-items-center mr-lg-4 mt-lg-2 mr-3 mt-1">
                                <i class="far fa-heart"></i>
                            </div>
                        </div>
                        <div class="col-lg-4 col-6 mt-4 mt-lg-0">
                            <div class="shop_re_img_card shadow">
                                <div class="shop_re_img">
                                    <img src="/img/011.png" width="100%" />
                                    <div class="shop_re_more">
                                    </div>
                                </div>
                                <div class="shop_re_card mb-4">
                                    <div class="shop_re_text pt-2 pl-3">媽祖胸針
                                    </div>
                                    <div class="shop_re_text1 pl-3">Charlene 創作 </div>
                                    <div class="pb-3 shop_re_price pl-3"><span>NTD 250</span>元</div>
                                </div>
                            </div>
                            <div
                                class="shop_like position-absolute d-flex justify-content-center align-items-center mr-lg-4 mt-lg-2 mr-3 mt-1">
                                <i class="far fa-heart"></i>
                            </div>
                        </div>
                        <div class="col-lg-4 col-6 mt-4 mt-lg-0">
                            <div class="shop_re_img_card shadow ">
                                <div class="shop_re_img">
                                    <img src="/img/013.png" width="100%" />
                                    <div class="shop_re_more">
                                    </div>
                                </div>
                                <div class="shop_re_card mb-4 ">
                                    <div class="shop_re_text pt-2 pl-3">藝術廟宇戒指
                                    </div>
                                    <div class="shop_re_text1 pl-3">TIMBEE 限量版 </div>
                                    <div class="pb-3 shop_re_price pl-3"><span>NTD 1,109</span>元</div>
                                </div>
                            </div>
                            <div
                                class="shop_like position-absolute d-flex justify-content-center align-items-center mr-lg-4 mt-lg-2 mr-3 mt-1">
                                <i class="far fa-heart"></i>
                            </div>
                        </div>
                        <div class="col-lg-4 col-6 mt-4 mt-lg-0">
                            <div class="shop_re_img_card shadow">
                                <div class="shop_re_img">
                                    <img src="/img/011.png" width="100%" />
                                    <div class="shop_re_more">
                                    </div>
                                </div>
                                <div class="shop_re_card mb-4">
                                    <div class="shop_re_text pt-2 pl-3">媽祖胸針
                                    </div>
                                    <div class="shop_re_text1 pl-3">Charlene 創作 </div>
                                    <div class="pb-3 shop_re_price pl-3"><span>NTD 250</span>元</div>
                                </div>
                            </div>
                            <div
                                class="shop_like position-absolute d-flex justify-content-center align-items-center mr-lg-4 mt-lg-2 mr-3 mt-1">
                                <i class="far fa-heart"></i>
                            </div>
                        </div>
                        <div class="col-lg-4 col-6 mt-4 mt-lg-0">
                            <div class="shop_re_img_card shadow ">
                                <div class="shop_re_img">
                                    <img src="/img/013.png" width="100%" />
                                    <div class="shop_re_more">
                                    </div>
                                </div>
                                <div class="shop_re_card mb-4 ">
                                    <div class="shop_re_text pt-2 pl-3">藝術廟宇戒指
                                    </div>
                                    <div class="shop_re_text1 pl-3">TIMBEE 限量版 </div>
                                    <div class="pb-3 shop_re_price pl-3"><span>NTD 1,109</span>元</div>
                                </div>
                            </div>
                            <div
                                class="shop_like position-absolute d-flex justify-content-center align-items-center mr-lg-4 mt-lg-2 mr-3 mt-1">
                                <i class="far fa-heart"></i>
                            </div>
                        </div>
                        <div class="col-lg-4 col-6 mt-4 mt-lg-0">
                            <div class="shop_re_img_card shadow">
                                <div class="shop_re_img">
                                    <img src="/img/011.png" width="100%" />
                                    <div class="shop_re_more">
                                    </div>
                                </div>
                                <div class="shop_re_card mb-4">
                                    <div class="shop_re_text pt-2 pl-3">媽祖胸針
                                    </div>
                                    <div class="shop_re_text1 pl-3">Charlene 創作 </div>
                                    <div class="pb-3 shop_re_price pl-3"><span>NTD 250</span>元</div>
                                </div>
                            </div>
                            <div
                                class="shop_like position-absolute d-flex justify-content-center align-items-center mr-lg-4 mt-lg-2 mr-3 mt-1">
                                <i class="far fa-heart"></i>
                            </div>
                        </div> -->

                    </div>

                </div>

            </div>
            <nav class="shop_page position-relative d-flex justify-content-end" aria-label="Page navigation example">
                <ul class="pagination ">
                <?php
                for($i=1;$i<=$total_pages;$i++){
                ?> 
                   <li class="page-item"><a class="page-link shop_page_item <?=($page==$i)?'active':''?>"href="<?=getPageLink($i)?>"><?=$i?></a></li>
                <?php
                }
                ?>
                
                    <!-- <li class="page-item"><a class="page-link shop_page_item active" href="#">1</a></li>
                    <li class="page-item"><a class="page-link shop_page_item" href="#">2</a></li>
                    <li class="page-item"><a class="page-link shop_page_item" href="#">3</a></li>
                    <li class="page-item"><a class="page-link shop_page_item" href="#">4</a></li>
                    <li class="page-item"><a class="page-link shop_page_item" href="#">></a></li> -->
                </ul>
            </nav>
        </div>
    </div>
    <!-- login -->
    <div class="modal fade" id="loginCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content modal-content-re">
                <div class="modal-header modal-header-re">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h5 class="modal-title" id="exampleModalCenterTitle">登入 | LOGIN</h5>
                </div>
                <div class="modal-body">
                    <form class="mt-3">
                        <div class="form-group mb-3">
                            <input type="text" class="form-control form-control-re" id="account-name"
                                placeholder="Email">
                        </div>
                        <div class="form-group">
                            <input class="form-control form-control-re" id="password-text" placeholder="Password">
                        </div>
                        <input type="checkbox"> 記住帳號
                    </form>
                </div>
                <div class="modal-footer modal-footer-re">
                    <button type="button" class="btn btn-primary btn-primary-re">登入</button>
                </div>
                <div class="modal-footer2-re mt-3">
                    <a class="mr-5" data-toggle="modal" data-target="#lostPassword" id="passwordbtn">忘記密碼</a>
                    <a data-toggle="modal" data-target="#registerCenter" id="registerbtn">註冊帳號</a>
                </div>
            </div>
        </div>
    </div>

    <!-- lost password -->
    <div class="modal fade" id="lostPassword" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content modal-content-re">
                <div class="modal-header modal-header-re">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h5 class="modal-title" id="exampleModalCenterTitle">找回密碼</h5>
                </div>
                <div class="modal-body">
                    <form class="mt-3">
                        <div class="form-group mb-3">
                            <p>請輸入您註冊的電子郵件，您將會在電子郵件信箱中收到重設密碼的連結。</p>
                            <input type="text" class="form-control form-control-re" id="account-name"
                                placeholder="Email">
                        </div>
                    </form>
                </div>
                <div class="modal-footer modal-footer-re">
                    <button type="button" class="btn btn-primary btn-primary-re">送出</button>
                </div>
            </div>
        </div>
    </div>

    <!-- register -->
    <div class="modal fade" id="registerCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content modal-content-re">
                <div class="modal-header modal-header-re">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h5 class="modal-title" id="exampleModalCenterTitle">註冊 | REGISTER</h5>
                </div>
                <div class="modal-body">
                    <form class="mt-3">
                        <div class="form-group mb-3">
                            <input type="text" class="form-control form-control-re" id="account-name"
                                placeholder="User Name">
                        </div>
                        <div class="form-group mb-3">
                            <input type="text" class="form-control form-control-re" id="account-name"
                                placeholder="Email">
                        </div>
                        <div class="form-group">
                            <input class="form-control form-control-re" id="password-text" placeholder="Password">
                        </div>
                        <div class="form-group">
                            <input class="form-control form-control-re" id="password-text"
                                placeholder="Repeat Password">
                        </div>
                    </form>
                </div>
                <div class="modal-footer modal-footer-re">
                    <button type="button" class="btn btn-primary btn-primary-re">註冊</button>
                </div>
            </div>
        </div>
    </div>

    <footer>
        <p>Copyright© TempleTrip.tw</p>
    </footer>







    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
        crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"
        integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k"
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/11.0.2/bootstrap-slider.min.js"
        integrity="sha512-f0VlzJbcEB6KiW8ZVtL+5HWPDyW1+nJEjguZ5IVnSQkvZbwBt2RfCBY0CBO1PsMAqxxrG4Di6TfsCPP3ZRwKpA=="
        crossorigin="anonymous"></script>
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>
        AOS.init();
        var urlParams = new URLSearchParams(window.location.search);
        $(".shop_price_range").slider({
            tooltip: 'always',
            tooltip_position: 'bottom',
        }).slider('setValue', urlParams.get('price')?urlParams.get('price'):5000).on('slideStop', function(){
            location.href="shop.php?price=" + $(this).val();
        });

        $(".shop_price_range_mobile").slider({
            tooltip: 'always',
            tooltip_position: 'bottom',
        }).slider('setValue', urlParams.get('price')?urlParams.get('price'):5000).on('slideStop', function(){
            location.href="shop.php?price=" + $(this).val();
        });

        $(".shop_like").click(function () {
            $(this).toggleClass('active');
        });
        
        $(".shop_item_body_more").change(function () {
            if ($(this).val() > 0) {
                $(this).addClass('active');
            } else {
                $(this).removeClass('active');
            }
            if ($(this).val() == "飾品" || $(this).val() == "擺飾" || $(this).val() == "平安符") {
                location.href="shop.php?cat1=" + $(this).val()
            }

            if ($(this).val() == "聯名合作" || $(this).val()=="熱門商品") {
                  location.href="shop.php?cat2=" + $(this).val()
            }
        })

        $(".shop_search i").click(function(){
            location.href="shop.php?keyword=" + $('#keyword').val();
        })

        $('#keyword').val(urlParams.get('keyword'));

        $('#shop_order').change(function(){
            urlParams.delete("page");
            urlParams.set("o", $(this).val());
            location.href="shop.php?" + urlParams.toString();
        });

        // overlayNav進場
        $('.nav_burgurBar_img').click(function () {

            let navPosition = {
                transform: 'translateY(0)'
            }

            $(".nav_overlayNav").css(navPosition);
        })

        // overlayNav退場
        $('.nav_closeBtn').click(function () {

            let navPosition = {
                transform: 'translateY(-2500px)',
                transition: '.7s'
            }

            $(".nav_overlayNav").css(navPosition);
        })


        //Login hide
        $('#registerbtn').click(function () {
            $('#loginCenter').modal('hide');
        })

        $('#passwordbtn').click(function () {
            $('#loginCenter').modal('hide');
        })

        //overlay sub-menu
        $(document).ready(function () {
       $('.nav_ser_mobile').click(function () {
        $('.nav_dropDownMenu_mobile').toggle('slow');

})
});


    </script>
</body>

</html>