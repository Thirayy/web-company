<?php
require_once 'config/database.php';

try {
    $sql = "SELECT 1";
    $stmt = $db->query($sql);
    echo "Koneksi database berhasil!";
} catch(PDOException $e) {
    echo "Koneksi database gagal: " . $e->getMessage();
}
?> 