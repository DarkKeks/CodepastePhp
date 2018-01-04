<?php
include_once("main.php");

define("NotAValue", "NotAVal");

if(!isset($_POST['source']) ||
   !isset($_POST['name']) ||
   !isset($_POST['source'])) {
    header('Location: /');
}

$source = $_POST['source'];
$name = $_POST['name'];
$lang = $_POST['lang'];
$flag = "";
if(isset($_POST['flag']))
    $flag = $_POST['flag'];

$pdo = DBConnect();
$insertedID = InsertSource($source, $name, $lang, NotAValue, $flag);
$insertedID = $insertedID[0];
$alias = UpdateAliases();

echo json_encode(array(
    "success" => "true",
    "id" => $alias
));

function InsertSource($source, $name, $lang, $alias, $flag) {
    global $pdo;
    $st = $pdo->prepare("INSERT INTO source(source, name, lang, alias, flag, time) VALUES (:source, :name, :lang, :alias, :flag, current_timestamp) RETURNING id");
    $st->execute(array(
        ":source" => $source,
        ":name" => $name,
        ":lang" => $lang,
        ":alias" => $alias,
        ":flag" => $flag
    ));
    return $st->fetch(PDO::FETCH_NUM);
}

function UpdateAliases() {
    global $pdo, $insertedID;
    $result = "";

    $st = $pdo->prepare("SELECT (id) FROM source WHERE alias = :alias");
    $updateAlias = $pdo->prepare("UPDATE source SET alias = :alias WHERE id = :id");
    $st->execute(array(
        ":alias" => NotAValue
    ));
    $res = $st->fetchAll();

    foreach ($res as $source) {
        $id = $source['id'];
        $alias = GenerateAlias($id);
        if($id == $insertedID) {
            $result = $alias;
        }
        $updateAlias->execute(array(
            ":alias" => GenerateAlias($id),
            ":id" => $id
        ));
    }

    return $result;
}

function GenerateAlias($id) {
    return substr(md5($id), 0, 8);
}