<?php include("script/main.php");?>
<?php
header("Content-Type: text/plain");

$id = $_GET['q'];
$source = GetSource($id);
if($source === false) {
    header("Location: codepaste.me/");
}

echo $source['source'];


function GetSource($id) {
    $pdo = DBConnect();
    $getSource = $pdo->prepare("SELECT * FROM source WHERE alias = :id");
    $getSource->execute(array(
        ":id" => $id
    ));
    return $getSource->fetch();
}