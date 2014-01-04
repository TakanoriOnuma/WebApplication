<?php
    // テンプレート利用準備
    require_once 'smarty/Smarty.class.php';
    
    $smarty = new Smarty();
    $smarty->template_dir = 'templates/';
    $smarty->compile_dir  = 'templates_c/';
    
    // セッションスタート
    session_start();

    // セッションにない時（まだログインしていない時)
    if (!isset($_SESSION['number'])) {
        $smarty->assign('account_data', '');
        $smarty->display('index.html');
        exit;
    }

    // セッションにある時（ログインしているとき）
    $account_data = $_SESSION['number'];
    $smarty->assign('account_data', '<h2>' . $account_data . '</h2>');
    $smarty->display('index.html');
?>