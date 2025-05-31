<?php
require_once 'config/database.php';

try {
    // Hapus admin yang ada (jika ada)
    $db->query("DELETE FROM users WHERE username = 'admin'");
    
    // Buat admin baru
    $username = 'admin';
    $password = 'admin123abc';
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
    $sql = "INSERT INTO users (username, password, email, whatsapp, full_name, role, status) 
            VALUES (:username, :password, :email, :whatsapp, :full_name, :role, :status)";
    
    $stmt = $db->prepare($sql);
    $result = $stmt->execute([
        ':username' => $username,
        ':password' => $hashed_password,
        ':email' => 'admin@cyberonly.com',
        ':whatsapp' => '081234567890', // Tambahkan nomor WhatsApp default untuk admin
        ':full_name' => 'Administrator',
        ':role' => 'admin',
        ':status' => 'active'
    ]);
    
    if($result) {
        echo "Admin berhasil dibuat!<br>";
        echo "Username: admin<br>";
        echo "Password: admin123abc<br>";
        
        // Tampilkan data admin untuk verifikasi
        $check = $db->query("SELECT * FROM users WHERE username = 'admin'")->fetch();
        echo "<br>Verifikasi data admin:<br>";
        echo "Username: " . $check['username'] . "<br>";
        echo "WhatsApp: " . $check['whatsapp'] . "<br>";
        echo "Role: " . $check['role'] . "<br>";
        echo "Status: " . $check['status'] . "<br>";
    } else {
        echo "Gagal membuat admin";
    }
    
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?> 