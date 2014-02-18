<?php
    require_once 'myDataBase.php';      // データベースアクセスクラスの読み込み

    // テンプレート利用準備
    require_once 'smarty/Smarty.class.php';
    
    $smarty = new Smarty();
    $smarty->template_dir = 'templates/';
    $smarty->compile_dir  = 'templates_c/';

    // セッションスタート
    session_start();

    // セッションにない時（まだログインしていない時)
    if (!isset($_SESSION['number'])) {
        $smarty->display('index.tpl');
        exit;
    }

    $account_data;      // 会員情報を持つ
    // セッションにある時（ログインしているとき）
    try {
        $pdo = myDataBase::createPDO();
        $pdo->query('SET NAMES utf8');
    
        $stmt = $pdo->prepare('SELECT * FROM accounts WHERE number = :number');
        $stmt->bindValue(':number', $_SESSION['number'], PDO::PARAM_INT);
        $stmt->execute();

        $account_data = $stmt->fetch(PDO::FETCH_ASSOC);

        // 会員情報がもしなかったら
        if ($account_data == null) {
            // 会員情報なしと表示する
            $smarty->assign('account_data', 'account not found');
            $smarty->display('index.tpl');
            exit;
        }

        $pdo = null;        // データベースとの接続を終了する
    }
    catch (PDOException $e) {
        exit($e->getMessage());
    }

    $account_html = <<<EOM
会員番号：{$account_data['number']}
ID:{$account_data['id']}
ニックネーム：{$account_data['nickname']}
EOM;
    $smarty->assign('account_data', $account_html);
    $smarty->assign('account_having', 'true');
    $smarty->display('index.tpl');
?>