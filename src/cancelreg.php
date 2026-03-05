<?php
include('connection/database.php');
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}

if (isset($_GET['id'])) {
    $reg_id = (int) filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
    $user_id = (int) $_SESSION['user_id'];

    $check_sql = "SELECT id FROM user_register WHERE id = '$reg_id' AND user_id = '$user_id'";
    $check_res = mysqli_query($conn, $check_sql);

    if (mysqli_num_rows($check_res) > 0) {
        $del_meds = "DELETE FROM reg_medicins WHERE user_id = '$reg_id'";
        mysqli_query($conn, $del_meds);

        $del_reg = "DELETE FROM user_register WHERE id = '$reg_id'";
        mysqli_query($conn, $del_reg);
    }
}

header('Location: doctorselect.php');
exit();
?>
