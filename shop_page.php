<?php
session_start();
var_dump($_SESSION);
require __DIR__ . "/__connect_db.php";

// SELECT * FROM trip WHERE id = ''
$sql = "SELECT * FROM shops WHERE id = '".$_GET['id']."'"; //組合SQL指令
$stmt = $pdo->prepare($sql); //預處理SQL
$stmt->execute(); //執行SQL
$shop = $stmt->fetch(PDO::FETCH_ASSOC); //取資料

$sql = "SELECT * FROM shops WHERE cat2 = '熱門商品' LIMIT 0, 6";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$hot_shops = $stmt->fetchAll(PDO::FETCH_ASSOC); // 手機熱門行程陣列

$pc_hot_shops = []; // PC熱門行程陣列
$j = 0; // 目前是第幾組
for($i=0;$i<count($hot_shops);$i++) {
    $pc_hot_shops[$j][] = $hot_shops[$i];
    if( ($i+1) % 4 == 0) {
        $j++;
    }
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
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-touchspin/4.3.0/jquery.bootstrap-touchspin.min.css"
        integrity="sha512-0GlDFjxPsBIRh0ZGa2IMkNT54XGNaGqeJQLtMAw6EMEDQJ0WqpnU6COVA91cUS0CeVA5HtfBfzS9rlJR3bPMyw=="
        crossorigin="anonymous" />
    <link rel="stylesheet" href="./css/nav_footer.css">
    <link rel="stylesheet" href="./css/nav2.css">
    <link rel="stylesheet" href="./css/breadcrumb.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link
        href="https://fonts.googleapis.com/css2?family=Faustina:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="./css/mybtn.css">
    <style>
        body {
            font-family: 'Faustina', serif;
            background-image: url(./img/bcc.png);
            font-size: 16px;
        }

        h3 {
            font-size: 26px;
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

        .shop_title_img img {
            border-radius: 5px;
        }

        .shop_title_img .shop_imghover img:hover {
            transform: scale(1.1, 1.1);

        }

        .shop_like_mobile {
            width: 32px;
            height: 32px;
            border: 2px solid #cc543a;
            border-radius: 50%;
            top: 15px;
            right: 15px;
            font-size: 18px;
            color: #cc543a;
            background-color: #fff;
        }

        .shop_like_mobile .fas {
            font-size: 18px;
            color: #FFF;
        }

        .shop_like_mobile.active {
            background-color: #cc543a;
        }


        .shop_like_mobile.active i {
            font-weight: 900;
            font-size: 16px;
            color: #FFF;
        }

        .shop_like_mobile.active {
            background-color: #cc543a;
        }


        .shop_like_mobile.active i {
            font-weight: 900;
            font-size: 16px;
            color: #FFF;
        }

        .breadcrumb-item {
            font-size: 18px;

        }

        .breadcrumb-item a {
            color: #707070;
        }

        .shop_btn {
            color: #cc543a;
            border: 1px solid #cc543a;
            font-weight: bold;
            border-radius: 50px;
            font-size: 18px;
            padding: 5px 15px;

        }

        .shop_btn.active,
        .shop_btn:hover {
            background-color: #cc543a;
            color: #fff;

        }



        .shop_text {
            color: #707070;
            font-size: 18px;
            line-height: 2;
        }

        .shop_text1 {
            font-size: 20px;
            color: #cc543a;
            font-weight: bold;
            text-decoration: underline;

        }

        .shop_text2 {
            font-size: 22px;
            font-weight: bold;
            color: #cc543a;
        }

        .shop_text3 {
            color: #707070;
            font-size: 18px;
            font-weight: bold;

        }

        .shop_title {
            font-size: 22px;
            font-weight: bold;
            color: #707070;


        }

        .shop_title li {
            font-size: 20px;
            font-weight: bold;
            line-height: 2;
        }

        .shop_title div {
            font-size: 18px;
            font-weight: normal;
            line-height: 1.8;
        }


        .shop_input_qty {
            width: 140px;
            font-size: 26px;
        }


        .shop_input_qty .form-control {
            background: transparent;
            text-align: center;
            border: none;
            font-weight: bold;
            font-size: 18px;
            color: #707070;
        }

        .shop_input_qty .input-group {
            background-color: #fff;
            border: 1px solid #C1C1C1;
            border-radius: 5px;
        }

        .shop_re_text {
            font-size: 22px;
        }

        .shop_re_img {
            position: relative;
            border-radius: 5px;
            overflow: hidden;
        }

        .shop_fixed_bottom {
            background-color: #CC543A;
            color: #fff;
            text-align: center;
            font-size: 18px;
            font-weight: bold;

        }


        .shop_fixed_bottom1 {
            width: 50%;

        }

        .shop_fixed_bottom1 span {
            display: none;
}

        .shop_fixed_bottom1.active span {
            display: inline;
}

        .shop_fixed_bottom_line {
            width: 1px;
            background-color: #fff;

        }

        .shop_re_more {
            display: none;
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

        .shop_re_more div {
            color: #fff;
            border-bottom: 1px solid #AFAFAF;
            width: 60%;
            text-align: center;
        }

        .shop_scrolling_wrapper .shop_re_img:hover img {
            transform: scale(1.1, 1.1);
        }

        #carouselHotControls i {
            font-size: 20px;
            color: #707070;
        }

        .carousel-control-prev {
            left: -110px;
        }

        .carousel-control-next {
            right: -110px;
        }

        #carouselExampleIndicators li {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            /* background-color: #c0c0c0; */

        }

        @media (min-width: 992px) {
            .shop_container {
                width: 1400px;
            }
        }

        @media (max-width: 991px) {
            h3 {
                font-size: 24px;
            }


            .shop_title li {
                font-size: 18px;
                line-height: 2;
            }

            .shop_title div {
                font-size: 16px;
                line-height: 2;
            }

            .shop_re_text {
                font-size: 18px;
            }

            .shop_scrolling_wrapper {
                overflow-x: auto;
            }

            footer {
                display: none;
            }

        }
    </style>
</head>

<body>
<input type="hidden" name="shop_price" id="shop_price" value="<?=$shop['price']?>">
    <input type="hidden" name="shop_id" id="shop_id" value="<?=$shop['id']?>">
    <input type="hidden" name="shop_name" id="shop_name" value="<?=$shop['title1']?>">
    <input type="hidden" name="shop_name1" id="shop_name1" value="<?=$shop['contents']?>">
    <input type="hidden" name="shop_image" id="shop_image" value="<?=$shop['img1']?>">

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
            <a href="" class="astlyep">Home</a>
            <!-- 共用雲端找箭頭icon-->
            <img src="./img/nav_arrow_right.svg">
            祈福商店
            <img src="./img/nav_arrow_right.svg">
            <a href="" class="astlyep">聯名合作</a>

        </div>
    </div>
    <div class="shop_container container-fluid px-lg-5 ">
        <div class="row">
            <div id="carouselExampleIndicators" class="carousel slide d-lg-none" data-ride="carousel">
                <ol class="carousel-indicators">
                    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                    <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                </ol>
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img class="d-block w-100" src="img/<?=$shop['img2']?>" alt="First slide">
                    </div>
                    <div class="carousel-item">
                        <img class="d-block w-100" src="img/<?=$shop['img3']?>" alt="Second slide">
                    </div>
                    <div class="carousel-item">
                        <img class="d-block w-100" src="img/<?=$shop['img4']?>" alt="Third slide">
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-7 shop_title_img  d-lg-flex pl-0 d-none">
                <div class="col-3 shop_imghover row justify-content-between no-gutters">
                    <div class="col-12"><img src="img/<?=$shop['img2']?>" width="100%"></div>
                    <div class="col-12 d-flex align-items-center"><img src="img/<?=$shop['img3']?>" width="100%"></div>
                    <div class="col-12 d-flex align-items-end"><img src="img/<?=$shop['img4']?>" width="100%"></div>
                </div>
                <div class="col-9 pl-2 ">
                    <div><img id="shop_imgclick" src="img/<?=$shop['img2']?>" width="100%"></div>
                </div>
            </div>
            <div class="col-lg-5">
                <div
                    class="shop_like_mobile position-absolute d-flex justify-content-center align-items-center d-lg-none">
                    <i class="far fa-heart"></i>
                </div>
                <h3 class="shop_titletext mt-lg-0 mt-4"><?=$shop['title1']?></h3>
                <h3 class="shop_titletext pt-2"><?=$shop['title2']?></h3>
                <div class="shop_text1 py-4"><?=$shop['cat2']?></div>
                <div class=" shop_text pb-5"><?=$shop['summary']?>
                </div>
                <div class="d-flex d-lg-block justify-content-between">
                    <div class="shop_text2  py-lg-2">NTD <?=number_format($shop['price'],0,".",",")?>元 </div>
                    <div class=" d-flex justify-content-start align-items-center">
                        <div class="shop_text3 px-3 py-lg-4 px-lg-0">數量</div>
                        <div class="shop_input_qty pb-2 pb-lg-2 pl-lg-4">
                            <input style="background-color: #fff;" id="shop_qty" type="text" value="" name="demo3">
                        </div>
                    </div>
                </div>
                <div class="shop_fixed_bottom w-100 d-flex justify-content-between py-2 px-2 fixed-bottom d-lg-none ">
                    <div class="shop_fixed_bottom1 py-2"><i class="fas fa-shopping-cart px-2"
                            style="color: #fff;"></i><span>已</span>加入購物車
                    </div>
                    <div class="shop_fixed_bottom_line"></div>
                    <div class="shop_fixed_bottom1 py-2">前往結帳</div>
                </div>
                <div class="d-none d-lg-flex justify-content-end pt-3 ">
                    <div class="mybtn_like mr-3" data-toggle="mybtn"></div>
                    <div class="mybtn_cart_add" data-toggle="mybtn"></div>
                </div>
            </div>
        </div>
        <div class="row pt-lg-5 pt-2 px-lg-0">
            <div class="shop_title col-lg-7 col-12 pt-5 pt-lg-0 ">Features / 商品特色
                <div class="pt-4"><?=$shop['feature']?>
                </div>
            </div>
            <ul class="shop_title col-lg-5  col-12 pt-5 pt-lg-0">Description / 商品描述
                <li class="pt-4">內容物 |</li>
                <div class="pb-2"><?=$shop['contents']?></div>
                <li>尺寸 |</li>
                <div class="pb-2"><?=$shop['size']?></div>
                <li>材質 |</li>
                <div class="pb-2">
                    <?=$shop['material']?>
                </div>
                <li>產地 |</li>
                <div><?=$shop['origin']?></div>
            </ul>

        </div>
        <div class="row">
            <div class="shop_title pt-5 col-lg-12 mx-lg-0 ">Related Product / 相關商品</div>
        </div>
        <div class="row pt-5 pb-5 shop_scrolling_wrapper flex-nowrap flex-row d-flex-block d-lg-none">
<?php
    foreach($hot_shops as $shop_item) {
?>
            <div class="col-lg-3 col-5 mb-5">
                <div class="shop_re_img mb-2">
                    <img src="img/<?=$shop_item['img1']?>" width="100%" />
                    <a href="shop_page.php?id=<?=$shop_item['id']?>"><div class="shop_re_more">
                    </div></a>
                </div>
                <div class="shop_re_text"><?=$shop_item['title1']?></div>
            </div>
            <?php
}
?>
            <!-- <div class="col-lg-3 col-5 mb-5">
                <div class="shop_re_img mb-2">
                    <img src="img/013.png" width="100%" />
                    <div class="shop_re_more">
                    </div>
                </div>
                <div class="shop_re_text">藝術廟宇戒指</div>
            </div>
            <div class="col-lg-3 col-5 mb-5">
                <div class="shop_re_img mb-2">
                    <img src="img/011.png" width="100%" />
                    <div class="shop_re_more">
                    </div>
                </div>
                <div class="shop_re_text">媽祖胸針 by </div>
            </div>
            <div class="col-lg-3 col-5 mb-5">
                <div class="shop_re_img mb-2">
                    <img src="img/013.png" width="100%" />
                    <div class="shop_re_more">
                    </div>
                </div>
                <div class="shop_re_text">藝術廟宇戒指</div>
            </div> -->
        </div>
        <div class="mb-5 mt-5 shop_scrolling_wrapper flex-nowrap flex-row d-none d-lg-block">
            <div id="carouselHotControls" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner container-fluid px-0 ">
<?php
foreach($pc_hot_shops as $key => $group) {
?>   
                 <div class="carousel-item <?=($key==0)?'active':''?>">
                        <div class="row">
<?php
    foreach($group as $shop_item) {
?>                  
                            <div class="col-lg-3">
                                <div class="shop_re_img mb-2">
                                    <img src="img/<?=$shop_item['img1']?>" width="100%" />
                                    <a href="shop_page.php?id=<?=$shop_item['id']?>"><div class="shop_re_more"></div></a>
                                </div>
                                <div class="shop_re_text pt-1"><?=$shop_item['title1']?></div>
                            </div>
<?php
    }
?>
                       </div>
                  </div>
<?php
}
?>

                            <!-- <div class="col-lg-3">
                                <div class="shop_re_img mb-2">
                                    <img src="img/013.png" width="100%" />
                                    <div class="shop_re_more">
                                    </div>
                                </div>
                                <div class="shop_re_text pt-1">藝術廟宇戒指</div>
                            </div>
                            <div class="col-lg-3">
                                <div class="shop_re_img mb-2">
                                    <img src="img/011.png" width="100%" />
                                    <div class="shop_re_more">
                                    </div>
                                </div>
                                <div class="shop_re_text pt-1">媽祖胸針 </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="shop_re_img mb-2">
                                    <img src="img/013.png" width="100%" />
                                    <div class="shop_re_more">
                                    </div>
                                </div>
                                <div class="shop_re_text pt-1">藝術廟宇戒指</div>
                            </div> -->
                    <!-- <div class="carousel-item">
                        <div class="row">
                            <div class="col-lg-3">
                                <div class="shop_re_img mb-2">
                                    <img src="img/011.png" width="100%" />
                                    <div class="shop_re_more">
                                    </div>
                                </div>
                                <div class="shop_re_text pt-1">媽祖胸針</div>
                            </div>
                            <div class="col-lg-3">
                                <div class="shop_re_img mb-2">
                                    <img src="img/013.png" width="100%" />
                                    <div class="shop_re_more">
                                    </div>
                                </div>
                                <div class="shop_re_text pt-1">藝術廟宇戒指</div>
                            </div>
                            <div class="col-lg-3">
                                <div class="shop_re_img mb-2">
                                    <img src="img/011.png" width="100%" />
                                    <div class="shop_re_more">
                                    </div>
                                </div>
                                <div class="shop_re_text pt-1">媽祖胸針 </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="shop_re_img mb-2">
                                    <img src="img/013.png" width="100%" />
                                    <div class="shop_re_more">
                                    </div>
                                </div>
                                <div class="shop_re_text pt-1">藝術廟宇戒指</div>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="row ">
                            <div class="col-lg-3">
                                <div class="shop_re_img mb-2">
                                    <img src="img/011.png" width="100%" />
                                    <div class="shop_re_more">
                                    </div>
                                </div>
                                <div class="shop_re_text pt-1">媽祖胸針 </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="shop_re_img mb-2">
                                    <img src="img/013.png" width="100%" />
                                    <div class="shop_re_more">
                                    </div>
                                </div>
                                <div class="shop_re_text pt-1">藝術廟宇戒指</div>
                            </div>
                            <div class="col-lg-3">
                                <div class="shop_re_img mb-2">
                                    <img src="img/011.png" width="100%" />
                                    <div class="shop_re_more">
                                    </div>
                                </div>
                                <div class="shop_re_text pt-1">媽祖胸針 </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="shop_re_img mb-2">
                                    <img src="img/013.png" width="100%" />
                                    <div class="shop_re_more">
                                    </div>
                                </div>
                                <div class="shop_re_text pt-1">藝術廟宇戒指</div>
                            </div>

                        </div>
                    </div> -->
                </div>
                <a class="carousel-control-prev" href="#carouselHotControls" role="button" data-slide="prev">
                    <i class="fas fa-chevron-left"></i>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselHotControls" role="button" data-slide="next">
                    <i class="fas fa-chevron-right"></i>
                    <span class="sr-only">Next</span>
                </a>
            </div>
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



    <script src="https://code.jquery.com/jquery-3.5.1.min.js"
        integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
        crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"
        integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k"
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/11.0.2/bootstrap-slider.min.js"
        integrity="sha512-f0VlzJbcEB6KiW8ZVtL+5HWPDyW1+nJEjguZ5IVnSQkvZbwBt2RfCBY0CBO1PsMAqxxrG4Di6TfsCPP3ZRwKpA=="
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-touchspin/4.3.0/jquery.bootstrap-touchspin.min.js"
        integrity="sha512-0hFHNPMD0WpvGGNbOaTXP0pTO9NkUeVSqW5uFG2f5F9nKyDuHE3T4xnfKhAhnAZWZIO/gBLacwVvxxq0HuZNqw=="
        crossorigin="anonymous"></script>

    <script>
        $("input[name='demo3']").TouchSpin({
            initval: 1,
            min: 1,
            max: 99,
            step: 1,
            decimals: 0,
            buttondown_class: 'btn btn-default',
            buttonup_class: 'btn btn-default'
        });

        $(".shop_title_img .shop_imghover img").click(function () {
            $("#shop_imgclick").attr("src", $(this).attr("src"))


        });

        $(".shop_btn").click(function () {
            $(this).toggleClass("active");
        });

        $(".shop_like_mobile").click(function () {
            $(this).toggleClass("active");
        });
        

        // 加入購物車_PC
        $('.mybtn_cart_add').click(function(){
            if($(this).hasClass('active')) {
                return;
            }
            var btn = this;

            $.ajax({
                type: "POST",
                url: 'shop_add.php',
                data: {
                    id: $('#shop_id').val(),
                    name: $('#shop_name').val(),
                    name1: $('#shop_name1').val(),
                    image: $('#shop_image').val(),
                    qty: $('#shop_qty').val(),
                    price: $('#shop_price').val(),
                },
                success: function(data){
                    if(data.code == 200) {
                        $(btn).toggleClass("active");
                    }
                },
                dataType: 'json'
            });
        });

        // 加入購物車_mobile
        $('.shop_fixed_bottom1').click(function(){
            if($(this).hasClass('active')) {
                return;
            }
            var btn = this;


            $.ajax({
                type: "POST",
                url: 'shop_add.php',
                data: {
                    id: $('#shop_id').val(),
                    name: $('#shop_name').val(),
                    name1: $('#shop_name1').val(),
                    image: $('#shop_image').val(),
                    qty: $('#shop_qty').val(),
                    price: $('#shop_price').val(),
                },
                success: function(data){
                    if(data.code == 200) {
                        $(btn).toggleClass("active");
                    }
                },
                dataType: 'json'
            });
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

    </script>


</body>

</html>