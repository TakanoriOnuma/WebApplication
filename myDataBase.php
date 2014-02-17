<?php
    final class myDataBase {
        private static $DB_NAME = 'phpdb';
        private static $IP_ADDRESS = '127.0.0.1';
        private static $ID = 'root';
        private static $PW = 'ayashi';

        public static function createPDO() {
            return new PDO('mysql:dbname=' . self::$DB_NAME . ';host=' . self::$IP_ADDRESS, self::$ID, self::$PW, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
        }
    }

    // ニックネームを取得する
    function get_nickname($no) {
        $nickname = null;
        try {
            $pdo = myDataBase::createPDO();
            $pdo->query('SET NAMES utf8');

            // ニックネームの読み込み
            $stmt = $pdo->prepare('SELECT * FROM accounts WHERE number = :number');
            $stmt->bindValue(':number', $no, PDO::PARAM_INT);
            $stmt->execute();

            $account_data = $stmt->fetch(PDO::FETCH_ASSOC);
            $nickname = $account_data['nickname'];

            $pdo = null;        // データベースとの接続を終了する
        }
        catch (PDOException $e) {
            exit($e->getMessage());
        }
        return $nickname;
    }
?>
