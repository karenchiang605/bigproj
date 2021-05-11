<?php

require __DIR__ . "/__connect_db.php";

$where = " WHERE cat = '熱門行程'";
if (isset($_GET['cat']) && $_GET['cat']) {
    $where = " WHERE cat = '".$_GET['cat']."'";
}
if (isset($_GET['cat_area']) && $_GET['cat_area']) {
    $where = " WHERE cat_area = '".$_GET['cat_area']."'";
}
if (isset($_GET['price']) && $_GET['price']) {
    $where = " WHERE price <= '".$_GET['price']."'";
}
if (isset($_GET['keyword']) && $_GET['keyword']) {
    $where = " WHERE title2 like '%".$_GET['keyword']."%'";
}
$orderby = "ORDER BY hot DESC";
//排序
if (isset($_GET['o']) && $_GET['o'] == 'price') {
    $orderby = "ORDER BY ".$_GET['o']." ASC";
} else if (isset($_GET['o']) && $_GET['o']) {
    $orderby = "ORDER BY ".$_GET['o']." DESC";
}

$trip_order = isset($_GET['o'])?$_GET['o']:"";
$cat_area = isset($_GET['cat_area'])?$_GET['cat_area']:"";
$cat = isset($_GET['cat'])?$_GET['cat']:"";

//分頁算法
$page = (isset($_GET['page']) && $_GET['page'])?$_GET['page']:1; //當前頁數
$per_page = 8; //一頁幾筆
$sql = "SELECT COUNT(0) FROM trips {$where}";
$total = $pdo->query($sql)->fetch(PDO::FETCH_NUM)[0]; //總筆數
$total_pages = ceil($total / $per_page); //總頁數

//如果筆數非大於0則頁數為1
if($total_pages > 0) {
    $page = ($page > $total_pages)?$total_pages:$page;
} else {
    $page = 1;
}
$limit = sprintf("LIMIT %s, %s", ($page - 1)*$per_page, $per_page);

$stmt = $pdo->prepare($sql);
$stmt->execute();
$trips = $stmt->fetchAll(PDO::FETCH_ASSOC);

//組合SQL
$sql = "SELECT * FROM trips {$where} {$orderby} {$limit}";
//SELECT * FROM trips WHERE cat = '熱門行程' ORDER BY hot DESC LIMIT 0, 8
//SELECT * FROM trips WHERE title2 like '%aaa%' ORDER BY hot DESC LIMIT 0, 8
//echo $sql;
$stmt = $pdo->prepare($sql);
$stmt->execute();
$trips = $stmt->fetchAll(PDO::FETCH_ASSOC);


