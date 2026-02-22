<?php
include ('connection/database.php');

session_start();

    if (!isset($_SESSION['user_id'])) {
        header('Location: index.php');
        exit();
    }

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Patient Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen bg-gray-100 font-sans">

    <!-- Top Navbar -->
    <nav class="bg-white shadow-sm px-6 py-4 flex items-center justify-between">
        <div class="flex items-center gap-3">
            <div class="w-9 h-9 bg-blue-600 rounded-lg flex items-center justify-center">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                </svg>
            </div>
            <span class="text-lg font-bold text-gray-800">MediCare</span>
        </div>
        <div class="flex items-center gap-4">
            <span class="text-sm text-gray-500 hidden sm:block">Welcome back, <span
                    class="font-semibold text-gray-700"><?php echo $_SESSION['name']; ?></span></span>
            <a href="index.php"
                class="text-sm text-red-500 hover:text-red-600 font-medium flex items-center gap-1 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
                Logout
            </a>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="max-w-5xl mx-auto px-4 py-10">

        <!-- Hero / Welcome Card -->
        <div
            class="bg-gradient-to-r from-blue-600 to-cyan-500 rounded-2xl p-8 text-white mb-8 flex flex-col sm:flex-row items-center justify-between gap-6 shadow-lg">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold mb-2">Hello, <?php echo $_SESSION['name']; ?> 👋</h1>
                <p class="text-blue-100 text-sm sm:text-base max-w-md">
                    You're logged in. To get started, register your details and select your doctor. Our team is here to
                    help you.
                </p>
            </div>
            <div class="shrink-0">
                <div class="w-20 h-20 bg-white/20 rounded-full flex items-center justify-center">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" stroke-width="1.5"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Action Card — Register -->
        <div
            class="bg-white rounded-2xl shadow-sm p-8 flex flex-col sm:flex-row items-center justify-between gap-6 border border-dashed border-blue-300">
            <div class="flex items-start gap-4">
                <div class="w-14 h-14 bg-blue-50 rounded-xl flex items-center justify-center shrink-0">
                    <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                    </svg>
                </div>
                <div>
                    <h2 class="text-lg font-semibold text-gray-800">Complete Your Registration</h2>
                    <p class="text-sm text-gray-500 mt-1">
                        Register your personal details, medical condition, and choose your preferred doctor to proceed.
                    </p>
                </div>
            </div>
            <a href="register.php"
                class="shrink-0 bg-blue-600 hover:bg-blue-700 active:bg-blue-800 text-white text-sm font-semibold px-6 py-3 rounded-xl transition shadow-md whitespace-nowrap">
                Register Now &rarr;
            </a>
        </div>

        <!-- Info Strip -->
        <div class="mt-8 grid grid-cols-1 sm:grid-cols-3 gap-4 text-center">
            <div class="bg-white rounded-xl p-5 shadow-sm">
                <div class="text-2xl mb-2">🏥</div>
                <p class="text-sm font-medium text-gray-700">24/7 Support</p>
                <p class="text-xs text-gray-400 mt-1">Always available for you</p>
            </div>
            <div class="bg-white rounded-xl p-5 shadow-sm">
                <div class="text-2xl mb-2">🩺</div>
                <p class="text-sm font-medium text-gray-700">Specialist Doctors</p>
                <p class="text-xs text-gray-400 mt-1">Across multiple departments</p>
            </div>
            <div class="bg-white rounded-xl p-5 shadow-sm">
                <div class="text-2xl mb-2">🔒</div>
                <p class="text-sm font-medium text-gray-700">Secure & Private</p>
                <p class="text-xs text-gray-400 mt-1">Your data is protected</p>
            </div>
        </div>

    </main>

    <!-- Footer -->
    <footer class="text-center text-xs text-gray-400 py-6">
        &copy; 2026 MediCare. All rights reserved.
    </footer>

</body>

</html>