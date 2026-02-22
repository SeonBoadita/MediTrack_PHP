<?php
session_start();
include ('connection/database.php');

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // 1. Prevent SQL injection
    $email = mysqli_real_escape_string($conn, $email);

    // 2. The TRIM() command forces MySQL to ignore any hidden spaces in the database!
    $sql = "SELECT * FROM usersignup WHERE TRIM(email) = '$email'";
    $res = mysqli_query($conn, $sql);

    if (!$res) {
        $error = 'Database Error: ' . mysqli_error($conn);
    } elseif (mysqli_num_rows($res) > 0) {
        $user = mysqli_fetch_assoc($res);

        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['userID'];
            $_SESSION['name'] = $user['name'];

            header('Location: dashboard.php');
            exit();
        } else {
            $error = 'Wrong Password';
        }
    } else {
        $error = 'SYSTEM ALERT: Account missing for -> ' . htmlspecialchars($email);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
    <div class="login w-full h-screen flex items-center justify-center bg-gray-100">
        <div class="w-full max-w-md p-8 bg-white rounded shadow-md">
            <h1 class="text-3xl font-bold mb-4">Login</h1>
            
            <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post" class="flex flex-col gap-4">
                <input type="email" name="email" placeholder="Email" required class="border p-2 rounded">
                <input type="password" name="password" placeholder="Password" required class="border p-2 rounded">
                <button type="submit" class="bg-blue-500 text-white p-2 rounded hover:bg-blue-600 transition">Login</button>
                
                <p>Don't have an account? <a href="signup.php" class="text-green-500 hover:underline">Sign Up</a></p>
                
                <?php if ($error): ?>
                    <p class="text-red-500 font-semibold mt-2"><?= $error ?></p>
                <?php endif; ?>
            </form>
            
        </div>
    </div>
</body>
</html>