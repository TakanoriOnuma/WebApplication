<?php
    // テンプレート利用準備
    require_once 'smarty/Smarty.class.php';
    
    $smarty = new Smarty();
    $smarty->template_dir = 'templates/';
    $smarty->compile_dir  = 'templates_c/';

    // セッション開始
    session_start();

    unset($_SESSION['number']);     // 会員番号を破棄する

    // ログアウトしたことを伝える
    $smarty->assign('title', 'ログアウト');
    $smarty->assign('message', 'ログアウトしました。');
    $smarty->assign('webpage', 'index.php');
    $smarty->assign('page_msg', 'トップページに戻る');
    $smarty->display('complete.html');
?>