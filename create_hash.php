<?php
// Fjalëkalimi që do përdorësh
$password_plain = "admin123"; 

// Krijo hash
$hash = password_hash($password_plain, PASSWORD_DEFAULT);

echo "Ky është hash-i që duhet të vendosësh në databazë: <br>";
echo $hash;
?>
