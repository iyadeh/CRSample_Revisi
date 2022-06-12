<?php
session_start();
include 'functions.php';
$pdo = pdo_connect();

if (isset($_SESSION['user'])) {
    if (isset($_GET['id'])) {
        $stmt = $pdo->prepare('DELETE FROM contacts WHERE id = ?');
        $stmt->execute([$_GET['id']]);
        header("location:index.php");
    } else {
        die ('No ID specified!');
    }
}else{
    header("location: login.php");
}

?>
