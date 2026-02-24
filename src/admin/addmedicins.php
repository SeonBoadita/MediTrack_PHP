<?php
session_start();
include ('../connection/database.php');
try {
    if (empty($_SESSION['admin_id'])) {
        header('Location: adminlogin.php');
        exit();
    }
    $patient_id = (int) filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
    $dummy_id = (int) filter_input(INPUT_GET, 'uid', FILTER_SANITIZE_NUMBER_INT);

    
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_medicine'])) {
        $med_name = filter_input(INPUT_POST, 'medicine', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $dosage = filter_input(INPUT_POST, 'dosage', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $schedule = filter_input(INPUT_POST, 'schedule', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $patient_id = (int) filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
        $doctor_id = $_SESSION['admin_id'];

        $dummy_id = (int) filter_input(INPUT_GET, 'uid', FILTER_SANITIZE_NUMBER_INT);

        $sql = "INSERT INTO reg_medicins (med_name, dose, schedule, user_id, doctor_id) VALUES ('$med_name', '$dosage', '$schedule', '$patient_id', '$doctor_id')";

        $res = mysqli_query($conn, $sql);
        header("Location: addmedicins.php?id=$patient_id&uid=$dummy_id");
        exit();
    }

    if (isset($_GET['id'])) {
        $sql = "SELECT * FROM `user_register` WHERE id = $patient_id";
        $res = mysqli_query($conn, $sql);

        if (mysqli_num_rows($res) > 0) {
            $row = mysqli_fetch_assoc($res);
            $arr = array_slice(preg_split('/\s+/', trim($row['user_name'])), 0, 2);
            $initials = '';
            foreach ($arr as $word) {
                $initials .= strtoupper($word[0]);
            }

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
            <a href="#" class="text-2xl font-bold text-indigo-600">MediTrack <span
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
                    <?= $initials ?></div>
                <div>
                    <h1 class="text-2xl font-bold text-gray-800"><?= $row['user_name'] ?></h1>
                    <p class="text-sm text-gray-500">Patient ID: P<?= $dummy_id ?> &bull; Age:  <?= $row['user_age'] ?> &bull; Diagnosis: <?= $row['user_disease'] ?></p>
                </div>
            </div>
        </div>
            <?php
        }
    }
    ?>
        <!-- Current Medicines -->
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden mb-8">
            <div class="bg-indigo-600 px-6 py-4">
                <h2 class="text-lg font-semibold text-white">Current Medicines</h2>
                <p class="text-indigo-200 text-sm">Update dosage/schedule inline or delete a medicine</p>
            </div>

            <!-- Medicine -->

            <?php
            $sqlfetch = 'SELECT * FROM reg_medicins';
            $resfetch = mysqli_query($conn, $sqlfetch);
            if (mysqli_num_rows($resfetch)) {
                while ($row = mysqli_fetch_assoc($resfetch)) {
                    $med_name = $row['med_name'];
                    $dose = $row['dose'];
                    $schedule = $row['schedule'];
                    ?>
            <div
                class="border-b border-gray-100 px-6 py-4 flex flex-wrap items-center gap-4 hover:bg-indigo-50 transition">
                <div class="flex-1 min-w-0">
                    <p class="font-semibold text-gray-800"><?= $med_name ?></p>
                    <p class="text-xs text-gray-500"><?= $dose ?> &bull; <?= $schedule ?></p>
                </div>
                <form method="post" action="#" class="flex items-center gap-2">
                    <input type="text" name="medicine" value="<?= $med_name ?>"
                        class="border border-gray-300 rounded-lg px-3 py-2 text-sm w-32 focus:ring-2 focus:ring-indigo-300 focus:border-indigo-400 outline-none"
                        required>
                    <input type="text" name="dosage" value="<?= $dose ?>"
                        class="border border-gray-300 rounded-lg px-3 py-2 text-sm w-24 focus:ring-2 focus:ring-indigo-300 focus:border-indigo-400 outline-none"
                        required>
                    <input type="text" name="schedule" value="<?= $schedule ?>"
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
            <?php
                }
            }
            ?>
        </div>
        <!-- Add New Medicine -->
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
            <div class="bg-green-600 px-6 py-4">
                <h2 class="text-lg font-semibold text-white">Add New Medicine</h2>
                <p class="text-green-200 text-sm">Prescribe a new medicine for this patient</p>
            </div>
            <div class="p-6">
                <form method="post" action="addmedicins.php?id=<?= $patient_id ?>&uid=<?= $dummy_id ?>" class="flex flex-wrap items-end gap-4">
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
                    <button type="submit" name="add_medicine"
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
</html>
<?php
} catch (\Throwable $th) {
    die('ERROR IN ADD MEDICINS PAGE: ' . $th);
}
?>