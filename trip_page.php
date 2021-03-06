<?php
session_start();
// var_dump($_SESSION);
require __DIR__ . "/__connect_db.php";

// SELECT * FROM trip WHERE id = ''
$sql = "SELECT * FROM trips WHERE id = '".$_GET['id']."'"; //組合SQL指令
$stmt = $pdo->prepare($sql); //預處理SQL
$stmt->execute(); //執行SQL
$trip = $stmt->fetch(PDO::FETCH_ASSOC); //取資料


$sql = "SELECT * FROM trips WHERE cat = '熱門行程' LIMIT 0, 6";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$hot_trips = $stmt->fetchAll(PDO::FETCH_ASSOC); // 手機熱門行程陣列


$pc_hot_trips = []; // PC熱門行程陣列
$j = 0; // 目前是第幾組
for($i=0;$i<count($hot_trips);$i++) {
    $pc_hot_trips[$j][] = $hot_trips[$i];
    if( ($i+1) % 2 == 0) {
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
    <link rel="stylesheet" href="./css/nav_footer.css">
    <link rel="stylesheet" href="./css/nav2.css">
    <link rel="stylesheet" href="./css/breadcrumb.css">

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link
        href="https://fonts.googleapis.com/css2?family=Faustina:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="./css/trip_page.css">
    <link rel="stylesheet" href="./css/mybtn.css">

</head>

<body>
    <input type="hidden" name="price" id="trip_price" value="<?=$trip['price']?>">
    <input type="hidden" name="trip_id" id="trip_id" value="<?=$trip['id']?>">
    <input type="hidden" name="trip_name" id="trip_name" value="<?=$trip['title2']?>">
    <input type="hidden" name="trip_image" id="trip_image" value="<?=$trip['thumbnail']?>">
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
            <a href="" class="astlyep">聖地行旅</a>
            <img src="./img/nav_arrow_right.svg">
            <a href="" class="astlyep">熱門行程</a>
            <img src="./img/nav_arrow_right.svg">
            台南...
        </div>
    </div>
    <div class="trip_container container-fluid px-lg-5">
        <div class="row">
            <div id="carouselExampleIndicators" class="carousel slide d-lg-none" data-ride="carousel">
                <ol class="carousel-indicators">
                    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                    <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                </ol>
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img class="d-block w-100" src="img/<?=$trip['photo1']?>" alt="First slide">
                    </div>
                    <div class="carousel-item">
                        <img class="d-block w-100" src="img/<?=$trip['photo2']?>" alt="Second slide">
                    </div>
                    <div class="carousel-item">
                        <img class="d-block w-100" src="img/<?=$trip['photo3']?>" alt="Third slide">
                    </div>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="trip_title_img col-lg-7 d-lg-flex pl-0 d-none">
                <div class="col-lg-3 row trip_imghover justify-content-between no-gutters">
                    <div class="col-12"><img src="img/<?=$trip['photo1']?>" width="100%"></div>
                    <div class="col-12 d-flex align-items-center"><img src="img/<?=$trip['photo2']?>" width="100%">
                    </div>
                    <div class="col-12 d-flex align-items-end"><img src="img/<?=$trip['photo3']?>" width="100%"></div>
                </div>
                <div class="col-9 pl-2">
                    <div><img id="trip_imgclick" src="img/<?=$trip['photo1']?>" width="100%"></div>
                </div>
            </div>

            <div class="col-lg-5 col-12">
                <div
                    class="trip_like_mobile position-absolute d-flex justify-content-center align-items-center d-lg-none">
                    <i class="far fa-heart"></i>
                </div>
                <h3 class="mt-4 mt-lg-3"><?=$trip['title2']?></h3>
                <div>
                    <h3 class="pb-2 trip_title_text"><?=$trip['title1']?></h3>
                    <!-- mobile -->
                    <div class="d-block d-lg-none">
                        <div class="mb-3">
                            <hr>
                            <div class="row  no-gutters pt-3">
                                <div class="col-6 trip_text1">查看可預訂日期</div>
                                <div class="col-6">
                                    <input class="trip_input_date w-100" type="date" id="date_today" min="2021-04-19">
                                    <div class="invalid-feedback">造訪日期未填喔!!</div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between py-4">
                                <div class="mb-0 trip_solution_choice ">方案選擇</div>
                                <div id="trip_solution_checkbox" class="d-flex trip_solution_checkbox">
                                    <div class="trip_btn_mobile mr-4 active" data-price="0">導覽</div>
                                    <div class="trip_btn_mobile mr-4" data-price="500">餐飲</div>
                                    <div class="trip_btn_mobile " data-price="1000">住宿</div>
                                </div>
                            </div>
                            <div class="row pb-4 pl-4">
                                <div class="col-3 text-right trip_text1">價格</div>
                                <div class="col-9 trip_text1">NTD <span id="trip_amount"><?=number_format($trip['price'],0,".",",")?></span>元起</div>
                            </div>
                            <div class="row pb-4 pl-4">
                                <div class="col-3 text-right trip_text1">人數</div>
                                <div class="col-9">
                                    <div class="trip_input_qty"><input id="trip_qty" type="text" value="" name="demo3">
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row pt-2 pb-4 pl-4">
                                <div class="col-3 trip_text1 text-right ">小計</div>
                                <div class="col-9 trip_text">NTD <span id="trip_calculate"><?=number_format($trip['price'],0,".",",")?></span>元</div>
                            </div>
                            <div class="d-flex justify-content-end">
                                <div class="trip_price_detail d-flex align-items-center" data-toggle="modal"
                                    data-target=".trip-more-modal-lg">費用詳情<div class=""></div>
                                    <div class=""></div>
                                    <div class=""></div><i class="fas fa-chevron-down pl-1"
                                        style="font-size: 12px;"></i>
                                </div>
                            </div>

                            <hr>
                            <div class="col-12">
                                <h3 class="py-2">行程介紹 |</h3>
                                <div class="trip_list_text px-1 pb-5">
                                    <?=$trip['content']?>
                                </div>
                            </div>
                        </div>
                        <hr>

                    </div>
                </div>


                <!-- 網頁 -->
                <div class="d-none d-lg-block">
                    <div class="row">
                        <div class="trip_text pt-2 col-12">選擇方案及日期</div>
                    </div>
                    <div class="py-lg-3 d-none d-lg-flex row">
                        <div class="trip_text1 col-5">請選擇造訪日期</div>
                        <div class="col-7">
                            <input class="trip_input_date" type="date" id="date_today1" min="2021-04-19">
                            <div class="invalid-feedback">造訪日期未填喔!!</div>
                        </div>
                    </div>
                    <div class="py-lg-2 py-0 d-none d-lg-flex row">
                        <div class="trip_text1 col-5">人數</div>
                        <div class="col-7">
                            <div class="trip_input_qty"><input id="trip_qty1" type="text" value="" name="demo3">
                            </div>
                        </div>
                    </div>
                    <div class="py-lg-2 py-0 d-none d-lg-flex row">
                        <div class="trip_text1 col-5">價格</div>
                        <div class="col-7 trip_text1">NTD <span id="trip_amount1"><?=number_format($trip['price'],0,".",",")?></span> 元起</div>

                    </div>
                    <div class="py-lg-2 d-none d-lg-flex row">
                        <div class="trip_text1 col-lg-5 ">請選擇方案</div>
                        <div id="trip_solution_checkbox1" class="col-lg-7 d-flex">
                            <div class="trip_btn2 mr-2 active" data-price="0">導覽</div>
                            <div class="trip_btn2 mr-2" data-price="500">餐飲</div>
                            <div class="trip_btn2" data-price="1000">住宿</div>
                        </div>
                    </div>
                    <hr class="mt-2">
                    <div class="d-lg-flex justify-content-end pt-lg-1 d-none d-lg-block">
                        <div class="trip_price_detail pr-3 d-flex align-items-center" data-toggle="modal"
                            data-target=".trip-more-modal-lg">費用詳情<div class=""></div>
                            <div class=""></div>
                            <div class=""></div><i class="fas fa-chevron-down pl-1" style="font-size: 12px;"></i>
                        </div>
                        <div class="trip_text2">NTD <span id="trip_calculate1"><?=number_format($trip['price'],0,".",",")?></span>元</div>
                    </div>
                    <div class="d-none d-lg-flex justify-content-end pt-4">
                        <div class="mybtn_like mr-3" data-toggle="mybtn"></div>
                        <div class="mybtn_cart_add pr-3" data-toggle="mybtn"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row pt-4">
            <div class="col-lg-7 pt-lg-5 d-none d-lg-block">
                <div class="row">
                    <div class="col-12">
                        <h3 class="pb-4">行程介紹 |</h3>
                        <div class="trip_list_text">
                            <?=$trip['content']?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-5 pt-lg-5 pt-0 d-none d-lg-block">
                <h3 class="pb-4">評價 |</h3>
                <div class="pb-5 d-flex justify-content-between">
                    <div class="d-flex justify-content-start">
                        <div class="trip_text mr-4">4.8</div>
                        <div class="d-flex justify-content-start pr-3 pt-2 pl-0">
                            <div><i class="fas fa-star" style="color: #cc543a;"></i></div>
                            <div><i class="fas fa-star" style="color: #cc543a;"></i></div>
                            <div><i class="fas fa-star" style="color: #cc543a;"></i></div>
                            <div><i class="fas fa-star" style="color: #cc543a;"></i></div>
                            <div><i class="fas fa-star" style="color: #cc543a;"></i></div>
                        </div>
                        <div class="pt-2 ">62則評價</div>
                    </div>
                    <div class="trip_sort ">
                        <div class="form-inline">
                            <label class="pr-3" for="exampleFormControlSelect1"></label>
                            <select class="form-control bg-transparent" id="exampleFormControlSelect1">
                                <option>最新</option>
                                <option>評分:從高至低</option>
                                <option>評分:從低至高</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="trip_item_scroll d-none d-lg-block">
                    <div class="row">
                        <div class="col-2">
                            <div class="trip_gb">W</div>
                        </div>
                        <div class="col-10">
                            <div>
                                <div class="py-2">WAN CHEN</div>
                                <div class="d-flex justify-content-start pb-4">
                                    <div class="d-flex justify-content-start pr-3">
                                        <div><i class="fas fa-star" style="color: #cc543a;"></i></div>
                                        <div><i class="fas fa-star" style="color: #cc543a;"></i></div>
                                        <div><i class="fas fa-star" style="color: #cc543a;"></i></div>
                                        <div><i class="fas fa-star" style="color: #cc543a;"></i></div>
                                        <div><i class="fas fa-star" style="color: #cc543a;"></i></div>
                                    </div>
                                    <div>超讚</div>
                                </div>
                            </div>
                            <div class="trip_gbtext pb-5">先上林家宮保第官網預約導覽時間，再上KLOOK購買套票（導覽+古裝體驗），
                                建議可以挑不要太晚的導覽，因為導覽結束後還能好好再到處拍照，很好拍超
                                好拍照；古裝體驗，有很多服飾，</div>
                            <hr>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-2">
                            <div class="trip_gb">W</div>
                        </div>
                        <div class="col-10">
                            <div>
                                <div class="py-2">WAN CHEN</div>
                                <div class="d-flex justify-content-start pb-4">
                                    <div class="d-flex justify-content-start pr-3">
                                        <div><i class="fas fa-star" style="color: #cc543a;"></i></div>
                                        <div><i class="fas fa-star" style="color: #cc543a;"></i></div>
                                        <div><i class="fas fa-star" style="color: #cc543a;"></i></div>
                                        <div><i class="fas fa-star" style="color: #cc543a;"></i></div>
                                        <div><i class="fas fa-star" style="color: #cc543a;"></i></div>
                                    </div>
                                    <div>超讚</div>
                                </div>
                            </div>
                            <div class="trip_gbtext pb-5">先上林家宮保第官網預約導覽時間，再上KLOOK購買套票（導覽+古裝體驗），
                                建議可以挑不要太晚的導覽，因為導覽結束後還能好好再到處拍照，很好拍超
                                好拍照；古裝體驗，有很多服飾，</div>
                            <hr>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-2">
                            <div class="trip_gb">W</div>
                        </div>
                        <div class="col-10">
                            <div>
                                <div class="py-2">WAN CHEN</div>
                                <div class="d-flex justify-content-start pb-4">
                                    <div class="d-flex justify-content-start pr-3">
                                        <div><i class="fas fa-star" style="color: #cc543a;"></i></div>
                                        <div><i class="fas fa-star" style="color: #cc543a;"></i></div>
                                        <div><i class="fas fa-star" style="color: #cc543a;"></i></div>
                                        <div><i class="fas fa-star" style="color: #cc543a;"></i></div>
                                        <div><i class="fas fa-star" style="color: #cc543a;"></i></div>
                                    </div>
                                    <div>超讚</div>
                                </div>
                            </div>
                            <div class="trip_gbtext pb-5">先上林家宮保第官網預約導覽時間，再上KLOOK購買套票（導覽+古裝體驗），
                                建議可以挑不要太晚的導覽，因為導覽結束後還能好好再到處拍照，很好拍超
                                好拍照；古裝體驗，有很多服飾，</div>
                            <hr>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-2">
                            <div class="trip_gb">W</div>
                        </div>
                        <div class="col-10">
                            <div>
                                <div class="py-2">WAN CHEN</div>
                                <div class="d-flex justify-content-start pb-4">
                                    <div class="d-flex justify-content-start pr-3">
                                        <div><i class="fas fa-star" style="color: #cc543a;"></i></div>
                                        <div><i class="fas fa-star" style="color: #cc543a;"></i></div>
                                        <div><i class="fas fa-star" style="color: #cc543a;"></i></div>
                                        <div><i class="fas fa-star" style="color: #cc543a;"></i></div>
                                        <div><i class="fas fa-star" style="color: #cc543a;"></i></div>
                                    </div>
                                    <div>超讚</div>
                                </div>
                            </div>
                            <div class="trip_gbtext pb-5">先上林家宮保第官網預約導覽時間，再上KLOOK購買套票（導覽+古裝體驗），
                                建議可以挑不要太晚的導覽，因為導覽結束後還能好好再到處拍照，很好拍超
                                好拍照；古裝體驗，有很多服飾，</div>
                            <hr>
                        </div>
                    </div>
                </div>

            </div>

            
        </div>
    <div class="row pt-4">
        <h3 class="pb-lg-4 pb-3 px-3 d-none d-lg-block">熱門推薦 |</h3>
    </div>
    <div class="">
        <div id="carouselHotControls" class="carousel slide d-none d-lg-block" data-ride="carousel">
            <div class="carousel-inner container">
<?php
foreach($pc_hot_trips as $key => $group) {
?>
                <div class="carousel-item <?=($key==0)?'active':''?>">
                    <div class="row">
<?php
    foreach($group as $trip_item) {
?>
        
                        <div class="col-lg-6 col-10 mt-lg-4 px-lg-4 pl-3">
                            <div class="trip_item_border">
                                <div class="row no-gutters">
                                    <div class="col-5 trip_item_image">
                                        <img src="img/<?=$trip_item['thumbnail']?>" width="100%" />
                                    </div>
                                    <div class="col-7 trip_item_body py-lg-1 pl-2 pr-1">
                                        <div class="trip_item_body_title my-lg-3 mx-lg-4 m-2"><?=$trip_item['title2']?></div>
                                        <div class="trip_item_body_body mx-lg-4">
                                            <div class="py-lg-1 pb-1"><i class="fas fa-map-marker-alt"></i><?=$trip_item['position']?>
                                            </div>
                                            <div class="py-lg-1 pb-1"><i class="far fa-clock"></i><?=$trip_item['days']?></div>
                                            <div class="py-1 d-none d-lg-block"><i
                                                    class="fas fa-quote-left"></i><?=$trip_item['title3']?>
                                            </div>
                                        </div>
                                        <div class="tripc_item_body_price mx-lg-4 py-lg-1 px-2"><span>NTD <?=number_format($trip_item['price'],0,".",",")?></span>
                                            元起
                                        </div>
                                        <div class="d-lg-flex justify-content-end">
                                            <div class="trip_btn1 mr-3"><a href="trip_page.php?id=<?=$trip_item['id']?>">查看詳情</a></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
<?php
    }
?>
                    </div>
                </div>
<?php
}
?>
            </div>
            <a class="trip_left carousel-control-prev" href="#carouselHotControls" role="button" data-slide="prev">
                <i class="fas fa-chevron-left"></i>
                <span class="sr-only">Previous</span>
            </a>
            <a class="trip_right carousel-control-next" href="#carouselHotControls" role="button" data-slide="next">
                <i class="fas fa-chevron-right"></i>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </div>
    <div class="row d-lg-none d-block d-flex mt-4 mx-3">
        <div class="col-2 pl-1">
            <div class="trip_gb">W</div>
        </div>
        <div class="col-10">
            <div>
                <div class="py-2">WAN CHEN</div>
                <div class="d-flex justify-content-start pb-4">
                    <div class="d-flex justify-content-start pr-3">
                        <div><i class="fas fa-star" style="color: #cc543a;"></i></div>
                        <div><i class="fas fa-star" style="color: #cc543a;"></i></div>
                        <div><i class="fas fa-star" style="color: #cc543a;"></i></div>
                        <div><i class="fas fa-star" style="color: #cc543a;"></i></div>
                        <div><i class="fas fa-star" style="color: #cc543a;"></i></div>
                    </div>
                    <div>超讚</div>
                </div>
            </div>
            <div class="trip_gbtext pb-4">先上林家宮保第官網預約導覽時間，再上KLOOK購買套票（導覽+古裝體驗），
                建議可以挑不要太晚的導覽，因為導覽結束後還能好好再到處拍照，很好拍超
                好拍照；古裝體驗，有很多服飾，</div>
        </div>
    </div>

    <!-- Button trigger modal -->
    <div class="trip_day mb-4 py-2 d-lg-none d-block" data-toggle="modal" data-target="#tripModalCommentLong">查看全部評價<i
            class="fas fa-chevron-down pl-2"></i></a>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="tripModalCommentLong" tabindex="-1" role="dialog"
        aria-labelledby="tripModalCommentLongTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content trip_container1">
                <div class="modal-header">
                    <h5 class="modal-title" id="tripModalCommentLongTitle">全部評價</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body mx-4">
                    <div class="row d-flex trip_modal border shadow mb-4 bg-white pt-3 d-lg-none d-block">
                        <div class="col-3 mt-3">
                            <div class="trip_gb ml-2">W</div>
                        </div>
                        <div class="col-9 pl-1">
                            <div class="pl-1">
                                <div class="py-2">WAN CHEN</div>
                                <div class="d-flex justify-content-start pb-2">
                                    <div class="d-flex justify-content-start pr-3">
                                        <div><i class="fas fa-star" style="color: #cc543a;"></i></div>
                                        <div><i class="fas fa-star" style="color: #cc543a;"></i></div>
                                        <div><i class="fas fa-star" style="color: #cc543a;"></i></div>
                                        <div><i class="fas fa-star" style="color: #cc543a;"></i></div>
                                        <div><i class="fas fa-star" style="color: #cc543a;"></i></div>
                                    </div>
                                    <div>超讚</div>
                                </div>
                            </div>
                            <div class="trip_gbtext pb-4">
                                先上林家宮保第官網預約導覽時間，再上KLOOK購買套票（導覽+古裝體驗），建議可以挑不要太晚的導覽，因為導覽結束後還能好好再到處拍照，超
                                好拍照；古裝體驗，有很多服飾，</div>
                        </div>
                    </div>
                    <div class="row d-flex trip_modal border shadow mb-4 bg-white pt-3 d-lg-none d-block">
                        <div class="col-3 mt-3">
                            <div class="trip_gb ml-2">W</div>
                        </div>
                        <div class="col-9 pl-1">
                            <div class="pl-1">
                                <div class="py-2">WAN CHEN</div>
                                <div class="d-flex justify-content-start pb-2">
                                    <div class="d-flex justify-content-start pr-3">
                                        <div><i class="fas fa-star" style="color: #cc543a;"></i></div>
                                        <div><i class="fas fa-star" style="color: #cc543a;"></i></div>
                                        <div><i class="fas fa-star" style="color: #cc543a;"></i></div>
                                        <div><i class="fas fa-star" style="color: #cc543a;"></i></div>
                                        <div><i class="fas fa-star" style="color: #cc543a;"></i></div>
                                    </div>
                                    <div>超讚</div>
                                </div>
                            </div>
                            <div class="trip_gbtext pb-4">
                                先上林家宮保第官網預約導覽時間，再上KLOOK購買套票（導覽+古裝體驗），建議可以挑不要太晚的導覽，因為導覽結束後還能好好再到處拍照，超
                                好拍照；古裝體驗，有很多服飾，</div>
                        </div>
                    </div>
                    <div class="row d-flex trip_modal border shadow mb-4 bg-white pt-3 d-lg-none d-block">
                        <div class="col-3 mt-3">
                            <div class="trip_gb ml-2">W</div>
                        </div>
                        <div class="col-9 pl-1">
                            <div class="pl-1">
                                <div class="py-2">WAN CHEN</div>
                                <div class="d-flex justify-content-start pb-2">
                                    <div class="d-flex justify-content-start pr-3">
                                        <div><i class="fas fa-star" style="color: #cc543a;"></i></div>
                                        <div><i class="fas fa-star" style="color: #cc543a;"></i></div>
                                        <div><i class="fas fa-star" style="color: #cc543a;"></i></div>
                                        <div><i class="fas fa-star" style="color: #cc543a;"></i></div>
                                        <div><i class="fas fa-star" style="color: #cc543a;"></i></div>
                                    </div>
                                    <div>超讚</div>
                                </div>
                            </div>
                            <div class="trip_gbtext pb-4">
                                先上林家宮保第官網預約導覽時間，再上KLOOK購買套票（導覽+古裝體驗），建議可以挑不要太晚的導覽，因為導覽結束後還能好好再到處拍照，超
                                好拍照；古裝體驗，有很多服飾，</div>
                        </div>
                    </div>
                    <div class="row d-flex trip_modal border shadow mb-4 bg-white pt-3 d-lg-none d-block">
                        <div class="col-3 mt-3">
                            <div class="trip_gb ml-2">W</div>
                        </div>
                        <div class="col-9 pl-1">
                            <div class="pl-1">
                                <div class="py-2">WAN CHEN</div>
                                <div class="d-flex justify-content-start pb-2">
                                    <div class="d-flex justify-content-start pr-3">
                                        <div><i class="fas fa-star" style="color: #cc543a;"></i></div>
                                        <div><i class="fas fa-star" style="color: #cc543a;"></i></div>
                                        <div><i class="fas fa-star" style="color: #cc543a;"></i></div>
                                        <div><i class="fas fa-star" style="color: #cc543a;"></i></div>
                                        <div><i class="fas fa-star" style="color: #cc543a;"></i></div>
                                    </div>
                                    <div>超讚</div>
                                </div>
                            </div>
                            <div class="trip_gbtext pb-4">
                                先上林家宮保第官網預約導覽時間，再上KLOOK購買套票（導覽+古裝體驗），建議可以挑不要太晚的導覽，因為導覽結束後還能好好再到處拍照，超
                                好拍照；古裝體驗，有很多服飾，</div>
                        </div>
                    </div>
                    <div class="row d-flex trip_modal border shadow mb-4 bg-white pt-3 d-lg-none d-block">
                        <div class="col-3 mt-3">
                            <div class="trip_gb ml-2">W</div>
                        </div>
                        <div class="col-9 pl-1">
                            <div class="pl-1">
                                <div class="py-2">WAN CHEN</div>
                                <div class="d-flex justify-content-start pb-2">
                                    <div class="d-flex justify-content-start pr-3">
                                        <div><i class="fas fa-star" style="color: #cc543a;"></i></div>
                                        <div><i class="fas fa-star" style="color: #cc543a;"></i></div>
                                        <div><i class="fas fa-star" style="color: #cc543a;"></i></div>
                                        <div><i class="fas fa-star" style="color: #cc543a;"></i></div>
                                        <div><i class="fas fa-star" style="color: #cc543a;"></i></div>
                                    </div>
                                    <div>超讚</div>
                                </div>
                            </div>
                            <div class="trip_gbtext pb-4">
                                先上林家宮保第官網預約導覽時間，再上KLOOK購買套票（導覽+古裝體驗），建議可以挑不要太晚的導覽，因為導覽結束後還能好好再到處拍照，超
                                好拍照；古裝體驗，有很多服飾，</div>
                        </div>
                    </div>
                    <div class="row d-flex trip_modal border shadow mb-4 bg-white pt-3 d-lg-none d-block">
                        <div class="col-3 mt-3">
                            <div class="trip_gb ml-2">W</div>
                        </div>
                        <div class="col-9 pl-1">
                            <div class="pl-1">
                                <div class="py-2">WAN CHEN</div>
                                <div class="d-flex justify-content-start pb-2">
                                    <div class="d-flex justify-content-start pr-3">
                                        <div><i class="fas fa-star" style="color: #cc543a;"></i></div>
                                        <div><i class="fas fa-star" style="color: #cc543a;"></i></div>
                                        <div><i class="fas fa-star" style="color: #cc543a;"></i></div>
                                        <div><i class="fas fa-star" style="color: #cc543a;"></i></div>
                                        <div><i class="fas fa-star" style="color: #cc543a;"></i></div>
                                    </div>
                                    <div>超讚</div>
                                </div>
                            </div>
                            <div class="trip_gbtext pb-4">
                                先上林家宮保第官網預約導覽時間，再上KLOOK購買套票（導覽+古裝體驗），建議可以挑不要太晚的導覽，因為導覽結束後還能好好再到處拍照，超
                                好拍照；古裝體驗，有很多服飾，</div>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>

    <!-- mobile -->
    <div class="container-fluid p-0 pb-5 mb-5 mb-lg-0">
        <h3 class="p-3 d-block d-lg-none">熱門推薦 |</h3>
        <div class="trip_scrolling_wrapper row flex-row flex-nowrap mb-lg-4 no-gutters d-flex d-lg-none">
<?php
    foreach($hot_trips as $trip_item) {
?>
            <div class="col-lg-6 col-10 mt-lg-4 px-lg-4 pl-3">
                <div class="trip_item_border">
                    <div class="row no-gutters">
                        <div class="col-5 trip_item_image">
                            <img src="img/<?=$trip_item['thumbnail']?>" width="100%" />
                        </div>
                        <div class="col-7 trip_item_body py-lg-1 pl-2 pr-1">
                            <div class="trip_item_body_title my-lg-3 mx-lg-4 mx-2 mt-2"><?=$trip_item['title2']?></div>
                            <div class="trip_item_body_body mx-lg-4">
                                <div class="py-lg-1"><i class="fas fa-map-marker-alt"></i><?=$trip_item['position']?></div>
                                <div class="py-lg-1 pb-1"><i class="far fa-clock"></i><?=$trip_item['days']?></div>
                            </div>
                            <div class="tripc_item_body_price mx-lg-4 py-lg-1 px-2"><span>NTD <?=number_format($trip_item['price'],0,".",",")?></span> 元起
                            </div>
                            <div class="d-flex justify-content-end pt-1">
                                <div class="trip_btn1 mr-1"><a href="trip_page.php?id=<?=$trip_item['id']?>">查看詳情</a></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
<?php
}
?>
            
            <!-- <div class="col-lg-6 col-10 mt-lg-4 px-lg-4 pl-3">
                <div class="trip_item_border">
                    <div class="row no-gutters">
                        <div class="col-5 trip_item_image">
                            <img src="img/img01.png" width="100%" />
                        </div>
                        <div class="col-7 trip_item_body py-lg-1 pl-2 pr-1">
                            <div class="trip_item_body_title my-lg-3 mx-lg-4 m-2">蒐集離島媽祖</div>
                            <div class="trip_item_body_body mx-lg-4">
                                <div class="py-lg-1"><i class="fas fa-map-marker-alt"></i>澎湖-蘭嶼-綠島</div>
                                <div class="py-lg-1 pb-1"><i class="far fa-clock"></i>4天3夜</div>
                                <div class="py-1 d-none d-lg-block"><i class="fas fa-quote-left"></i>是媽祖叫我去的！</div>
                            </div>
                            <div class="tripc_item_body_price mx-lg-4 py-lg-1 px-2"><span>NTD 3,250</span> 元起
                            </div>
                            <div class="d-flex justify-content-end pt-1">
                                <div class="trip_btn1 mr-1">查看詳情</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-10 mt-lg-4 px-lg-4 pl-3">
                <div class="trip_item_border">
                    <div class="row no-gutters">
                        <div class="col-5 trip_item_image">
                            <img src="img/img01.png" width="100%" />
                        </div>
                        <div class="col-7 trip_item_body py-lg-1 pl-2 pr-1">
                            <div class="trip_item_body_title my-lg-3 mx-lg-4 m-2">蒐集離島媽祖</div>
                            <div class="trip_item_body_body mx-lg-4">
                                <div class="py-lg-1"><i class="fas fa-map-marker-alt"></i>澎湖-蘭嶼-綠島</div>
                                <div class="py-lg-1 pb-1"><i class="far fa-clock"></i>4天3夜</div>
                                <div class="py-1 d-none d-lg-block"><i class="fas fa-quote-left"></i>是媽祖叫我去的！</div>
                            </div>
                            <div class="tripc_item_body_price mx-lg-4 py-lg-1 px-2"><span>NTD 3,250</span> 元起
                            </div>
                            <div class="d-flex justify-content-end pt-1">
                                <div class="trip_btn1 mr-1">查看詳情</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-10 mt-lg-4 px-lg-4 pl-3">
                <div class="trip_item_border">
                    <div class="row no-gutters">
                        <div class="col-5 trip_item_image">
                            <img src="img/img01.png" width="100%" />
                        </div>
                        <div class="col-7 trip_item_body py-lg-1 pl-2 pr-1">
                            <div class="trip_item_body_title my-lg-3 mx-lg-4 m-2">蒐集離島媽祖</div>
                            <div class="trip_item_body_body mx-lg-4">
                                <div class="py-lg-1"><i class="fas fa-map-marker-alt"></i>澎湖-蘭嶼-綠島</div>
                                <div class="py-lg-1 pb-1"><i class="far fa-clock"></i>4天3夜</div>
                                <div class="py-1 d-none d-lg-block"><i class="fas fa-quote-left"></i>是媽祖叫我去的！</div>
                            </div>
                            <div class="tripc_item_body_price mx-lg-4 py-lg-1 px-2"><span>NTD 3,250</span> 元起
                            </div>
                            <div class="d-flex justify-content-end pt-1">
                                <div class="trip_btn1 mr-1">查看詳情</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> -->
        </div>
    </div>

    <div class="trip_fixed_bottom w-100 d-flex justify-content-between py-2 px-2 fixed-bottom d-lg-none ">
        <div class="trip_fixed_bottom1 py-2"><i class="fas fa-shopping-cart px-2" style="color: #fff;"></i><span>已</span>加入購物車
        </div>
        <div class="trip_fixed_bottom_line"></div>
        <div class="trip_fixed_bottom1 py-2">前往結帳</div>
    </div>
    </div>
    <footer>
        <p>Copyright© TempleTrip.tw</p>
    </footer>

    <div class="modal fade trip-more-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content trip_details">
                <div class="modal-header">
                    <h4 class="modal-title trip_details_text pl-3 pl-lg-5 pt-2 pt-lg-4" id="myLargeModalLabel">費用詳情</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span
                            aria-hidden="true">×</span> </button>
                </div>
                <div class="modal-body pt-lg-0 pt-0 px-lg-5">
                    <div class="container-fluid">
                        <div id="trip_detail" class="row">
                            <div class="col-6">選擇造訪日期</div>
                            <div class="col-6 ">2021-06-05</div>
                            <div class="col-6 ">方案類型</div>
                            <div class="col-6 ">導覽</div>
                            <div class="col-6 ">方案費用</div>
                            <div class="col-6 ">0元</div>
                            <div class="col-6 ">人數</div>
                            <div class="col-6 ">2人</div>
                            <div class="col-6 ">每人</div>
                            <div class="col-6 ">NTD 1,200元</div>
                            <div class="col-6 border-top">小計</div>
                            <div class="col-6 border-top">NTD 2,400元</div>
                        </div>
                    </div>
                </div>
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
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"
        integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
        crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"
        integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k"
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/11.0.2/bootstrap-slider.min.js"
        integrity="sha512-f0VlzJbcEB6KiW8ZVtL+5HWPDyW1+nJEjguZ5IVnSQkvZbwBt2RfCBY0CBO1PsMAqxxrG4Di6TfsCPP3ZRwKpA=="
        crossorigin="anonymous"></script>
    <!-- +-數字鍵 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-touchspin/4.3.0/jquery.bootstrap-touchspin.min.js"
        integrity="sha512-0hFHNPMD0WpvGGNbOaTXP0pTO9NkUeVSqW5uFG2f5F9nKyDuHE3T4xnfKhAhnAZWZIO/gBLacwVvxxq0HuZNqw=="
        crossorigin="anonymous"></script>



    <script>
        // 增加千分位的函式
        Number.prototype.numberFormat = function (c, d, t) {
            var n = this,
                c = isNaN(c = Math.abs(c)) ? 2 : c,
                d = d == undefined ? "." : d,
                t = t == undefined ? "," : t,
                s = n < 0 ? "-" : "",
                i = String(parseInt(n = Math.abs(Number(n) || 0).toFixed(c))),
                j = (j = i.length) > 3 ? j % 3 : 0;
            return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
        };

        $("input[name='demo3']").TouchSpin({
            initval: 1,
            min: 1,
            max: 99,
            step: 1,
            decimals: 0,
            buttondown_class: 'btn btn-default',
            buttonup_class: 'btn btn-default'
        });

        var today = new Date();
        var dd = today.getDate();
        var mm = today.getMonth() + 1;
        var yyyy = today.getFullYear();
        if (dd < 10) {
            dd = '0' + dd
        }
        if (mm < 10) {
            mm = '0' + mm
        }
        today = yyyy + '-' + mm + '-' + dd;
        $(".trip_input_date").attr("min", today);

        $(".trip_title_img .trip_imghover img").click(function () {
            $("#trip_imgclick").attr("src", $(this).attr("src"))
        });

        $("#trip_solution_checkbox .trip_btn_mobile+").click(function () {
            // 把單價取出來轉換成整數
            var price = parseInt($("#trip_price").val());
            // 對事件元素增加或取消active
            $(this).toggleClass("active");

            // 獲得有選取的方案,且逐一處理
            $("#trip_solution_checkbox .active").each(function () {
                // 把方案價格取出轉成整數並與前單價price加總
                price = price + parseInt($(this).data('price'));
            });
            // 加總後金額增加千位符號，放進元素
            $("#trip_amount").text(price.numberFormat(0, '.', ','));
            trip_summary();
            // $("#trip_solution_checkbox .active").each(function () {
            //     console.log($(this).text());
            // });
            //console.log($("#trip_price").val());
            //console.log($("#trip_qty").val());
            //console.log($("#date_today").val());
            //
        });
        // 計算總金額且產出新的費用詳情
        function trip_summary() {
            // 取出加總後金額
            var amount_text = $("#trip_amount").text();
            // 加總後金額拿掉千位數符號
            var amount = amount_text.replace(/,/g, "");
            // 加總後金額千位數拿掉後轉成整數
            amount = parseInt(amount);
            // 取出人數轉成整數
            var qty = parseInt($("#trip_qty").val());
            // 加總後金額*人數=總金額
            var sum = amount * qty;
            // 總金額加上千位符號
            var sum_text = sum.numberFormat(0, '.', ',');
            // ***總金額放進元素
            $("#trip_calculate").text(sum_text);
            var solution_text = "";
            var solution_price = 0;
            // 把選取的方案逐一處理
            $("#trip_solution_checkbox .active").each(function () {
                // 把方案名稱串成一個變數
                solution_text += $(this).text() + " ";
                // 把方案費用取出來轉成整數加總
                solution_price += parseInt($(this).data('price'));
            });
            // 把加總後的方案費用加上千位符號
            var solution_price_text = solution_price.numberFormat(0, '.', ',');
            // ***把費用詳情清空後放進新的費用詳情
            $("#trip_detail").empty().append('<div class="col-6">選擇造訪日期</div><div class="col-6 ">' + $("#date_today").val() + '</div><div class="col-6 ">方案類型</div><div class="col-6 ">' + solution_text + '</div><div class="col-6 ">方案費用</div><div class="col-6 ">' + solution_price_text + '元</div><div class="col-6 ">人數</div><div class="col-6 ">' + qty + '人</div><div class="col-6 ">每人</div><div class="col-6 ">NTD ' + amount_text + '元</div><div class="col-6 border-top">小計</div><div class="col-6 border-top">NTD ' + sum_text + '元</div>');

            // <div class="col-6">選擇造訪日期</div>
            //                 <div class="col-6 ">2021-06-05</div>
            //                 <div class="col-6 ">方案類型</div>
            //                 <div class="col-6 ">導覽</div>
            //                 <div class="col-6 ">方案費用</div>
            //                 <div class="col-6 ">0元</div>
            //                 <div class="col-6 ">人數</div>
            //                 <div class="col-6 ">2人</div>
            //                 <div class="col-6 ">每人</div>
            //                 <div class="col-6 ">NTD 1,200元</div>
            //                 <div class="col-6 border-top">小計</div>
            //                 <div class="col-6 border-top">NTD 2,400元</div>

        }
        // 人數有變化時進行處理
        $("#trip_qty").change(trip_summary);
        // 日期有變化時進行處理
        $('#date_today').change(trip_summary);

        trip_summary();

        // mobile加入購物車



        // 網頁費用清單

        $("#trip_solution_checkbox1 .trip_btn2+").click(function () {
            // 把單價取出來轉換成整數
            var price = parseInt($("#trip_price").val());
            // 對事件元素增加或取消active
            $(this).toggleClass("active");

            // 獲得有選取的方案,且逐一處理
            $("#trip_solution_checkbox1 .active").each(function () {
                // 把方案價格取出轉成整數並與前單價price加總
                price = price + parseInt($(this).data('price'));
            });
            // 加總後金額增加千位符號，放進元素
            $("#trip_amount1").text(price.numberFormat(0, '.', ','));
            trip_summary1();
            // $("#trip_solution_checkbox .active").each(function () {
            //     console.log($(this).text());
            // });
            //console.log($("#trip_price").val());
            //console.log($("#trip_qty").val());
            //console.log($("#date_today").val());
            //
        });
        // 計算總金額且產出新的費用詳情
        function trip_summary1() {

            // 取出加總後金額
            var amount_text = $("#trip_amount1").text();
            // 加總後金額拿掉千位數符號
            var amount = amount_text.replace(/,/g, "");
            // 加總後金額千位數拿掉後轉成整數
            amount = parseInt(amount);
            // 取出人數轉成整數
            var qty = parseInt($("#trip_qty1").val());
            // 加總後金額*人數=總金額
            var sum = amount * qty;
            // 總金額加上千位符號
            var sum_text = sum.numberFormat(0, '.', ',');
            // ***總金額放進元素
            $("#trip_calculate1").text(sum_text);
            var solution_text = "";
            var solution_price = 0;
            // 把選取的方案逐一處理
            $("#trip_solution_checkbox1 .active").each(function () {
                // 把方案名稱串成一個變數
                solution_text += $(this).text() + " ";
                // 把方案費用取出來轉成整數加總
                solution_price += parseInt($(this).data('price'));
            });
            // 把加總後的方案費用加上千位符號
            var solution_price_text = solution_price.numberFormat(0, '.', ',');
            // ***把費用詳情清空後放進新的費用詳情
            $("#trip_detail").empty().append('<div class="col-6">選擇造訪日期</div><div class="col-6 ">' + $("#date_today1").val() + '</div><div class="col-6 ">方案類型</div><div class="col-6 ">' + solution_text + '</div><div class="col-6 ">方案費用</div><div class="col-6 ">' + solution_price_text + '元</div><div class="col-6 ">人數</div><div class="col-6 ">' + qty + '人</div><div class="col-6 ">每人</div><div class="col-6 ">NTD ' + amount_text + '元</div><div class="col-6 border-top">小計</div><div class="col-6 border-top">NTD ' + sum_text + '元</div>');

        }
        // 人數有變化時進行處理
        $("#trip_qty1").change(trip_summary1);
        // 日期有變化時進行處理
        $('#date_today1').change(trip_summary1);
        trip_summary1();

        // 加入購物車
        $('.mybtn_cart_add').click(function(){
            if($(this).hasClass('active')) {
                return;
            }
            var btn = this;
            var date = $('#date_today1').val();
            var qty = $('#trip_qty1').val();
            var solution_text = "";
            // 把選取的方案逐一處理
            $("#trip_solution_checkbox1 .active").each(function () {
                // 把方案名稱串成一個變數
                solution_text += $(this).text() + " ";
            });
            // 取出加總後金額
            var amount_text = $("#trip_amount1").text();
            // 加總後金額拿掉千位數符號
            var amount = amount_text.replace(/,/g, "");
            // 加總後金額千位數拿掉後轉成整數
            amount = parseInt(amount);

            if(!date) {
                $('#date_today1').addClass('is-invalid');
            } else {
                $('#date_today1').removeClass('is-invalid');
                
                $.ajax({
                    type: "POST",
                    url: 'trip_add.php',
                    data: {
                        id: $('#trip_id').val(),
                        name: $('#trip_name').val(),
                        image: $('#trip_image').val(),
                        date: date,
                        qty: qty,
                        solution: solution_text,
                        price: amount,
                    },
                    success: function(data){
                        if(data.code == 200) {
                            $(btn).toggleClass("active");
                        }
                    },
                    dataType: 'json'
                });
                
            }
        });

        // 加入購物車
        $('.trip_fixed_bottom1').click(function(){
            if($(this).hasClass('active')) {
                return;
            }
            var btn = this;
            var date = $('#date_today').val();
            var qty = $('#trip_qty').val();
            var solution_text = "";
            // 把選取的方案逐一處理
            $("#trip_solution_checkbox .active").each(function () {
                // 把方案名稱串成一個變數
                solution_text += $(this).text() + " ";
            });
            // 取出加總後金額
            var amount_text = $("#trip_amount").text();
            // 加總後金額拿掉千位數符號
            var amount = amount_text.replace(/,/g, "");
            // 加總後金額千位數拿掉後轉成整數
            amount = parseInt(amount);

            if(!date) {
                $('#date_today').addClass('is-invalid');
                $('#date_today').focus();

            } else {
                $('#date_today').removeClass('is-invalid');
                
                $.ajax({
                    type: "POST",
                    url: 'trip_add.php',
                    data: {
                        id: $('#trip_id').val(),
                        name: $('#trip_name').val(),
                        image: $('#trip_image').val(),
                        date: date,
                        qty: qty,
                        solution: solution_text,
                        price: amount,
                    },
                    success: function(data){
                        if(data.code == 200) {
                            $(btn).toggleClass("active");
                        }
                    },
                    dataType: 'json'
                });
                
            }
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


        $(".trip_btn1").click(function () {
            $(this).toggleClass("active");
        });

        $(".trip_like_mobile").click(function () {
            $(this).toggleClass('active');
        });





    </script>

</body>

</html>