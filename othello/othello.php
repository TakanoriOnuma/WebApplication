<?php
    // テンプレート利用準備
    require_once '../smarty/Smarty.class.php';
    
    $smarty = new Smarty();
    $smarty->template_dir = 'templates/';
    $smarty->compile_dir  = 'templates_c/';
    
    // 必要なデータアサイン
    $smarty->assign('black_player', 'human');
    $smarty->assign('white_player', 'AI');
    
    $smarty->display('othello.tpl');
?>