<?php
function decryptFile($encryptedData, $key, $iv) {
    return openssl_decrypt($encryptedData, 'AES-256-CBC', $key, OPENSSL_RAW_DATA, $iv);
}//can change the cipher_algo to what ever method 
?>// Add encryption helper functions in encryption.php
// Implement decryption functions in encryption.php
// Optimize encryption performance
// Add key rotation support in encryption.php
