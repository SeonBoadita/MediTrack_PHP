<?php

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
                    class="text-sm font-normal text-gray-400">Admin</span></a>
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
                        <!-- Patient 1 -->
                        <tr class="hover:bg-indigo-50 transition">
                            <td class="py-4 px-5 text-gray-600 font-mono">P001</td>
                            <td class="py-4 px-5 font-medium text-gray-800">John Doe</td>
                            <td class="py-4 px-5 text-gray-600">34</td>
                            <td class="py-4 px-5 text-gray-600">Male</td>
                            <td class="py-4 px-5">
                                <span class="bg-blue-100 text-blue-700 text-xs font-semibold px-3 py-1 rounded-full">Flu</span>
                            </td>
                            <td class="py-4 px-5 text-gray-600">555-1234</td>
                            <td class="py-4 px-5">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="addmedicins.php" class="bg-indigo-500 text-white text-xs px-3 py-1.5 rounded-lg hover:bg-indigo-600 transition">View Medicines</a>
                                    <form method="post" action="#">
                                        <button type="submit" class="bg-red-500 text-white text-xs px-3 py-1.5 rounded-lg hover:bg-red-600 transition">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        <!-- Patient 2 -->
                        <tr class="hover:bg-indigo-50 transition">
                            <td class="py-4 px-5 text-gray-600 font-mono">P002</td>
                            <td class="py-4 px-5 font-medium text-gray-800">Jane Smith</td>
                            <td class="py-4 px-5 text-gray-600">28</td>
                            <td class="py-4 px-5 text-gray-600">Female</td>
                            <td class="py-4 px-5">
                                <span class="bg-purple-100 text-purple-700 text-xs font-semibold px-3 py-1 rounded-full">Allergy</span>
                            </td>
                            <td class="py-4 px-5 text-gray-600">555-5678</td>
                            <td class="py-4 px-5">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="addmedicins.php" class="bg-indigo-500 text-white text-xs px-3 py-1.5 rounded-lg hover:bg-indigo-600 transition">View Medicines</a>
                                    <form method="post" action="#">
                                        <button type="submit" class="bg-red-500 text-white text-xs px-3 py-1.5 rounded-lg hover:bg-red-600 transition">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        <!-- Patient 3 -->
                        <tr class="hover:bg-indigo-50 transition">
                            <td class="py-4 px-5 text-gray-600 font-mono">P003</td>
                            <td class="py-4 px-5 font-medium text-gray-800">Michael Lee</td>
                            <td class="py-4 px-5 text-gray-600">45</td>
                            <td class="py-4 px-5 text-gray-600">Male</td>
                            <td class="py-4 px-5">
                                <span class="bg-orange-100 text-orange-700 text-xs font-semibold px-3 py-1 rounded-full">Diabetes</span>
                            </td>
                            <td class="py-4 px-5 text-gray-600">555-8765</td>
                            <td class="py-4 px-5">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="addmedicins.php" class="bg-indigo-500 text-white text-xs px-3 py-1.5 rounded-lg hover:bg-indigo-600 transition">View Medicines</a>
                                    <form method="post" action="#">
                                        <button type="submit" class="bg-red-500 text-white text-xs px-3 py-1.5 rounded-lg hover:bg-red-600 transition">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        <!-- Patient 4 -->
                        <tr class="hover:bg-indigo-50 transition">
                            <td class="py-4 px-5 text-gray-600 font-mono">P004</td>
                            <td class="py-4 px-5 font-medium text-gray-800">Emily Clark</td>
                            <td class="py-4 px-5 text-gray-600">52</td>
                            <td class="py-4 px-5 text-gray-600">Female</td>
                            <td class="py-4 px-5">
                                <span
                                    class="bg-red-100 text-red-700 text-xs font-semibold px-3 py-1 rounded-full">Hypertension</span>
                            </td>
                            <td class="py-4 px-5 text-gray-600">555-4321</td>
                            <td class="py-4 px-5">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="addmedicins.php" class="bg-indigo-500 text-white text-xs px-3 py-1.5 rounded-lg hover:bg-indigo-600 transition">View Medicines</a>
                                    <form method="post" action="#">
                                        <button type="submit" class="bg-red-500 text-white text-xs px-3 py-1.5 rounded-lg hover:bg-red-600 transition">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</body>

</html>