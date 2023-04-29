<?php

    try {
        $pdo = new PDO(DATABASE_CONFIG['drive'].':host='.DATABASE_CONFIG['host'].';dbname='.DATABASE_CONFIG['dbname'], DATABASE_CONFIG['user'], DATABASE_CONFIG['pass']);
        $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        die('ERROR:' . $e->getMessage());
    }