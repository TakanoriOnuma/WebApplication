<?php
    require_once 'myDataBase.php';      // データベースアクセスクラスの読み込み

    try {
        $pdo = myDataBase::createPDO();
        $pdo->query('SET NAMES utf8');

        // 降順にしたい列名
        $element = $_POST['element'];

        $stmt = $pdo->query("SELECT * FROM game_scores");

        // ランキングデータを生成する
        $ranking_dats = array();
        while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $data['name'] = get_nickname($data['number']);

            if ($data['game_num'] == 0) {
                $data['winning_rate'] = '-';
            }
            else {
                $data['winning_rate'] = ($data['winning_num'] / $data['game_num']) * 100;
            }
            $ranking_dats[] = $data;
        }

        // テーブルとして出力
        echo "<br /><table border=1>\n";
        echo "<tr><th>順位</th><th>名前</th><th>対戦数</th><th>勝数</th><th>勝率（%）</th></tr>\n";
        $i = 1;
        foreach ($ranking_dats as $ranking_data) {
            echo <<< EOM
<tr>
<td>{$i}</td>
<td>{$ranking_data['name']}</td>
<td>{$ranking_data['game_num']}</td>
<td>{$ranking_data['winning_num']}</td>
<td>{$ranking_data['winning_rate']}</td>
</tr>
EOM;
            ++$i;
        }
   
        $pdo = null;        // データベースとの接続を終了する
    }
    catch (PDOException $e) {
        exit($e->getMessage());
    }
?>