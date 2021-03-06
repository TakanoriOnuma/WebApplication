<?php
    require_once 'myDataBase.php';      // データベースアクセスクラスの読み込み

    // テンプレート利用準備
    require_once 'smarty/Smarty.class.php';

    $smarty = new Smarty();
    $smarty->template_dir = 'templates/';
    $smarty->compile_dir  = 'templates_c/';

    // フォーム送信でない時（登録するために来た時）
    if (!isset($_POST['id'])) {
        $smarty->display('register.tpl');
        exit;
    }

    // フォーム送信で来たとき
    try {
        $pdo = myDataBase::createPDO();
        $pdo->query('SET NAMES utf8');

        $stmt = $pdo->prepare('SELECT * FROM accounts WHERE id = :id');
        $stmt->bindValue(':id', $_POST['id']);
        $stmt->execute();
        $using_id_flag = ($stmt->fetch(PDO::FETCH_ASSOC) != null)? true : false;

        $stmt = $pdo->prepare('SELECT * FROM accounts WHERE nickname = :nickname');
        $stmt->bindValue(':nickname', $_POST['nickname']);
        $stmt->execute();
        $using_nickname_flag = ($stmt->fetch(PDO::FETCH_ASSOC) != null)? true : false;

        $error_message = '';        // エラーなしと宣言しておく
        // エラーチェック
        if($using_id_flag) {
            $error_message .= "このIDは既に使われています。\n";
        }
        if($using_nickname_flag) {
            $error_message .= "このニックネームは既に使われています。\n";
        }
        if ($_POST['id'] == '' or $_POST['nickname'] == '') {
            $error_message .= "IDかニックネームが記入してありません。\n";
        }
        if ($_POST['password'] == '') {
            $error_message .= "パスワードが入力してありません。\n";
        }
        if ($_POST['password'] != $_POST['check_pass']) {
            $error_message .= "パスワードが一致していません。\n";
        }

        // エラーがあったか見る
        if ($error_message != '') {
            $smarty->assign('error_message', $error_message);
            $smarty->assign('id', $_POST['id']);
            $smarty->assign('nickname', $_POST['nickname']);
            $smarty->assign('password', $_POST['password']);
            $smarty->assign('check_pass', $_POST['check_pass']);
            $smarty->display('register.tpl');
            exit;
        }

        // エラーなしの処理
        $hash_pass = sha1($_POST['password']);
        $stmt = $pdo->prepare('INSERT INTO accounts(id, nickname, password) VALUES(:id, :nickname, :password)');
        $stmt->bindValue(':id', $_POST['id']);
        $stmt->bindValue(':nickname', $_POST['nickname']);
        $stmt->bindValue(':password', $hash_pass);
        $stmt->execute();

        // このIDの会員番号を取得する
        $stmt = $pdo->prepare('SELECT * FROM accounts WHERE id = :id');
        $stmt->bindValue(':id', $_POST['id']);
        $stmt->execute();

        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        // ゲームスコアテーブルも作成する
        $stmt = $pdo->prepare('INSERT INTO game_scores VALUES(:no, 0, 0)');
        $stmt->bindValue(':no', $data['number']);
        $stmt->execute();

        $pdo = null;        // データベースとの接続を終了する
    }
    catch(PDOException $e) {
        exit($e->getMessage());
    }

    // 登録が成功したと表示する
    $smarty->assign('title', '登録完了');
    $smarty->assign('message', '登録が完了しました。');
    $smarty->assign('webpage', 'login.php');
    $smarty->assign('page_msg', 'ログイン画面へ');
    $smarty->display('complete.tpl');
?>
