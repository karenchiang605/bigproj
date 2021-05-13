<?php

require __DIR__ . "/__connect_db.php";

$id = $_POST['id'];
$date = $_POST['date'];
$qty = $_POST['qty'];
$price = $_POST['price'];
$solution = $_POST['solution'];

$sql = "INSERT INTO cart_plan (name, content, quantity, price, note) VALUES (?, ?, ?, ?, ?)";
$stmt = $pdo->prepare($sql);
$stmt->execute([
    $id,
    $solution,
    $qty,
    $price,
    $date
]);

if ($stmt->rowCount() == 1) {
    $result['success'] = true;
    $result['code'] = 200;
    $result['info'] = '資料新增完成';
} else {
    $result['code'] = 410;
    $result['info'] = '資料沒有新增';

}

echo json_encode($result, JSON_UNESCAPED_UNICODE);