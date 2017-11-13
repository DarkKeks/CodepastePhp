<?php
include_once("main.php");

$pdo = DBConnect();
$st  = $pdo->prepare("SELECT * FROM lang");
$st->execute();
$res = $st->fetchAll();

echo json_encode(array(
    'data' => $res
));