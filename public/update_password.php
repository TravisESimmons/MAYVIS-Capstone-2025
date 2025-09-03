<?php
include 'connect.php';

$new_password = 'test123';
$new_hash = password_hash($new_password, PASSWORD_DEFAULT);

$sql = "UPDATE users SET user_password_hash = ? WHERE user_name = 'TestClient'";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $new_hash);

if ($stmt->execute()) {
    echo "Password updated successfully!\n";
    echo "Username: TestClient\n";
    echo "Password: " . $new_password . "\n";
    echo "New Hash: " . $new_hash . "\n";
} else {
    echo "Error updating password: " . $conn->error . "\n";
}

$stmt->close();
$conn->close();
?>
