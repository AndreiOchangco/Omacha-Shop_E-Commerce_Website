<?php
require_once '../connection/connectData.php';

if (isset($_POST['sbm'])) {
    $r_name = $_POST['r_name'] ?? '';
    $r_star = $_POST['r_star'] ?? 0;
    $r_email = $_POST['r_email'] ?? '';
    $r_description = $_POST['r_description'] ?? '';

    $sql = "INSERT INTO review (r_name, r_star, r_email, r_description) 
            VALUES ('$r_name', '$r_star', '$r_email', '$r_description')";

    try {
        $query = mysqli_query($conn, $sql);
        header('Location: ../../Fontend/productdetail.php');
    } catch (Exception $e) {
        var_dump($e);
    }
};
?>