// 取分頁連結
function getPageLink($page) {
    parse_str($_SERVER['QUERY_STRING'], $data); 
    $data['page'] = $page;
    return "trip.php?" . http_build_query($data);
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
            font-size: 16px;
        }

        h3 {
            font-size: 24px;
            font-weight: bold;
            color: #707070;
        }

        @media (min-width: 992px) {
            .trip_container {
                width: 1400px;
            }

            .trip_body_bg {
                position: relative;
            }

            .trip_body_bg img {
                position: relative;
            }

            .trip_body_bg:before {
                content: '';
                display: block;
                width: 700px;
                height: 625px;
                position: absolute;
                bottom: 0;
                left: 0;
                background-size: cover;
                background-image: url(img/nav_left_g_mark.png);
                opacity: 0.39;
            }
            .trip_product_list {
                min-height:600px;
            }


        }

        select.trip_item_body_more1 {
            align-items: right;
            text-align: center;
            text-align-last: center;
        }

        .trip-breadcrumb .breadcrumb-item+.breadcrumb-item::before {
            content: "\f054";
            font-family: "Font Awesome 5 Pro";
            font-weight: 900;
            color: #707070;
            font-size: 12px;
        }

        .trip_item_border {
            border-radius: 5px;
            overflow: hidden;
        }

        .trip_item_border:hover {
            box-shadow: 0 8px 16px 0 rgb(0 0 0 / 18%), 0 -1px 2px 0 rgb(0 0 0 / 8%);
            transform: translateY(-2px);
        }

        .breadcrumb-item {
            font-size: 18px;

        }

        .breadcrumb-item a {
            color: #707070;
        }

        .trip_item_body {
            font-size: 18px;
            background-color: #FFF;

        }

        .trip_item_body_mobile {
            font-size: 16px;
            color: #707070;
            background-color: #FFF;
        }

        .trip_item_body_title {
            color: #cc543a;
            font-weight: bold;
            font-size: 22px;
        }

        .trip_item_body_title_mobile {
            color: #cc543a;
            font-weight: bold;
            font-size: 20px;
        }

        .trip_item_body_body {
            color: #707070;
        }

        .trip_item_body_body i {
            width: 30px;
            text-align: center;
        }

        .trip_search {
            border-bottom: 2px solid #c0c0c0;
            font-size: 24px;
        }

        .trip_search input {
            font-size: 20px;
            color: #707070;
        }

        .trip_search i {
            font-size: 24px;
            color: #c0c0c0;
            position: absolute;
            right: 0px;
            top: 15px;
        }

        .trip_category {
            color: #707070;
        }

        .trip_category ul li a{
            font-size: 20px;
            color: #707070;
        }

        .trip_category ul li ul li a {
            font-weight: normal; 
        }

        .trip_category ul li a:hover,
        .trip_category ul li a.active{
            font-weight: bold;
            text-decoration:none;
            color: #707070;
        }

        .trip_sort {
            font-size: 20px;
            color: #707070;
        }

        .trip_sort select {
            font-size: 20px;
            border-radius: 5px;
            color: #707070;
        }

        .trip_item_body_more {
            background-color: #cc543a;
            border-radius: 50px;
            border: none;
            padding: 10px 24px;
            font-size: 1rem;
            font-weight: bold;
            color: rgb(255, 255, 255);
        }

        .trip_item_body_more:hover {
            background-color: #dd745e;
        }

        .trip_item_body_more_mobile {
            font-size: 16px;
            background-color: #cc543a;
            color: #fff;
            border-radius: 50px;
            padding: 5px 10px;
            text-align: center;
            width: 50%;
        }

        .trip_item_body_more_mobile.active {
            background-color: #dd745e;
        }

        .trip_item_body_more1 {
            border: none;
            border-radius: 50px;
            font-size: 18px;
            color: #707070;
            padding: 8px 20px;

        }

        .trip_item_body_more2 {
            border: none;
            border-radius: 50px;
            font-size: 18px;
            color: #707070;
            padding: 8px 20px;

        }

        .trip_item_body_more2.active {
            font-weight: bold;
        }


        .trip_item_body_more1.active {
            font-weight: bold;
        }

        .tripc_item_body_price span {
            color: #cc543a;
            font-weight: bold;
            font-size: 22px;
        }

        .tripc_item_body_price_mobile span {
            color: #cc543a;
            font-weight: bold;
            font-size: 18px;
        }

        .trip_select_area.collapsed i {
            transform: rotate(180deg);
            transition-property: transform;
        }

        .trip_select_area {
            color: #707070;
        }

        .trip_select_area i {
            color: #c0c0c0;
            font-weight: bold;
        }

        .trip_select_area a:hover {
            color: #707070;
            text-decoration: none;
            font-weight: bold;
        }

        .trip_price_txt {
            font-size: 24px;
            font-weight: bold;
            color: #707070;
        }

        .trip_price_txt_mobile {
            font-size: 20px;
            font-weight: bold;
            color: #707070;
        }
        .trip_price_mobile{
            margin: auto;
        }

        .trip_price_mobile .card {
            border-radius: 20px;
            background-color: #fff;
        }

        .trip_price_mobile .slider {
            width: 280px;
        }


        .trip_btn1 {
            background-color: #cc543a;
            border-radius: 50px;
            font-size: 18px;
            font-weight: bold;
            text-align: center;
            padding: 5px 15px;
            color: #fff;
            width: 40%;
        }

        .trip_btn1:hover {
            background-color: #dd745e;

        }

        #trip_price_range .slider-selection {
            background: #cc543a;
        }

        #trip_price_range .slider-handle {
            border: 5px solid #cc543a;
            background: #FFF;
        }

        #trip_price_range .arrow {
            display: none;
        }

        #trip_price_range .tooltip-inner {
            font-family: 'Sitka Display', NSimSun, 'sans-serif';
            font-size: 20px;
            padding: 0;
            color: #000;
            background-color: transparent;
        }


        .trip_page_item {
            color: #707070;
            font-size: 24px;
            background-color: transparent;
            padding: .5rem 1rem;
            border: 1px solid #cdcdcd;
        }

        .trip_page_item:hover,
        .trip_page_item.active {
            background-color: #c0c0c0;
            color: #FFF;
            font-weight: bold;
        }


        .trip_page_item1 {
            color: #707070;
            font-size: 24px;
            background-color: transparent;
            padding: .5rem 1rem;
            border: 1px solid #cdcdcd;
        }

        .trip_page_item1.active {
            background-color: #c0c0c0;
            color: #FFF;
            font-weight: bold;
        }


        .trip_item_image img {
            height: 100%;
        }

        .trip_like {
            width: 42px;
            height: 42px;
            border: 2px solid #cc543a;
            border-radius: 50%;
            top: 0;
            right: 0;
        }

        .trip_like i {
            font-size: 24px;
            color: #cc543a;
        }

        .trip_like .fas {
            font-size: 20px;
            color: #FFF;
        }


        .trip_like i:hover {
            font-weight: 900;
            font-size: 25px;
            color: #cc543a;

        }

        .trip_like.active {
            background-color: #cc543a;
        }

        .trip_like.active i {
            font-weight: 900;
            font-size: 23px;
            color: #FFF;
        }

        .trip_like_mobile {
            width: 32px;
            height: 32px;
            border: 2px solid #cc543a;
            border-radius: 50%;
            top: 0;
            right: 0;
            font-size: 18px;
            color: #cc543a;
        }

        .trip_like_mobile .fas {
            font-size: 18px;
            color: #FFF;
        }

        .trip_like_mobile.active {
            background-color: #cc543a;
        }


        .trip_like_mobile.active i {
            font-weight: 900;
            font-size: 16px;
            color: #FFF;
        }

        .trip_result{
            font-size: 18px;
            font-weight: bold;
            color:#707070;
            

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
    <div class="breadcrumb_style   backgroundimg_1">
        <div class="d-flex flex-wrap breadcrumb_style_1 ">
            <a href="" class="astlyep">首頁</a>
            <!-- 共用雲端找箭頭icon-->
            <img src="./img/nav_arrow_right.svg">
            聖地行旅
        </div>
    </div>
    <div class="container-fluid trip_body_bg">
        <!-- mobile -->
        <div class="container d-block d-lg-none">
            <div class="row px-3 d-flex justify-content-between">
                <select class="trip_item_body_more2 shadow mb-2 bg-white text-center <?=($cat_area||$cat)?'active':''?>" id="exampleFormControlSelect1">
                    <option>行程分類</option>
                    <optgroup label="選擇地區">
                        <option value="北區" <?=($cat_area=='北區')?'selected':''?>>北區</option>
                        <option value="中區" <?=($cat_area=='中區')?'selected':''?>>中區</option>
                        <option value="南區" <?=($cat_area=='南區')?'selected':''?>>南區</option>
                        <option value="東區" <?=($cat_area=='東區')?'selected':''?>>東區</option>
                        <option value="離島" <?=($cat_area=='離島')?'selected':''?>>離島</option>
                    </optgroup>
                    <option value="人氣推薦" <?=($cat=='人氣推薦')?'selected':''?>>人氣推薦</option>
                    <option value="熱門行程" <?=($cat=='熱門行程')?'selected':''?>>熱門行程</option>
                    <option value="最新活動" <?=($cat=='最新活動')?'selected':''?>>最新活動</option>
                </select>
                <div class="trip_item_body_more1 shadow mb-2 bg-white d-flex align-items-center justify-content-center"
                    data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false"
                    aria-controls="collapseExample">
                    價錢範圍
                </div>

            </div>
            <div class="row">
                <div class="collapse trip_price_mobile <?=isset($_GET['price'])?' show':''?>" id="collapseExample">
                    <div class="card card-body">
                        <ul>
                            <li class="py-1">
                                <div class="trip_price_txt_mobile">價錢範圍</div>
                                <div><input class="trip_price_range_mobile" id="ex8" data-slider-id='trip_price_range'
                                        type="text" data-slider-min="0" data-slider-max="10000" data-slider-step="500"
                                        data-slider-value="5000" />
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="d-block d-lg-none">
            <?php
if(count($trips) > 0) {
    foreach($trips as $trip) {
?>
                <div class="row trip_item_border d-flex no-gutters mt-4 mb-4 shadow bg-white rounded">
                    <div class="col-5 trip_item_image">
                        <img src="img/<?=$trip['thumbnail']?>" width="100%" />
                    </div>
                    <div class="col-7 trip_item_body_mobile">
                        <div class="trip_item_body_title_mobile mt-3 mx-3"><?=$trip['title2']?></div>
                        <div class="trip_item_body_body mx-3">
                            <div class="py-1"><i class="fas fa-map-marker-alt"></i><?=$trip['position']?></div>
                            <div class="py-1"><i class="far fa-clock"></i><?=$trip['days']?></div>
                            <div class="py-1"><i class="fas fa-quote-left"></i><?=$trip['title3']?></div>
                        </div>
                        <div class="tripc_item_body_price_mobile mx-3"><span>NTD <?=number_format($trip['price'],0,".",",")?></span> 元起</div>
                        <div class="mb-1 d-flex justify-content-end">
                            <div class="mr-3 my-2 trip_item_body_more_mobile">查看詳情</div>
                        </div>
                        <div
                            class="trip_like_mobile position-absolute d-flex justify-content-center align-items-center mr-2 mt-2">
                            <i class="far fa-heart"></i>
                        </div>
                    </div>
                </div>
<?php 
    }
} else {
?>
                <div class="text-center w-100">查無行程</div>
<?php
}
?>
                <!-- <div class="row trip_item_border d-flex no-gutters mb-4 shadow mb-4 bg-white rounded">
                    <div class="col-5 trip_item_image">
                        <img src="img/img01.png" width="100%" />
                    </div>
                    <div class="col-7 trip_item_body_mobile">
                        <div class="trip_item_body_title_mobile mt-3 mx-3">蒐集離島媽祖</div>
                        <div class="trip_item_body_body mx-3">
                            <div class="py-1"><i class="fas fa-map-marker-alt"></i>澎湖-蘭嶼-綠島</div>
                            <div class="py-1"><i class="far fa-clock"></i>4天3夜</div>
                            <div class="py-1"><i class="fas fa-quote-left"></i>是媽祖叫我去的！</div>
                        </div>
                        <div class="tripc_item_body_price_mobile mx-3"><span>NTD 3,250</span> 元起</div>
                        <div class="mb-1 d-flex justify-content-end">
                            <div class="mr-3 my-2 trip_item_body_more_mobile">查看詳情</div>
                        </div>
                        <div
                            class="trip_like_mobile position-absolute d-flex justify-content-center align-items-center mr-2 mt-2">
                            <i class="far fa-heart"></i>
                        </div>
                    </div>
                </div>
                <div class="row trip_item_border d-flex no-gutters mb-4 shadow mb-4 bg-white rounded">
                    <div class="col-5 trip_item_image">
                        <img src="img/img01.png" width="100%" />
                    </div>
                    <div class="col-7 trip_item_body_mobile">
                        <div class="trip_item_body_title_mobile mt-3 mx-3">蒐集離島媽祖</div>
                        <div class="trip_item_body_body mx-3">
                            <div class="py-1"><i class="fas fa-map-marker-alt"></i>澎湖-蘭嶼-綠島</div>
                            <div class="py-1"><i class="far fa-clock"></i>4天3夜</div>
                            <div class="py-1"><i class="fas fa-quote-left"></i>是媽祖叫我去的！</div>
                        </div>
                        <div class="tripc_item_body_price_mobile mx-3"><span>NTD 3,250</span> 元起</div>
                        <div class="mb-1 d-flex justify-content-end">
                            <div class="mr-3 my-2 trip_item_body_more_mobile">查看詳情</div>
                        </div>
                        <div
                            class="trip_like_mobile position-absolute d-flex justify-content-center align-items-center mr-2 mt-2">
                            <i class="far fa-heart"></i>
                        </div>
                    </div>
                </div>
                <div class="row trip_item_border d-flex no-gutters mb-4 shadow mb-4 bg-white rounded">
                    <div class="col-5 trip_item_image">
                        <img src="img/img01.png" width="100%" />
                    </div>
                    <div class="col-7 trip_item_body_mobile">
                        <div class="trip_item_body_title_mobile mt-3 mx-3">蒐集離島媽祖</div>
                        <div class="trip_item_body_body mx-3">
                            <div class="py-1"><i class="fas fa-map-marker-alt"></i>澎湖-蘭嶼-綠島</div>
                            <div class="py-1"><i class="far fa-clock"></i>4天3夜</div>
                            <div class="py-1"><i class="fas fa-quote-left"></i>是媽祖叫我去的！</div>
                        </div>
                        <div class="tripc_item_body_price_mobile mx-3"><span>NTD 3,250</span> 元起</div>
                        <div class="mb-1 d-flex justify-content-end">
                            <div class="mr-3 my-2 trip_item_body_more_mobile">查看詳情</div>
                        </div>
                        <div
                            class="trip_like_mobile position-absolute d-flex justify-content-center align-items-center mr-2 mt-2">
                            <i class="far fa-heart"></i>
                        </div>
                    </div>
                </div>
                <div class="row trip_item_border d-flex no-gutters mb-4 shadow mb-4 bg-white rounded">
                    <div class="col-5 trip_item_image">
                        <img src="img/img01.png" width="100%" />
                    </div>
                    <div class="col-7 trip_item_body_mobile">
                        <div class="trip_item_body_title_mobile mt-3 mx-3">蒐集離島媽祖</div>
                        <div class="trip_item_body_body mx-3">
                            <div class="py-1"><i class="fas fa-map-marker-alt"></i>澎湖-蘭嶼-綠島</div>
                            <div class="py-1"><i class="far fa-clock"></i>4天3夜</div>
                            <div class="py-1"><i class="fas fa-quote-left"></i>是媽祖叫我去的！</div>
                        </div>
                        <div class="tripc_item_body_price_mobile mx-3"><span>NTD 3,250</span> 元起</div>
                        <div class="mb-1 d-flex justify-content-end">
                            <div class="mr-3 my-2 trip_item_body_more_mobile">查看詳情</div>
                        </div>
                        <div
                            class="trip_like_mobile position-absolute d-flex justify-content-center align-items-center mr-2 mt-2">
                            <i class="far fa-heart"></i>
                        </div>
                    </div>
                </div>
                <div class="row trip_item_border d-flex no-gutters mb-4 shadow mb-4 bg-white rounded">
                    <div class="col-5 trip_item_image">
                        <img src="img/img01.png" width="100%" />
                    </div>
                    <div class="col-7 trip_item_body_mobile">
                        <div class="trip_item_body_title_mobile mt-3 mx-3">蒐集離島媽祖</div>
                        <div class="trip_item_body_body mx-3">
                            <div class="py-1"><i class="fas fa-map-marker-alt"></i>澎湖-蘭嶼-綠島</div>
                            <div class="py-1"><i class="far fa-clock"></i>4天3夜</div>
                            <div class="py-1"><i class="fas fa-quote-left"></i>是媽祖叫我去的！</div>
                        </div>
                        <div class="tripc_item_body_price_mobile mx-3"><span>NTD 3,250</span> 元起</div>
                        <div class="mb-1 d-flex justify-content-end">
                            <div class="mr-3 my-2 trip_item_body_more_mobile">查看詳情</div>
                        </div>
                        <div
                            class="trip_like_mobile position-absolute d-flex justify-content-center align-items-center mr-2 mt-2">
                            <i class="far fa-heart"></i>
                        </div>
                    </div>
                </div>
                <div class="row trip_item_border d-flex no-gutters mb-4 shadow mb-4 bg-white rounded">
                    <div class="col-5 trip_item_image">
                        <img src="img/img01.png" width="100%" />
                    </div>
                    <div class="col-7 trip_item_body_mobile">
                        <div class="trip_item_body_title_mobile mt-3 mx-3">蒐集離島媽祖</div>
                        <div class="trip_item_body_body mx-3">
                            <div class="py-1"><i class="fas fa-map-marker-alt"></i>澎湖-蘭嶼-綠島</div>
                            <div class="py-1"><i class="far fa-clock"></i>4天3夜</div>
                            <div class="py-1"><i class="fas fa-quote-left"></i>是媽祖叫我去的！</div>
                        </div>
                        <div class="tripc_item_body_price_mobile mx-3"><span>NTD 3,250</span> 元起</div>
                        <div class="mb-1 d-flex justify-content-end">
                            <div class="mr-3 my-2 trip_item_body_more_mobile">查看詳情</div>
                        </div>
                        <div
                            class="trip_like_mobile position-absolute d-flex justify-content-center align-items-center mr-2 mt-2">
                            <i class="far fa-heart"></i>
                        </div>
                    </div>
                </div>
                <div class="row trip_item_border d-flex no-gutters mb-4 shadow mb-4 bg-white rounded">
                    <div class="col-5 trip_item_image">
                        <img src="img/img01.png" width="100%" />
                    </div>
                    <div class="col-7 trip_item_body_mobile">
                        <div class="trip_item_body_title_mobile mt-3 mx-3">蒐集離島媽祖</div>
                        <div class="trip_item_body_body mx-3">
                            <div class="py-1"><i class="fas fa-map-marker-alt"></i>澎湖-蘭嶼-綠島</div>
                            <div class="py-1"><i class="far fa-clock"></i>4天3夜</div>
                            <div class="py-1"><i class="fas fa-quote-left"></i>是媽祖叫我去的！</div>
                        </div>
                        <div class="tripc_item_body_price_mobile mx-3"><span>NTD 3,250</span> 元起</div>
                        <div class="mb-1 d-flex justify-content-end">
                            <div class="mr-3 my-2 trip_item_body_more_mobile">查看詳情</div>
                        </div>
                        <div
                            class="trip_like_mobile position-absolute d-flex justify-content-center align-items-center mr-2 mt-2">
                            <i class="far fa-heart"></i>
                        </div>
                    </div>
                </div> -->
            </div>
            <nav class="trip_page position-relative d-flex justify-content-end" aria-label="Page navigation example">
                <ul class="pagination ">
                <?php
                for($i=1;$i<=$total_pages;$i++) {
                ?>
                    <li class="page-item"><a class="page-link trip_page_item1 <?=($page==$i)?'active':''?>"href="<?=getPageLink($i)?>"><?=$i?></a></li>
                <?php
                }
                ?>    
                    <!-- <li class="page-item"><a class="page-link trip_page_item1" href="#">1</a></li>
                    <li class="page-item"><a class="page-link trip_page_item1" href="#">2</a></li>
                    <li class="page-item"><a class="page-link trip_page_item1" href="#">3</a></li>
                    <li class="page-item"><a class="page-link trip_page_item1" href="#">4</a></li>
                    <li class="page-item"><a class="page-link trip_page_item1" href="#">></a></li> -->
                </ul>
            </nav>
        </div>

        <!-- 網頁 -->
        <div class="trip_container container-fluid px-lg-5 d-none d-lg-block ">
            <div class="row">
                <div class="col-3">
                    <div style="max-width:210px;">
                        <div class="trip_search position-relative mb-5">
                            <input type="text" class="form-control border-0 bg-transparent px-1"
                                id="keyword" placeholder="找行程..">
                            <i class="fa fa-search fa-lg"></i>
                        </div>
                        <div class="d-none">
                            <div class="rounded-circle"><i class="far fa-heart rounded-circle p-2"
                                    style="background-color: #FFF; color:red;"></i></div>
                        </div>
                        <div class="trip_category">
                            <h3 class="py-2">行程分類 |</h3>
                            <ul>
                                <li class="py-1"><a class="trip_select_area collapsed" data-toggle="collapse"
                                        href="#collapseExample" aria-expanded="false"
                                        aria-controls="collapseExample">選擇地區
                                        <i class="fas fa-chevron-up"></i></a>
                                    <div class="collapse p-1 px-3<?=isset($_GET['cat_area'])?' show':''?>" id="collapseExample">
                                        <ul>
                                            <li><a <?=(isset($_GET['cat_area']) && $_GET['cat_area'] == "北區")?"class='active'":""?> href="trip.php?cat_area=北區">北區</a></li>
                                            <li><a <?=(isset($_GET['cat_area']) && $_GET['cat_area'] == "中區")?"class='active'":""?> href="trip.php?cat_area=中區">中區</a></li>
                                            <li><a <?=(isset($_GET['cat_area']) && $_GET['cat_area'] =="南區")?"class='active'":""?> href="trip.php?cat_area=南區">南區</a></li>
                                            <li><a <?=(isset($_GET['cat_area']) && $_GET['cat_area'] =="東區")?"class='active'":""?> href="trip.php?cat_area=東區">東區</a></li>
                                            <li><a <?=(isset($_GET['cat_area']) && $_GET['cat_area'] =="離島")?"class='active'":""?> href="trip.php?cat_area=離島">離島</a></li>
                                        </ul>
                                    </div>
                                </li>
                                <li class="py-1"><a <?=(isset($_GET['cat']) && $_GET['cat'] == '人氣推薦')?'class="active"':''?> href="trip.php?cat=人氣推薦">人氣推薦</a></li>
                                <li class="py-1"><a <?=(isset($_GET['cat']) && $_GET['cat'] =='熱門行程')?'class="active"':''?> href="trip.php?cat=熱門行程">熱門行程</a></li>
                                <li class="py-1"><a <?=(isset($_GET['cat']) && $_GET['cat'] =='最新活動')?'class="active"':''?> href="trip.php?cat=最新活動">最新活動</a></li>
                            </ul>
                            <ul>
                                <li class="py-1">
                                    <div class="trip_price_txt">價錢範圍 |</div>
                                    <div><input class="trip_price_range" id="ex8" data-slider-id='trip_price_range'
                                            type="text" data-slider-min="0" data-slider-max="10000"
                                            data-slider-step="500" data-slider-value="5000" /></div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-9">
                    <div class="trip_sort d-flex justify-content-end mb-5">
                        <div class="form-inline">
                            <label class="pr-3" for="exampleFormControlSelect1">排序方式</label>
                            <select class="form-control bg-transparent" id="trip_order">
                                <option value="hot" <?=($trip_order=='hot')?'selected':''?>>熱門行程</option>
                                <option value="rate" <?=($trip_order=='rate')?'selected':''?>>評價最高</option>
                                <option value="created_at" <?=($trip_order=='created_at')?'selected':''?>>最新活動</option>
                                <option value="price" <?=($trip_order=='price')?'selected':''?>>價格(從低到高)</option>
                            </select>
                        </div>
                    </div>
                    <div class="row trip_product_list" data-aos="fade-up" data-aos-duration="2000">
<?php
if(count($trips) > 0) {
    foreach($trips as $trip) {
?>
                        <div class="col-lg-6 mb-4">
                            <div class="trip_item_border d-flex no-gutters">
                                <div class="col-5 trip_item_image">
                                    <img src="img/<?=$trip['thumbnail']?>" width="100%" />
                                </div>
                                <div class="col-7 trip_item_body py-1 position-relative">
                                    <div class="trip_item_body_title mt-3 mb-2 mx-4"><?=$trip['title2']?></div>
                                    <div class="trip_item_body_body mx-4">
                                        <div class="py-1"><i class="fas fa-map-marker-alt"></i><?=$trip['position']?></div>
                                        <div class="py-1"><i class="far fa-clock"></i><?=$trip['days']?></div>
                                        <div class="py-1"><i class="fas fa-quote-left"></i><?=$trip['title3']?></div>
                                    </div>
                                    <div class="tripc_item_body_price mx-4 pt-1"><span>NTD <?=number_format($trip['price'], 0, ".", ",")?></span> 元起</div>

                                    <div class="d-lg-flex justify-content-end">
                                        <div class="trip_btn1 mr-3 mt-1">查看詳情</div>
                                    </div>
                                    <div
                                        class="trip_like position-absolute d-flex justify-content-center align-items-center mr-2 mt-2">
                                        <i class="far fa-heart"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
<?php 
    }
} else {
?>
<div class="trip_result text-center w-100">不好意思，我們沒有找到相關的行程</div>
<?php
}
?>
                    </div>

                </div>
            </div>
            <nav class="trip_page position-relative d-flex justify-content-end" aria-label="Page navigation example">
                <ul class="pagination ">
                <?php
                for($i=1;$i<=$total_pages;$i++) {
                ?>
                    <li class="page-item"><a class="page-link trip_page_item <?=($page==$i)?'active':''?>" href="<?=getPageLink($i)?>"><?=$i?></a></li>
                <?php
                }
                ?>
                    <!-- <li class="page-item"><a class="page-link trip_page_item active" href="#">1</a></li>
                    <li class="page-item"><a class="page-link trip_page_item" href="#">2</a></li>
                    <li class="page-item"><a class="page-link trip_page_item" href="#">3</a></li>
                    <li class="page-item"><a class="page-link trip_page_item" href="#">4</a></li>
                    <li class="page-item"><a class="page-link trip_page_item" href="#">></a></li> -->
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
        // With JQuery
        var urlParams = new URLSearchParams(window.location.search);
        $(".trip_price_range").slider({
            tooltip: 'always',
            tooltip_position: 'bottom',
        }).slider('setValue', urlParams.get('price')?urlParams.get('price'):5000).on('slideStop', function(){
            location.href="trip.php?price=" + $(this).val();
        });
        $(".trip_price_range_mobile").slider({
            tooltip: 'always',
            tooltip_position: 'bottom',
        }).slider('setValue', urlParams.get('price')?urlParams.get('price'):5000).on('slideStop', function(){
            location.href="trip.php?price=" + $(this).val();
        });

        $(".trip_like").click(function () {
            $(this).toggleClass('active');
        });

        $(".trip_like_mobile").click(function () {
            $(this).toggleClass('active');
        });
        $(".trip_item_body_more_mobile").click(function () {
            $(this).toggleClass('active');
        })
        $(".trip_item_body_more1").click(function () {
            $(this).toggleClass('active');
        })

        $(".trip_item_body_more2").change(function () {
            if ($(this).val() > 0) {
                $(this).addClass('active');
            } else {
                $(this).removeClass('active');
            }
            if ($(this).val() == "北區" || $(this).val() == "中區" || $(this).val() == "南區" || $(this).val() == "東區" || $(this).val() == "離島") {
                location.href="trip.php?cat_area=" + $(this).val()
            }

            if ($(this).val() == "人氣推薦" || $(this).val()=="熱門行程" || 
            $(this).val()=="最新活動")
            {
            location.href="trip.php?cat=" + $(this).val()
            }
        })

        $(".trip_search i").click(function(){
            location.href="trip.php?keyword=" + $('#keyword').val();
        })

        $('#keyword').val(urlParams.get('keyword'));

        $('#trip_order').change(function(){
            urlParams.delete("page");
            urlParams.set("o", $(this).val());
            location.href="trip.php?" + urlParams.toString();
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