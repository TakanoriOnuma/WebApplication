<?php
    require_once 'myDataBase.php';      // データベースアクセスクラスの読み込み

    try {
        $pdo = myDataBase::createPDO();
        $pdo->query('SET NAMES utf8');

        $stmt = $pdo->query("SELECT * FROM game_scores");

        // ランキングデータを生成する
        $ranking_dats = array();
        while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $data['name'] = get_nickname($data['number']);

            if ($data['game_num'] == 0) {
                // 降順をしやすくするためとりあえず-1にする
                $data['winning_rate'] = -1;
            }
            else {
                $data['winning_rate'] = ($data['winning_num'] / $data['game_num']) * 100;
            }
            $ranking_dats[] = $data;
        }

        // 降順にしたい列名
        $element_name = $_POST['element'];

        // 列方向の配列を得る
        foreach ($ranking_dats as $key => $row) {
            $desc_array[$key]  = $row[$element_name];
        }

        // $elementの列を降順にする
        array_multisort($desc_array, SORT_DESC, $ranking_dats);

        // テーブルとして出力
        echo "<table border=1>\n";
        echo "<tr><th>順位</th><th>名前</th><th>対戦数</th><th>勝数</th><th>勝率（%）</th></tr>\n";
        $i = 1;
        $ranking = 1;
        $prev_element = "";        // 1つ前の順位の人のデータ
        foreach ($ranking_dats as $ranking_data) {
            // -1（計算不能）を'-'の出力に変更する
            if ($ranking_data['winning_rate'] == -1) {
                $ranking_data['winning_rate'] = '-';
            }

            // もし前の列データの値と違っているなら
            if ($prev_element !== $ranking_data[$element_name]) {
                $ranking = $i;      // 順位を今の行番号にする
            }

            // 1行分を出力
            echo <<< EOM
<tr>
<td>{$ranking}</td>
<td>{$ranking_data['name']}</td>
<td>{$ranking_data['game_num']}</td>
<td>{$ranking_data['winning_num']}</td>
<td>{$ranking_data['winning_rate']}</td>
</tr>
EOM;
            // 前のデータを更新する
            $prev_element = $ranking_data[$element_name];
            ++$i;       // 行数を1つ進める
        }
        echo "</table>\n";
   
        $pdo = null;        // データベースとの接続を終了する
    }
    catch (PDOException $e) {
        exit($e->getMessage());
    }
?>