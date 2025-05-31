<?php
require_once 'config/database.php';

try {
    $stmt = $db->query("SELECT id, username, email, whatsapp, role, status, created_at FROM users");
    echo "<h2>Daftar Users</h2>";
    echo "<table border='1'>";
    echo "<tr><th>ID</th><th>Username</th><th>Email</th><th>WhatsApp</th><th>Role</th><th>Status</th><th>Created</th></tr>";
    
    while($row = $stmt->fetch()) {
        echo "<tr>";
        echo "<td>" . $row['id'] . "</td>";
        echo "<td>" . $row['username'] . "</td>";
        echo "<td>" . $row['email'] . "</td>";
        echo "<td>" . $row['whatsapp'] . "</td>";
        echo "<td>" . $row['role'] . "</td>";
        echo "<td>" . $row['status'] . "</td>";
        echo "<td>" . $row['created_at'] . "</td>";
        echo "</tr>";
    }
    
    echo "</table>";
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?> 