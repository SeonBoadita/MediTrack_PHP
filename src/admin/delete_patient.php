<?php
session_start();
include('../connection/database.php');

if (empty($_SESSION['admin_id'])) {
    header('Location: adminlogin.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    $delete_id = (int) $_POST['delete_id'];
    $admin_id = (int) $_SESSION['admin_id'];

    // Verify this patient is registered under the current doctor before deleting
    $check_sql = "SELECT id FROM user_register WHERE id = '$delete_id' AND doctor_id = '$admin_id'";
    $check_res = mysqli_query($conn, $check_sql);

    if (mysqli_num_rows($check_res) > 0) {
        // Delete associated medicines first
        $del_meds = "DELETE FROM reg_medicins WHERE user_id = '$delete_id'";
        mysqli_query($conn, $del_meds);

        // Delete the patient registration
        $del_patient = "DELETE FROM user_register WHERE id = '$delete_id'";
        mysqli_query($conn, $del_patient);
    }
}

header('Location: admin.php');
exit();
?>
