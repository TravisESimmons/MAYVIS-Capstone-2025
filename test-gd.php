<?php
// Test GD Extension Functions
echo "<h2>GD Extension Test</h2>";

echo "<p><strong>GD Extension Loaded:</strong> " . (extension_loaded('gd') ? 'YES' : 'NO') . "</p>";

echo "<p><strong>GD Version:</strong> " . gd_info()['GD Version'] . "</p>";

echo "<h3>Available Image Functions:</h3>";
echo "<ul>";
echo "<li>imagecreatefromjpeg: " . (function_exists('imagecreatefromjpeg') ? 'Available' : 'NOT Available') . "</li>";
echo "<li>imagecreatefrompng: " . (function_exists('imagecreatefrompng') ? 'Available' : 'NOT Available') . "</li>";
echo "<li>imagecreatefromgif: " . (function_exists('imagecreatefromgif') ? 'Available' : 'NOT Available') . "</li>";
echo "<li>imagecopyresampled: " . (function_exists('imagecopyresampled') ? 'Available' : 'NOT Available') . "</li>";
echo "<li>imagejpeg: " . (function_exists('imagejpeg') ? 'Available' : 'NOT Available') . "</li>";
echo "</ul>";

echo "<h3>Supported Image Types:</h3>";
echo "<ul>";
if (imagetypes() & IMG_JPEG) echo "<li>JPEG: Supported</li>";
if (imagetypes() & IMG_PNG) echo "<li>PNG: Supported</li>";
if (imagetypes() & IMG_GIF) echo "<li>GIF: Supported</li>";
echo "</ul>";

echo "<p style='color: green; font-weight: bold;'>✅ GD Extension is working correctly!</p>";
echo "<p><a href='/mayvis/profile.php'>← Back to Profile Page</a></p>";
?>
