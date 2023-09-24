<?php
require_once __DIR__ . '/../vendor/autoload.php'; // Optional: for phpdotenv
require_once __DIR__ .'../.env';
$dotenv = $dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

return [
    'host' => $_ENV['DB_HOST'] ?? 'localhost',
    'database' => $_ENV['DB_NAME'] ?? 'file_storage',
    'username' => $_ENV['DB_USER'] ?? 'root',
    'password' => $_ENV['DB_PASS'] ?? '',
];//this is not the right one can change the localhost etc 
?>// Add database configuration in database.php
// Add connection pooling configuration
// Add database backup configuration
