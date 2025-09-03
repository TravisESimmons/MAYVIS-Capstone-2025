<?php
/**
 * Create Test Users for MAYVIS System
 * Run this once to create demo accounts for testing
 */

// Use the main database connection
require_once("connect.php");

// Use $conn from connect.php (not $connection)
$connection = $conn;

if (!$connection) {
    die("Database connection failed: " . mysqli_connect_error());
}

echo "<style>
body { font-family: 'Inter', sans-serif; margin: 2rem; background: #f8fafc; }
.container { background: white; padding: 2rem; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); }
h2 { color: #1f2937; margin-bottom: 1.5rem; }
p { margin: 0.5rem 0; }
hr { margin: 1rem 0; border: 1px solid #e5e7eb; }
code { background: #f3f4f6; padding: 2px 6px; border-radius: 4px; font-family: monospace; }
.success { color: #10b981; } .warning { color: #f59e0b; } .error { color: #ef4444; } .info { color: #3b82f6; }
.summary { background: #f0f9ff; padding: 1rem; border-radius: 8px; border-left: 4px solid #3b82f6; }
.btn { display: inline-block; background: #6366f1; color: white; padding: 10px 20px; text-decoration: none; border-radius: 8px; margin-top: 1rem; }
</style>";

echo "<div class='container'>";
echo "<h2>🚀 Creating Test Users for MAYVIS</h2>\n";
$test_users = [
    [
        'user_name' => 'admin',
        'first_name' => 'Admin',
        'last_name' => 'User',
        'user_email' => 'admin@mayvis.com',
        'user_password' => 'admin123',
        'user_status' => 1 // Employee/Admin
    ],
    [
        'user_name' => 'client1',
        'first_name' => 'John',
        'last_name' => 'Doe',
        'user_email' => 'john@example.com',
        'user_password' => 'client123',
        'user_status' => 0 // Client
    ],
    [
        'user_name' => 'testuser',
        'first_name' => 'Test',
        'last_name' => 'User',
        'user_email' => 'test@test.com',
        'user_password' => 'test123',
        'user_status' => 0 // Client
    ]
];

echo "<h2>Creating Test Users for MAYVIS</h2>\n";

foreach ($test_users as $user) {
    // Check if user already exists
    $check_sql = "SELECT user_id FROM users WHERE user_name = ? OR user_email = ?";
    $check_stmt = $connection->prepare($check_sql);
    $check_stmt->bind_param("ss", $user['user_name'], $user['user_email']);
    $check_stmt->execute();
    $result = $check_stmt->get_result();
    
    if ($result->num_rows > 0) {
        echo "<p class='warning'>⚠️ User '{$user['user_name']}' already exists - skipping</p>\n";
        continue;
    }
    
    // Hash the password
    $password_hash = password_hash($user['user_password'], PASSWORD_DEFAULT);
    
    // Insert new user
    $sql = "INSERT INTO users (user_name, first_name, last_name, user_email, user_password_hash, user_status, notifications) 
            VALUES (?, ?, ?, ?, ?, ?, '1')";
    
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("sssssi", 
        $user['user_name'], 
        $user['first_name'], 
        $user['last_name'], 
        $user['user_email'], 
        $password_hash, 
        $user['user_status']
    );
    
    if ($stmt->execute()) {
        $user_id = $connection->insert_id;
        echo "<p class='success'>✅ Created user: <strong>{$user['user_name']}</strong> (ID: {$user_id})</p>\n";
        echo "<p style='margin-left: 20px;'>📛 Name: {$user['first_name']} {$user['last_name']}<br>";
        echo "📧 Email: {$user['user_email']}<br>";
        echo "🔑 Password: <code>{$user['user_password']}</code><br>";
        echo "👤 Role: " . ($user['user_status'] == 0 ? 'Client' : 'Employee/Admin') . "</p>\n";
        
        // If it's an employee, create employee record
        if ($user['user_status'] == 1) {
            $emp_sql = "INSERT INTO employees (employee_first_name, employee_last_name, user_id) VALUES (?, ?, ?)";
            $emp_stmt = $connection->prepare($emp_sql);
            $emp_stmt->bind_param("ssi", $user['first_name'], $user['last_name'], $user_id);
            if ($emp_stmt->execute()) {
                echo "<p style='margin-left: 20px;' class='info'>➕ Created employee record</p>\n";
            }
        }
        
        // If it's a client, create client record
        if ($user['user_status'] == 0) {
            $client_name = $user['first_name'] . ' ' . $user['last_name'];
            $client_sql = "INSERT INTO clients (client_name) VALUES (?)";
            $client_stmt = $connection->prepare($client_sql);
            $client_stmt->bind_param("s", $client_name);
            if ($client_stmt->execute()) {
                echo "<p style='margin-left: 20px;' class='info'>➕ Created client record</p>\n";
            }
        }
        
    } else {
        echo "<p class='error'>❌ Failed to create user: {$user['user_name']} - " . $stmt->error . "</p>\n";
    }
    
    echo "<hr>\n";
}

echo "<h3>📋 Test Accounts Summary:</h3>\n";
echo "<div class='summary'>\n";
echo "<h4>🔧 Admin/Employee Account:</h4>\n";
echo "<p><strong>Username:</strong> <code>admin</code><br><strong>Password:</strong> <code>admin123</code></p>\n";
echo "<h4>👤 Client Accounts:</h4>\n";
echo "<p><strong>Username:</strong> <code>client1</code> | <strong>Password:</strong> <code>client123</code><br>\n";
echo "<strong>Username:</strong> <code>testuser</code> | <strong>Password:</strong> <code>test123</code></p>\n";
echo "</div>\n";

echo "<a href='/mayvis/login/index.php' class='btn'>🔐 Go to Login Page</a>\n";
echo "<a href='/mayvis/' class='btn' style='margin-left: 10px;'>🏠 Go to Home Page</a>\n";
echo "</div>";
?>
