
<?php
include ('connection/database.php');
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Patient Registration</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen bg-linear-to-br from-blue-50 to-cyan-100 flex items-center justify-center p-6">

    <div class="w-full max-w-lg bg-white rounded-2xl shadow-xl p-8">

        <!-- Header -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-blue-100 rounded-full mb-4">
                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" stroke-width="2"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
            </div>
            <h1 class="text-2xl font-bold text-gray-800">Patient Registration</h1>
            <p class="text-sm text-gray-500 mt-1">Fill in your details to register</p>
        </div>

        <form action="home.php" method="POST" class="space-y-5">

            <!-- Full Name -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                <input type="text" id="name" name="name" placeholder="Enter your full name" required
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent transition" />
            </div>

            <!-- Age -->
            <div>
                <label for="age" class="block text-sm font-medium text-gray-700 mb-1">Age</label>
                <input type="number" id="age" name="age" placeholder="Enter your age" min="1" max="120" required
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent transition" />
            </div>

            <!-- Gender -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Gender</label>
                <div class="flex gap-6">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="radio" name="gender" value="male" required class="accent-blue-500 w-4 h-4" />
                        <span class="text-sm text-gray-700">Male</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="radio" name="gender" value="female" class="accent-blue-500 w-4 h-4" />
                        <span class="text-sm text-gray-700">Female</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="radio" name="gender" value="other" class="accent-blue-500 w-4 h-4" />
                        <span class="text-sm text-gray-700">Other</span>
                    </label>
                </div>
            </div>

            <!-- Disease -->
            <div>
                <label for="disease" class="block text-sm font-medium text-gray-700 mb-1">Disease / Condition</label>
                <input type="text" id="disease" name="disease" placeholder="e.g. Diabetes, Hypertension" required
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent transition" />
            </div>

            <!-- Contact -->
            <div>
                <label for="contact" class="block text-sm font-medium text-gray-700 mb-1">Contact Number</label>
                <input type="tel" id="contact" name="contact" placeholder="+92 300 0000000" required
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent transition" />
            </div>

            <!-- Select Doctor -->
            <div>
                <label for="doctor" class="block text-sm font-medium text-gray-700 mb-1">Select Doctor</label>
                <div class="relative">
                    <select id="doctor" name="doctor" required
                        class="w-full appearance-none px-4 py-2.5 pr-10 border border-gray-300 rounded-lg text-sm text-gray-600 bg-white focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent transition cursor-pointer">
                        <option value="" disabled selected>-- Choose a doctor --</option>
                        <?php
                        try {
                            $sql = 'SELECT * FROM doctorsignup';
                            $res = mysqli_query($conn, $sql);
                            if (mysqli_num_rows($res) > 0) {
                                while ($row = mysqli_fetch_assoc($res)) {
                                    echo "<option value='" . htmlspecialchars($row['name']) . "' id='" . htmlspecialchars($row['doctorID']) . "' >"
                                        . htmlspecialchars($row['name']) . ' - '
                                        . htmlspecialchars($row['designation'])
                                        . '</option>';
                                }
                            } else {
                                echo "<option value='' disabled>No doctors available</option>";
                            }
                        } catch (\Throwable $th) {
                            die('ERROR IN REGISTRATION FORM: ' . $th->getMessage());
                        }
                        ?>
                    </select>
                    <!-- Chevron Icon -->
                    <div class="pointer-events-none absolute inset-y-0 right-3 flex items-center">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Submit -->
            <button type="submit"
                class="w-full bg-blue-600 hover:bg-blue-700 active:bg-blue-800 text-white font-semibold py-3 rounded-lg transition text-sm tracking-wide mt-2">
                Register Patient
            </button>

            <!-- Back to Dashboard -->
            <p class="text-center text-sm text-gray-500 mt-2">
                Changed your mind?
                <a href="dashboard.php" class="text-blue-600 hover:underline font-medium">&larr; Back to Dashboard</a>
            </p>

        </form>
    </div>

</body>

</html>