<?php
session_start();
include ('connection/database.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['username'];
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $password = $_POST['password'];

    $hash = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO usersignup (name, email, password) VALUES ('$name', '$email', '$hash')";

    if (mysqli_query($conn, $sql)) {
        $_SESSION['user_id'] = mysqli_insert_id($conn);
        $_SESSION['name'] = $name;
        header('Location: dashboard.php');
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>
    <div class="signup w-full h-screen flex items-center justify-center bg-gray-100">
        <div class="w-full max-w-md p-8 bg-white rounded shadow-md">
            <h1 class="text-3xl font-bold mb-4">Sign Up</h1>
            <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post" class="flex flex-col gap-4">
                <input type="text" name="username" placeholder="Username" require class="border p-2 rounded">
                <input type="email" name="email" placeholder="Email" require class="border p-2 rounded">
                <input type="password" name="password" placeholder="Password" require class="border p-2 rounded">
                <button type="submit" class="bg-green-500 text-white p-2 rounded">Sign Up</button>
                <p>Have an account? <a href="index.php" class="text-blue-500">Login</a></p>
            </form>
        </div>
    </div>
</body>



</html>