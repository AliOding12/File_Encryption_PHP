<?php
require_once __DIR__ . '/includes/db_connect.php';
require_once __DIR__ . '/includes/encryption.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    http_response_code(400);
    die("Invalid file ID");
}//main file

try {
    $pdo = getDbConnection();
    $stmt = $pdo->prepare("SELECT original_filename, encrypted_filename, encryption_key, iv, mime_type FROM files WHERE id = ?");
    $stmt->execute([$_GET['id']]);
    $fileData = $stmt->fetch();

    if (!$fileData) {
        http_response_code(404);
        die("File not found");
    }

    $filePath = __DIR__ . '/uploads/encrypted_files/' . $fileData['encrypted_filename'];
    if (!file_exists($filePath)) {
        http_response_code(404);
        die("Encrypted file missing");
    }

    $encryptedData = file_get_contents($filePath);
    $decryptedData = decryptFile($encryptedData, $fileData['encryption_key'], $fileData['iv']);

    if ($decryptedData === false) {
        http_response_code(500);
        die("Decryption failed");
    }

    header('Content-Type: ' . $fileData['mime_type']);
    header('Content-Disposition: attachment; filename="' . basename($fileData['original_filename']) . '"');
    header('Content-Length: ' . strlen($decryptedData));
    echo $decryptedData;
    exit;
} catch (Exception $e) {
    http_response_code(500);
    die("Error: " . $e->getMessage());
}
?>// Add initial file download logic in download.php
// Add decryption support to download.php
