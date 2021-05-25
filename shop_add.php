<?php
session_start();
require __DIR__ . "/__connect_db.php";

$shop = [
    'id' => $_POST['id'],
    'name' => $_POST['name'],
    'content' => $_POST['name1'],
    'qty' => $_POST['qty'],
    'price' => $_POST['price'],
    'image' => $_POST['image'],
];

$_SESSION['cart']['shop'][] = $shop; // append to $_SESSION['cart']['trip']

$result['success'] = true;
$result['code'] = 200;
$result['info'] = '資料新增完成';
echo json_encode($result, JSON_UNESCAPED_UNICODE);