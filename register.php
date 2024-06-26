<?php
include("database/config.php");

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $nic_number = $_POST['nic_number'];
    $nic_front_photo = $_FILES['nic_front_photo']['name'];
    $nic_back_photo = $_FILES['nic_back_photo']['name'];
    $username = $_POST['new_username'];
    $password = password_hash($_POST['new_password'], PASSWORD_BCRYPT);

    $target_dir = "uploads/";
    $nic_front_photo_target = $target_dir . basename($nic_front_photo);
    $nic_back_photo_target = $target_dir . basename($nic_back_photo);

    // Ensure the uploads directory exists and is writable
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    if (move_uploaded_file($_FILES['nic_front_photo']['tmp_name'], $nic_front_photo_target) && move_uploaded_file($_FILES['nic_back_photo']['tmp_name'], $nic_back_photo_target))
            {
        $sql = "INSERT INTO users (name, email, address, nic_number, nic_front_photo, nic_back_photo, username, password) VALUES ('$name', '$email', '$address', '$nic_number', '$nic_front_photo_target', '$nic_back_photo_target', '$username', '$password')";

        $result = mysqli_query($mysqli, $sql);

        if ($result) {
            echo "Register was successful";
        } else {
            echo "Error: " . mysqli_error($mysqli);
        }
    } else {
        echo "Failed to upload photos.";
    }
}
?>
