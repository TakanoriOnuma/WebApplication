<?php
    $othello_data = $_POST['othello_data'];

    file_put_contents("gamefield.dat", $othello_data);
?>