<?php
session_start();
include ('../connection/database.php');
$admin_id = $_SESSION['admin_id'];
$admin_name = $_SESSION['admin_name'];
if (empty($admin_id)) {
    header('Location: adminlogin.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Patients Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen bg-linear-to-br from-blue-50 to-indigo-100">
    <!-- Navbar -->
    <nav class="bg-white shadow">
        <div class="max-w-6xl mx-auto px-4 py-4 flex items-center justify-between">
            <a href="admin.php" class="text-2xl font-bold text-indigo-600">MediTrack <span
                    class="text-sm font-normal text-gray-400"><?= $admin_name ?></span></a>
            <div class="flex gap-4 text-sm">
                <a href="admin.php"
                    class="text-indigo-600 font-semibold border-b-2 border-indigo-600 pb-1">Dashboard</a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="max-w-6xl mx-auto px-4 py-10">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800">Admin Dashboard</h1>
            <p class="text-gray-500 mt-1">Manage patients and their records</p>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">
            <div class="bg-white rounded-2xl shadow p-5">
                <p class="text-sm text-gray-500">Total Patients</p>
                <p class="text-3xl font-bold text-indigo-600 mt-1">4</p>
            </div>
            <div class="bg-white rounded-2xl shadow p-5">
                <p class="text-sm text-gray-500">Active Diagnoses</p>
                <p class="text-3xl font-bold text-green-600 mt-1">4</p>
            </div>
            <div class="bg-white rounded-2xl shadow p-5">
                <p class="text-sm text-gray-500">Medicines Assigned</p>
                <p class="text-3xl font-bold text-yellow-500 mt-1">8</p>
            </div>
        </div>

        <!-- Patients Table -->
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
            <div class="bg-indigo-600 px-6 py-4">
                <h2 class="text-lg font-semibold text-white">Patients List</h2>
                <p class="text-indigo-200 text-sm">Click "View Medicines" to manage a patient's prescriptions, or delete a patient record</p>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-indigo-50 text-indigo-700">
                        <tr>
                            <th class="py-3 px-5 text-left font-semibold">Patient ID</th>
                            <th class="py-3 px-5 text-left font-semibold">Name</th>
                            <th class="py-3 px-5 text-left font-semibold">Age</th>
                            <th class="py-3 px-5 text-left font-semibold">Gender</th>
                            <th class="py-3 px-5 text-left font-semibold">Diagnosis</th>
                            <th class="py-3 px-5 text-left font-semibold">Contact</th>
                            <th class="py-3 px-5 text-center font-semibold">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <?php
                        try { 
                            $sql = "SELECT * FROM user_register WHERE doctor_id = '$admin_id'";
                            $res = mysqli_query($conn, $sql);

                            if (mysqli_num_rows($res) > 0) {
                                $id = 0;
                                while ($row = mysqli_fetch_assoc($res)) {
                                    $id += 1;
                                    ?>
                                    
                                    <tr class="hover:bg-indigo-50 transition">
                                        <td class="py-4 px-5 text-gray-600 font-mono">P<?= $id ?></td>
                                        <td class="py-4 px-5 font-medium text-gray-800"><?= htmlspecialchars($row['user_name']) ?></td>
                                        <td class="py-4 px-5 text-gray-600"><?= htmlspecialchars($row['user_age']) ?></td>
                                        <td class="py-4 px-5 text-gray-600"><?= htmlspecialchars($row['user_gender']) ?></td>
                                        <td class="py-4 px-5">
                                            <span class="bg-blue-100 text-blue-700 text-xs font-semibold px-3 py-1 rounded-full">
                                                <?= htmlspecialchars($row['user_disease']) ?>
                                            </span>
                                        </td>
                                        <td class="py-4 px-5 text-gray-600"><?= htmlspecialchars($row['user_contact']) ?></td>
                                        <td class="py-4 px-5">
                                            <div class="flex items-center justify-center gap-2">
                                                <a href="addmedicins.php?id=<?= $row['id'] ?>&uid=<?=$id?>" class="bg-indigo-500 text-white text-xs px-3 py-1.5 rounded-lg hover:bg-indigo-600 transition">View Medicines</a>
                                                
                                                <form method="post" action="delete_patient.php">
                                                    <input type="hidden" name="delete_id" value="<?= $row['id'] ?>">
                                                    <button type="submit" class="bg-red-500 text-white text-xs px-3 py-1.5 rounded-lg hover:bg-red-600 transition" onclick="return confirm('Are you sure you want to delete this patient?');">Delete</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    
                                    <?php
                                }
                            } else {
                                ?>
                                <tr>
                                    <td colspan="7" class="py-8 text-center text-gray-500 font-medium">No patients registered yet.</td>
                                </tr>
                                <?php
                            }
                        } catch (\Throwable $th) {
                            die("ERROR IN ADMIN PAGE: " . $th->getMessage());
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</body>

</html>