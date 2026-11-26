<?php
// src/firebase_database.php
declare(strict_types=1);

use Kreait\Firebase\Factory;
use Kreait\Firebase\Contract\Database;

function database(): Database
{
    static $db = null;
    if ($db === null) {
        $key = $_ENV['FIREBASE_CREDENTIALS'] ?? '';
        $kpath = dirname(__DIR__) . '/' . $key;
        if ($key === '' || !is_file($kpath)) {
            throw new RuntimeException('Невірний .env або немає service-account.json');
        }

        $dbUrl = $_ENV['FIREBASE_DATABASE_URL'] ?? '';
        if ($dbUrl === '') {
            throw new RuntimeException('У .env не вказано FIREBASE_DATABASE_URL');
        }

        $factory = (new Factory)
            ->withServiceAccount($kpath)
            ->withDatabaseUri($dbUrl);

        $db = $factory->createDatabase();
    }
    return $db;
}

