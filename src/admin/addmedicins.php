<?php
session_start();
include ('../connection/database.php');
try {
    if (isset($_GET['id'])) {
        $patient_id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
        $dummy_id = filter_input(INPUT_GET, 'uid', FILTER_SANITIZE_NUMBER_INT);
        // echo"id: " .$_GET['id'] . "pid: " . $patient_id;

        $sql = "SELECT * FROM `user_register` WHERE id =$patient_id";
        $res = mysqli_query($conn, $sql);

        if (mysqli_num_rows($res) > 0) {
            $row = mysqli_fetch_assoc($res);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Medicines - Doctor View</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen bg-linear-to-br from-blue-50 to-indigo-100">
    <!-- Navbar -->
    <nav class="bg-white shadow">
        <div class="max-w-6xl mx-auto px-4 py-4 flex items-center justify-between">
            <a href="admin.php" class="text-2xl font-bold text-indigo-600">MediTrack <span
                    class="text-sm font-normal text-gray-400">Admin &rsaquo; <?= $row['user_name'] ?></span></a>
            <div class="flex gap-4 text-sm">
                <a href="admin.php" class="text-gray-500 hover:text-indigo-600 transition">&larr; Back to Dashboard</a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="max-w-4xl mx-auto px-4 py-10">
        <!-- Patient Info Card -->
        <div class="bg-white rounded-2xl shadow-lg p-6 mb-8">
            <div class="flex items-center gap-4">
                <div
                    class="w-14 h-14 bg-indigo-100 rounded-full flex items-center justify-center text-indigo-600 text-2xl font-bold">
                    JD</div>
                <div>
                    <h1 class="text-2xl font-bold text-gray-800"><?= $row['user_name'] ?></h1>
                    <p class="text-sm text-gray-500">Patient ID: P<?= $dummy_id ?> &bull; Age:  <?= $row['user_age'] ?> &bull; Diagnosis: <?= $row['user_disease'] ?></p>
                </div>
            </div>
        </div>

        <!-- Current Medicines -->
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden mb-8">
            <div class="bg-indigo-600 px-6 py-4">
                <h2 class="text-lg font-semibold text-white">Current Medicines</h2>
                <p class="text-indigo-200 text-sm">Update dosage/schedule inline or delete a medicine</p>
            </div>

            <!-- Medicine Row 1 -->
            <div
                class="border-b border-gray-100 px-6 py-4 flex flex-wrap items-center gap-4 hover:bg-indigo-50 transition">
                <div class="flex-1 min-w-0">
                    <p class="font-semibold text-gray-800">Paracetamol</p>
                    <p class="text-xs text-gray-500">500mg &bull; 08:00 AM</p>
                </div>
                <form method="post" action="#" class="flex items-center gap-2">
                    <input type="text" name="medicine" value="Paracetamol"
                        class="border border-gray-300 rounded-lg px-3 py-2 text-sm w-32 focus:ring-2 focus:ring-indigo-300 focus:border-indigo-400 outline-none"
                        required>
                    <input type="text" name="dosage" value="500mg"
                        class="border border-gray-300 rounded-lg px-3 py-2 text-sm w-24 focus:ring-2 focus:ring-indigo-300 focus:border-indigo-400 outline-none"
                        required>
                    <input type="text" name="schedule" value="08:00 AM"
                        class="border border-gray-300 rounded-lg px-3 py-2 text-sm w-28 focus:ring-2 focus:ring-indigo-300 focus:border-indigo-400 outline-none"
                        required>
                    <button type="submit"
                        class="bg-amber-500 text-white text-sm px-4 py-2 rounded-lg hover:bg-amber-600 transition font-medium">Update</button>
                </form>
                <form method="post" action="#">
                    <button type="submit"
                        class="bg-red-500 text-white text-sm px-4 py-2 rounded-lg hover:bg-red-600 transition font-medium">Delete</button>
                </form>
            </div>

            <!-- Medicine Row 2 -->
            <div
                class="border-b border-gray-100 px-6 py-4 flex flex-wrap items-center gap-4 hover:bg-indigo-50 transition">
                <div class="flex-1 min-w-0">
                    <p class="font-semibold text-gray-800">Ibuprofen</p>
                    <p class="text-xs text-gray-500">200mg &bull; 12:00 PM</p>
                </div>
                <form method="post" action="#" class="flex items-center gap-2">
                    <input type="text" name="medicine" value="Ibuprofen"
                        class="border border-gray-300 rounded-lg px-3 py-2 text-sm w-32 focus:ring-2 focus:ring-indigo-300 focus:border-indigo-400 outline-none"
                        required>
                    <input type="text" name="dosage" value="200mg"
                        class="border border-gray-300 rounded-lg px-3 py-2 text-sm w-24 focus:ring-2 focus:ring-indigo-300 focus:border-indigo-400 outline-none"
                        required>
                    <input type="text" name="schedule" value="12:00 PM"
                        class="border border-gray-300 rounded-lg px-3 py-2 text-sm w-28 focus:ring-2 focus:ring-indigo-300 focus:border-indigo-400 outline-none"
                        required>
                    <button type="submit"
                        class="bg-amber-500 text-white text-sm px-4 py-2 rounded-lg hover:bg-amber-600 transition font-medium">Update</button>
                </form>
                <form method="post" action="#">
                    <button type="submit"
                        class="bg-red-500 text-white text-sm px-4 py-2 rounded-lg hover:bg-red-600 transition font-medium">Delete</button>
                </form>
            </div>
        </div>

        <!-- Add New Medicine -->
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
            <div class="bg-green-600 px-6 py-4">
                <h2 class="text-lg font-semibold text-white">Add New Medicine</h2>
                <p class="text-green-200 text-sm">Prescribe a new medicine for this patient</p>
            </div>
            <div class="p-6">
                <form method="post" action="#" class="flex flex-wrap items-end gap-4">
                    <div class="flex-1 min-w-37.5">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Medicine Name</label>
                        <input type="text" name="medicine" placeholder="e.g. Amoxicillin"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-green-300 focus:border-green-400 outline-none"
                            required>
                    </div>
                    <div class="w-28">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Dosage</label>
                        <input type="text" name="dosage" placeholder="e.g. 250mg"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-green-300 focus:border-green-400 outline-none"
                            required>
                    </div>
                    <div class="w-32">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Schedule</label>
                        <input type="text" name="schedule" placeholder="e.g. 06:00 PM"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-green-300 focus:border-green-400 outline-none"
                            required>
                    </div>
                    <button type="submit"
                        class="bg-green-600 text-white px-6 py-2 rounded-lg font-semibold hover:bg-green-700 transition shadow">
                        Add Medicine
                    </button>
                </form>
            </div>
        </div>

        <!-- Back Link -->
        <div class="mt-8 text-center">
            <a href="admin.php" class="text-indigo-600 hover:text-indigo-800 font-medium transition">&larr; Back to
                Admin Dashboard</a>
        </div>
    </main>
</body>
<?php
        }
    }
} catch (\Throwable $th) {
    die('ERROR IN ADD MEDICINS PAGE: ' . $th);
}

?>
</html>