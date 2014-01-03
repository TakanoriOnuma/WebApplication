<?php
    final class myDataBase {
        const DB_NAME = 'phpdb';
        const IP_ADDRESS = '127.0.0.1';
        const ID = 'root';
        const PW = 'ayashi';

        public static function createPDO() {
            return new PDO('mysql:dbname=' . myDataBase::DB_NAME . ';host=' . myDataBase::IP_ADDRESS, myDataBase::ID, myDataBase::PW, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
        } 
    }
?>