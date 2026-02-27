<?php
include('connection/database.php');
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}

$userid = $_SESSION['user_id'];
$name = $_SESSION['name'];

if (isset($_GET['reg_id']) && isset($_GET['dr_id'])) {
    $reg_id = (int) filter_input(INPUT_GET, 'reg_id', FILTER_SANITIZE_NUMBER_INT);
    $dr_id = (int) filter_input(INPUT_GET, 'dr_id', FILTER_SANITIZE_NUMBER_INT);
} else {
    header("Location: doctorselect.php");
    exit();
}

// 3. Save Progress Logic (Triggers when the button is clicked)
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['save_progress'])) {
    
    // Reset all medicines for this specific doctor/patient to 0 (Pending)
    $reset_sql = "UPDATE reg_medicins SET med_taken = 0 WHERE user_id = '$reg_id' AND doctor_id = '$dr_id'";
    mysqli_query($conn, $reset_sql);

    // If the user ticked ANY boxes, update those specific ones to 1 (Taken)
    if (!empty($_POST['taken'])) {
        foreach ($_POST['taken'] as $ticked_med_id) {
            $ticked_med_id = (int) $ticked_med_id;
            $update_sql = "UPDATE reg_medicins SET med_taken = 1 WHERE id = '$ticked_med_id'";
            mysqli_query($conn, $update_sql);
        }
    }

    // Refresh the page instantly to show the updated green badges!
    header("Location: home.php?reg_id=$reg_id&dr_id=$dr_id");
    exit();
}

// 4. Fetch the medicines to display on the screen
$sql = "SELECT * FROM reg_medicins WHERE user_id = '$reg_id' AND doctor_id = '$dr_id'";
$result = mysqli_query($conn, $sql);

// Set up counters for the Summary Cards at the bottom
$taken_count = 0;
$pending_count = 0;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medicines Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100">
    <nav class="bg-white shadow">
        <div class="max-w-6xl mx-auto px-4 py-4 flex items-center justify-between">
            <a href="doctorselect.php" class="text-2xl font-bold text-indigo-600">MediTrack</a>
            <div class="flex gap-4 text-sm items-center">
                <a href="doctorselect.php" class="text-gray-500 hover:text-indigo-600 transition">&larr; Back to Doctors</a>
                <a href="home.php?reg_id=<?= $reg_id ?>&dr_id=<?= $dr_id ?>" class="text-indigo-600 font-semibold border-b-2 border-indigo-600 pb-1">My Medicines</a>
            </div>
        </div>
    </nav>

    <main class="max-w-3xl mx-auto px-4 py-10">
        <div class="bg-white rounded-2xl shadow-lg p-6 mb-8">
            <div class="flex items-center gap-4 mb-2">
                <div class="w-12 h-12 bg-indigo-100 rounded-full flex items-center justify-center text-indigo-600 text-xl font-bold">
                    <?= strtoupper(substr(htmlspecialchars($name), 0, 2)) ?>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">Welcome, <?= htmlspecialchars($name) ?></h1>
                    <p class="text-sm text-gray-500">Here are your prescribed medicines</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
            <div class="bg-indigo-600 px-6 py-4">
                <h2 class="text-lg font-semibold text-white">Today's Medicines</h2>
                <p class="text-indigo-200 text-sm">Tick the checkbox once you have taken the medicine</p>
            </div>

            <form method="post" action="home.php?reg_id=<?= $reg_id ?>&dr_id=<?= $dr_id ?>">
                <table class="w-full text-sm">
                    <thead class="bg-indigo-50 text-indigo-700">
                        <tr>
                            <th class="py-3 px-5 text-center font-semibold w-16">Taken</th>
                            <th class="py-3 px-5 text-left font-semibold">Medicine</th>
                            <th class="py-3 px-5 text-left font-semibold">Dosage</th>
                            <th class="py-3 px-5 text-left font-semibold">Scheduled Time</th>
                            <th class="py-3 px-5 text-left font-semibold">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                    <?php
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            $med_id = $row['id'];
                            $med_name = $row['med_name'];
                            $dose = $row['dose'];
                            $schedule = $row['schedule'];
                            $med_taken = $row['med_taken'] ?? 0;

                            // Update the math counters
                            if ($med_taken == 1) {
                                $taken_count++;
                            } else {
                                $pending_count++;
                            }
                    ?>
                        <tr class="hover:bg-indigo-50 transition">
                            <td class="py-4 px-5 text-center">
                                <input type="checkbox" name="taken[]" value="<?= $med_id ?>" <?= $med_taken == 1 ? 'checked' : '' ?> 
                                    class="w-5 h-5 rounded border-gray-300 text-indigo-600 cursor-pointer focus:ring-indigo-500">
                            </td>
                            <td class="py-4 px-5 font-medium text-gray-800"><?= htmlspecialchars($med_name) ?></td>
                            <td class="py-4 px-5 text-gray-600"><?= htmlspecialchars($dose) ?></td>
                            <td class="py-4 px-5 text-gray-600"><?= htmlspecialchars($schedule) ?></td>
                            <td class="py-4 px-5">
                                <span class="inline-block <?= $med_taken == 1 ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' ?> text-xs font-semibold px-3 py-1 rounded-full">
                                    <?= $med_taken == 1 ? 'Taken' : 'Pending' ?>
                                </span>
                            </td>
                        </tr>
                    <?php
                        }
                    } else {
                    ?>
                        <tr>
                            <td colspan="5" class="py-8 text-center text-gray-500 font-medium">No medicines assigned yet.</td>
                        </tr>
                    <?php
                    }
                    ?>
                    </tbody>
                </table>
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex justify-end">
                    <button type="submit" name="save_progress"
                        class="bg-indigo-600 text-white px-6 py-2 rounded-lg font-semibold hover:bg-indigo-700 transition shadow">
                        Save Progress
                    </button>
                </div>
            </form>
        </div>

        <div class="grid grid-cols-2 gap-4 mt-8">
            <div class="bg-white rounded-2xl shadow p-5 text-center">
                <p class="text-3xl font-bold text-green-600"><?= $taken_count ?></p>
                <p class="text-sm text-gray-500 mt-1">Medicines Taken</p>
            </div>
            <div class="bg-white rounded-2xl shadow p-5 text-center">
                <p class="text-3xl font-bold text-yellow-500"><?= $pending_count ?></p>
                <p class="text-sm text-gray-500 mt-1">Yet to Take</p>
            </div>
        </div>
    </main>
</body>
</html>