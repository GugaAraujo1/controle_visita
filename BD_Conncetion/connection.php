<?php
// Certifique-se de que não há saída antes de session_start()
session_start();

require __DIR__ . '/../vendor/autoload.php';

Dotenv\Dotenv::createUnsafeImmutable(__DIR__ . '/../')->load();

try {
    $dbDB = new PDO('sqlsrv:Server=' . getenv('DB_HOST') . ';Database=' . getenv('DB_DATABASE'), getenv('DB_USERNAME'), getenv('DB_PASSWORD'));
    $dbDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Não precisa do return aqui, a conexão já está estabelecida
} catch (PDOException $e) {
    echo "Erro na conexão: " . $e->getMessage();
    // Se ocorrer um erro de conexão, você pode querer encerrar o script ou tratar de outra forma
    exit();
}