<?php
include ('connection/database.php');

echo '<h2>Database Truth Checker</h2>';

$query = 'SELECT * FROM usersignup';
$result = mysqli_query($conn, $query);

if (!$result) {
    echo 'Error querying database: ' . mysqli_error($conn);
} else {
    $count = mysqli_num_rows($result);
    echo "<strong>Total users found in the database: $count</strong><br><br>";

    if ($count > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo 'ID: ' . $row['userID'] . '<br>';
            echo "Name: '" . $row['name'] . "'<br>";
            echo "Email: '" . $row['email'] . "'<br>";
            echo 'Password Hash Length: ' . strlen($row['password']) . '<br>';
            echo '<hr>';
        }
    } else {
        echo "<span style='color:red;'>Your usersignup table is completely empty! Your signup page didn't actually save the data.</span>";
    }
}
?>