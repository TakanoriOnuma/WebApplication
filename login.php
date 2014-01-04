<?php
    require_once 'myDataBase.php';       // データベースアクセスクラスの読み込み

    // テンプレート利用準備
    require_once 'smarty/Smarty.class.php';

    $smarty = new Smarty();
    $smarty->template_dir = 'templates/';
    $smarty->compile_dir  = 'templates_c/';

    // フォーム送信でない時（ログインするために来た時）
    if (!isset($_POST['id'])) {
        $smarty->assign('error_message', '');
        $smarty->assign('id', '');
        $smarty->assign('password', '');
        $smarty->assign('auto_login', '');
        $smarty->display('login.html');
        exit;
    }

    $account_number;        // 会員番号
    // フォーム送信で来たとき
    try {
        $pdo = myDataBase::createPDO();
        $pdo->query('SET NAMES utf8');

        $stmt = $pdo->prepare('SELECT * FROM accounts WHERE id = :id');
        $stmt->bindValue(':id', $_POST['id']);
        $stmt->execute();

        $error_message = '';        // エラーなしと宣言しておく
        // エラーチェック
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($data == null) {
            $error_message .= "このIDは使われていません。\n";
        }
        else {
            $hash_pass = sha1($_POST['password']);
            if ($hash_pass != $data['password']) {
                $error_message .= "パスワードが正しくありません。\n";
            }
        }

        // エラーがあったかを見る
        if ($error_message != '') {
            $smarty->assign('error_message', '<h2>' . nl2br($error_message) . '</h2>');
            $smarty->assign('id', $_POST['id']);
            $smarty->assign('password', $_POST['password']);
            $smarty->assign('auto_login', (isset($_POST['auto_login'])) ? 'checked' : '');
            $smarty->display('login.html');
            exit;
        }

        $account_number = $data['number'];      // 会員番号を受け取る

        $pdo = null;    // データベースとの接続を終了する
    }
    catch(PDOException $e) {
        exit($e->getMessage());
    }

    // エラーがない時
    $auto_login_flag = (isset($_POST['auto_login'])) ? 'true' : 'false';


    // セッションに登録する
    session_start();

    $_SESSION['number'] = $account_number;      // セッションに登録する

    // ログインが成功したと伝える
    $smarty->assign('title', 'ログイン');
    $smarty->assign('message', 'ログインしました。');
    $smarty->assign('webpage', 'index.php');
    $smarty->assign('page_msg', 'トップページへ戻る');
    $smarty->display('complete.html');
?>