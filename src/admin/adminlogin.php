<?php
session_start();
include ('../connection/database.php');
$error = '';
try {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $email = trim($_POST['email']);
        $password = $_POST['password'];

        $email = mysqli_real_escape_string($conn, $email);

        $sql = "SELECT * FROM doctorsignup WHERE TRIM(email) = '$email'";
        $res = mysqli_query($conn, $sql);
        if (mysqli_num_rows($res) > 0) {
            $admin = mysqli_fetch_assoc($res);
            if (password_verify($password, $admin['password'])) {
                $_SESSION['admin_id'] = $admin['doctorID'];
                $_SESSION['admin_name'] = $admin['name'];
                header('Location: admin.php');
                exit();
            } else {
                $error = 'Please check your password.';
            }
        } else {
            $error = 'No admin found.';
        }
    }
} catch (\Throwable $th) {
    die('ERROR IN ADMIN LOGIN: ' . $th);
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen bg-gray-100 flex items-center justify-center">

    <div class="w-full max-w-md bg-white rounded-2xl shadow-lg p-8">
        <h1 class="text-3xl font-bold text-indigo-600 mb-1">Admin Login</h1>
        <p class="text-gray-400 text-sm mb-6">Sign in to your admin account</p>

        <form action='<?= $_SERVER['PHP_SELF'] ?>' method='post' class="flex flex-col gap-5">

            <!-- Email -->
            <div class="flex flex-col gap-1">
                <label class="text-sm font-semibold text-gray-600">Email</label>
                <input type="email" name="email" placeholder="admin@example.com"
                    class="border border-gray-300 rounded-lg p-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-400">
            </div>

            <!-- Password -->
            <div class="flex flex-col gap-1">
                <label class="text-sm font-semibold text-gray-600">Password</label>
                <input type="password" name="password" placeholder="••••••••"
                    class="border border-gray-300 rounded-lg p-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-400">
            </div>

            <button type="submit"
                class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold p-3 rounded-lg transition">
                Login
            </button>

            <p class="text-center text-sm text-gray-500">Don't have an account? <a href="adminsignup.php"
                    class="text-indigo-600 hover:underline">Sign Up</a></p>
                <?php if ($error): ?>
                    <p class="text-red-500 font-semibold mt-2"><?= $error ?></p>
                <?php endif; ?>

        </form>
    </div>

</body>

</html>