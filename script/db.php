<?php

$_db_host = "localhost";
$_db_user = "codepaste";
$_db_pass = "jfhtm_7930";
$_db_db = "codepaste";
$_db_charset = "UTF8";

function DBConnect(){
    global $_db_host, $_db_user, $_db_pass, $_db_db, $_db_charset;
    $_db_dsn = "pgsql:host={$_db_host};port=5432;dbname={$_db_db};user={$_db_user};password={$_db_pass}";
    $_db_opt = array(
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    );
    $pdo = new PDO($_db_dsn, $_db_user, $_db_pass, $_db_opt);
    $pdo->query("SET NAMES '{$_db_charset}'");
    return $pdo;
}