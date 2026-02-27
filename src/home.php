<?php
include ('connection/database.php');

session_start();

try {
    if (!isset($_SESSION['user_id'])) {
        header('Location: index.php');
        exit();
    }

    $userid = $_SESSION['user_id'];
    $name = $_SESSION['name'];



    $sql = "SELECT * FROM reg_medicins WHERE user_id = '$userid'";
    $result = mysqli_query($conn, $sql);

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medicines Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen bg-linear-to-br from-blue-50 to-indigo-100">
    <!-- Navbar -->
    <nav class="bg-white shadow">
        <div class="max-w-6xl mx-auto px-4 py-4 flex items-center justify-between">
            <a href="home.php" class="text-2xl font-bold text-indigo-600">MediTrack</a>
            <div class="flex gap-4 text-sm items-center">
                <a href="home.php" class="text-indigo-600 font-semibold border-b-2 border-indigo-600 pb-1">My Medicines</a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="max-w-3xl mx-auto px-4 py-10">
        <!-- Welcome Card -->
        <div class="bg-white rounded-2xl shadow-lg p-6 mb-8">
            <div class="flex items-center gap-4 mb-2">
                <div
                    class="w-12 h-12 bg-indigo-100 rounded-full flex items-center justify-center text-indigo-600 text-xl font-bold">
                    JD</div>
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">Welcome, <?=$name?></h1>
                    <p class="text-sm text-gray-500">Here are your medicines for today</p>
                </div>
            </div>
        </div>

        <!-- Medicines Table Card -->
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
            <div class="bg-indigo-600 px-6 py-4">
                <h2 class="text-lg font-semibold text-white">Today's Medicines</h2>
                <p class="text-indigo-200 text-sm">Tick the checkbox once you have taken the medicine</p>
            </div>

            <form method="post" action="#">
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
                    <?php 
                    if(mysqli_num_rows($result)){
                        while($row = mysqli_fetch_assoc($result)){
                            $med_name = $row['med_name'];
                            $dose = $row['dose'];
                            $schedule = $row['schedule'];
                            $med_taken = $row['med_taken'];
                    ?>
                    <tbody class="divide-y divide-gray-100">
                        <tr class="hover:bg-indigo-50 transition">
                            <td class="py-4 px-5 text-center">
                                <input type="checkbox" name="taken[]" value="<?=$med_taken?>" checked
                                    class="w-5 h-5 rounded border-gray-300 text-indigo-600 cursor-pointer">
                            </td>
                            <td class="py-4 px-5 font-medium text-gray-800"><?=$med_name?></td>
                            <td class="py-4 px-5 text-gray-600"><?=$dose?></td>
                            <td class="py-4 px-5 text-gray-600"><?=$schedule?></td>
                            <td class="py-4 px-5">
                                <span
                                    class="inline-block bg-green-100 text-green-700 text-xs font-semibold px-3 py-1 rounded-full">Taken</span>
                            </td>
                        </tr>
                    </tbody>
                    <?php
                        }
                    }
                    ?>
                </table>
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex justify-end">
                    <button type="submit"
                        class="bg-indigo-600 text-white px-6 py-2 rounded-lg font-semibold hover:bg-indigo-700 transition shadow">
                        Save Progress
                    </button>
                </div>
            </form>
        </div>

        <!-- Summary Cards -->
        <div class="grid grid-cols-2 gap-4 mt-8">
            <div class="bg-white rounded-2xl shadow p-5 text-center">
                <p class="text-3xl font-bold text-green-600">2</p>
                <p class="text-sm text-gray-500 mt-1">Medicines Taken</p>
            </div>
            <div class="bg-white rounded-2xl shadow p-5 text-center">
                <p class="text-3xl font-bold text-yellow-500">2</p>
                <p class="text-sm text-gray-500 mt-1">Yet to Take</p>
            </div>
        </div>
    </main>
</body>
<?php
} catch (\Throwable $th) {
    die('ERROR IN HOMEPAGE: ' . $th);
}
?>
</html>