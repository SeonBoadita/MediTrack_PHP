<?php
session_start();
include ('../connection/database.php');

try {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        $password = $_POST['password'];
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $designation = $_POST['designation'];
        $contact = filter_input(INPUT_POST, 'contact', FILTER_SANITIZE_NUMBER_INT);
        $gender = $_POST['gender'];

        $querry = "INSERT INTO doctorsignup (name, email, password, gender, contact, designation) VALUES ('$name', '$email', '$hash', '$gender', '$contact', '$designation')";

        if (mysqli_query($conn, $querry)) {
            $_SESSION['admin_id'] = mysqli_insert_id($conn);
            $_SESSION['admin_name'] = $name;
            header('Location: admin.php');
            exit();
        }
    }
} catch (\Throwable $th) {
    die('ERROR IN ADMIN SIGNUP: ' . $th);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Sign Up</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen bg-gray-100 flex items-center justify-center py-10">

    <div class="w-full max-w-lg bg-white rounded-2xl shadow-lg p-8">
        <h1 class="text-3xl font-bold text-indigo-600 mb-1">Admin Sign Up</h1>
        <p class="text-gray-400 text-sm mb-6">Create your admin account</p>

        <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post" class="flex flex-col gap-5">

            <!-- Name -->
            <div class="flex flex-col gap-1">
                <label class="text-sm font-semibold text-gray-600">Full Name</label>
                <input type="text" name="name" placeholder="Name"
                    class="border border-gray-300 rounded-lg p-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-400">
            </div>

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

            <!-- Designation -->
            <div class="flex flex-col gap-1">
                <label class="text-sm font-semibold text-gray-600">Designation</label>
                <select name="designation"
                    class="border border-gray-300 rounded-lg p-2.5 text-gray-600 focus:outline-none focus:ring-2 focus:ring-indigo-400">
                    <option value="" disabled selected>Select designation</option>
                    <option value="doctor">Doctor</option>
                    <option value="nurse">Nurse</option>
                    <option value="pharmacist">Pharmacist</option>
                    <option value="receptionist">Receptionist</option>
                    <option value="manager">Manager</option>
                </select>
            </div>

            <!-- Contact -->
            <div class="flex flex-col gap-1">
                <label class="text-sm font-semibold text-gray-600">Contact Number</label>
                <input type="tel" name="contact" placeholder="+1 555 000 0000"
                    class="border border-gray-300 rounded-lg p-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-400">
            </div>

            <!-- Gender -->
            <div class="flex flex-col gap-2">
                <label class="text-sm font-semibold text-gray-600">Gender</label>
                <div class="flex gap-6">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="radio" name="gender" value="male" class="accent-indigo-600 w-4 h-4">
                        <span class="text-gray-600">Male</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="radio" name="gender" value="female" class="accent-indigo-600 w-4 h-4">
                        <span class="text-gray-600">Female</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="radio" name="gender" value="other" class="accent-indigo-600 w-4 h-4">
                        <span class="text-gray-600">Other</span>
                    </label>
                </div>
            </div>



            <button type="submit"
                class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold p-3 rounded-lg transition">
                Sign Up
            </button>

            <p class="text-center text-sm text-gray-500">Already have an account? <a href="adminlogin.php"
                    class="text-indigo-600 hover:underline">Login</a></p>

        </form>
    </div>

</body>

</html>