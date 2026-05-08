<?php
try {
    $dsn = "mysql:host=127.0.0.1;port=3306";
    $pdo = new PDO($dsn, "root", "", [PDO::ATTR_TIMEOUT => 2]);
    echo "Connection successful!\n";
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage() . "\n";
}
