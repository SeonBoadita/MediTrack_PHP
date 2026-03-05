<?php
include ('connection/database.php');

session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}

$current_user_id = $_SESSION['user_id'];
$name = $_SESSION['name'];

try {
    $sql = "SELECT d.doctorID, d.name, d.designation, ur.id, ur.doctor_id, ur.reg_date,
                   (SELECT COUNT(*) FROM reg_medicins rm WHERE rm.user_id = ur.id AND rm.doctor_id = ur.doctor_id) AS med_count
            FROM doctorsignup d
            JOIN user_register ur ON d.doctorID = ur.doctor_id
            WHERE ur.user_id = '$current_user_id'";
    $res = mysqli_query($conn, $sql);
    $doctor_count = mysqli_num_rows($res);
    ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Doctors - MediTrack</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100">

    <!-- Navbar -->
    <nav class="bg-white shadow sticky top-0 z-10">
        <div class="max-w-5xl mx-auto px-4 py-4 flex items-center justify-between">
            <a href="home.php" class="text-2xl font-bold text-indigo-600">MediTrack
                <span class="text-sm font-normal text-gray-400">/ My Doctors</span>
            </a>
            <div class="flex items-center gap-4">
                <span class="text-sm text-gray-500 hidden sm:block">Welcome, <span
                        class="font-semibold text-gray-700"><?= htmlspecialchars($name) ?></span></span>
                <a href="dashboard.php" class="text-sm text-gray-500 hover:text-indigo-600 transition">&larr; Dashboard</a>
                <a href="logout.php"
                    class="text-sm bg-red-100 text-red-500 hover:bg-red-200 px-3 py-1.5 rounded-lg transition font-medium">Logout</a>
            </div>
        </div>
    </nav>

    <!-- Hero Banner -->
    <div class="bg-indigo-600 text-white py-8 px-4">
        <div class="max-w-5xl mx-auto flex items-center gap-4">
            <div class="w-14 h-14 bg-indigo-400 rounded-full flex items-center justify-center text-2xl font-bold"><?= strtoupper(substr(htmlspecialchars($name), 0, 2)) ?>
            </div>
            <div>
                <h1 class="text-2xl font-bold"><?= htmlspecialchars($name) ?></h1>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <main class="max-w-5xl mx-auto px-4 py-8">

        <!-- Section Header -->
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-xl font-bold text-gray-800">Your Registered Doctors</h2>
                <p class="text-sm text-gray-500 mt-0.5"><?= $doctor_count ?> doctor<?= $doctor_count !== 1 ? 's' : '' ?> found</p>
            </div>
            <a href="register.php"
                class="bg-indigo-600 text-white text-sm px-4 py-2 rounded-lg hover:bg-indigo-700 transition font-semibold shadow">
                + Register New Doctor
            </a>
        </div>

        <!-- Doctor Cards -->
        <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-3">

            <!-- Card -->
            <?php
            if (mysqli_num_rows($res) > 0) {
                mysqli_data_seek($res, 0);
                while ($row = mysqli_fetch_assoc($res)) {
                    $doc_words = array_slice(preg_split('/\s+/', trim($row['name'])), 0, 2);
                    $doc_initials = '';
                    foreach ($doc_words as $w) { $doc_initials .= strtoupper($w[0]); }
            ?>
            <div class="bg-white rounded-2xl shadow-md hover:shadow-lg transition overflow-hidden flex flex-col">
                <div class="bg-indigo-50 px-6 py-5 flex items-center gap-4">
                    <div
                        class="w-12 h-12 rounded-full bg-indigo-600 flex items-center justify-center text-white text-lg font-bold flex-shrink-0">
                        <?= htmlspecialchars($doc_initials) ?>
                    </div>
                    <div class="min-w-0">
                        <h3 class="font-semibold text-gray-800 truncate">Dr. <?= htmlspecialchars($row['name']) ?></h3>
                        <p class="text-xs text-indigo-500 font-medium"><?= htmlspecialchars($row['designation']) ?></p>
                    </div>
                </div>
                <div class="px-6 py-4 flex-1 space-y-2 text-sm text-gray-600">
                    <div class="flex items-center gap-2">
                        <span class="text-gray-400">&#128197;</span>
                        <span>Registered: <span class="font-medium text-gray-700"><?= htmlspecialchars($row['reg_date']) ?></span></span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="text-gray-400">&#128138;</span>
                        <span>Medicines: <span class="font-semibold text-indigo-600"><?= (int)$row['med_count'] ?> active</span></span>
                    </div>
                </div>
                <div class="px-6 pb-5 flex gap-2">
                    <a href="home.php?reg_id=<?=$row['id']?>&dr_id=<?=$row['doctor_id']?>"
                        class="flex-1 text-center bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium py-2 rounded-lg transition">
                        View Meds
                    </a>
                    <a href="cancelreg.php?id=<?= $row['id'] ?>"
                        onclick="return confirm('Cancel registration with this doctor? This will also remove all their prescriptions.')"
                        class="flex-1 text-center bg-red-100 hover:bg-red-200 text-red-600 text-sm font-medium py-2 rounded-lg transition">
                        Cancel
                    </a>
                </div>
            </div>
            <?php
                }
            }
            ?>

        </div>

    </main>


<?php
} catch (\Throwable $th) {
    die('ERROR IN DOCTOR SELECT PAGE: ' . $th);
}
?>


</body>

</html>