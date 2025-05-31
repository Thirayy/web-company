<?php
require_once 'config/database.php';

try {
    // Cek koneksi database
    echo "Status koneksi database: ";
    $db->getAttribute(PDO::ATTR_CONNECTION_STATUS) ? 
        print "Terhubung<br>" : 
        print "Gagal<br>";
    
    // Cek apakah tabel users ada
    $stmt = $db->query("SHOW TABLES LIKE 'users'");
    echo "Tabel users: ";
    $stmt->rowCount() > 0 ? 
        print "Ada<br>" : 
        print "Tidak ada<br>";
    
    // Jika tabel ada, cek struktur
    if($stmt->rowCount() > 0) {
        $stmt = $db->query("DESCRIBE users");
        echo "<br>Struktur tabel users:<br>";
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo $row['Field'] . " - " . $row['Type'] . "<br>";
        }
    }
    
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?> 