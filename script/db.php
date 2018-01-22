<?php

$_db_opts = parse_url(getenv('DATABASE_URL'));
$_db_host = $_db_opts["host"];
$_db_port = $_db_opts["port"];
$_db_user = $_db_opts["user"];
$_db_pass = $_db_opts["pass"];
$_db_db = ltrim($_db_opts["path"],'/');
$_db_charset = "UTF8";

function DBConnect(){
    global $_db_host, $_db_user, $_db_pass, $_db_db, $_db_charset, $_db_port;
    $_db_dsn = "pgsql:host={$_db_host};port={$_db_port};dbname={$_db_db};user={$_db_user};password={$_db_pass}";
    $_db_opt = array(
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    );
    $pdo = new PDO($_db_dsn, $_db_user, $_db_pass, $_db_opt);
    $pdo->query("SET NAMES '{$_db_charset}'");
    return $pdo;
}