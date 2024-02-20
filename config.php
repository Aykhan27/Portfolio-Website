<?php
    if (isset($_GET['lang']) && ($_GET['lang'] === 'en' || $_GET['lang'] === 'fr')) {
        $lang = include 'lang/' . $_GET['lang'] . '.php';
    } else {
        $lang = include 'lang/en.php';
    }

    $host = 'localhost';
    $db = 'portfolio';
    $user = 'admin';
    $password = 'admin';

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        echo "MySQL connect error: " . $e->getMessage();
        exit();
    }