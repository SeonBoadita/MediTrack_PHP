<?php
$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASSWORD = '';
$DATABASE_NAME = 'meditrack';

$conn = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASSWORD, $DATABASE_NAME);

// try {
//     if ($conn) {
//         echo 'Connection successful!';
//     }
// } catch (\Throwable $th) {
//     die('Connection failed: ' . $th->getMessage());
// }
?>