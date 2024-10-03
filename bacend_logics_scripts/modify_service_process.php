<?php
session_start();
require_once '../Classes/Database.php';
require_once '../Classes/Service.php';

$database = new Database();
$db = $database->getConnection();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $serviceId = $_POST['service_id'];
    $serviceName = htmlspecialchars(strip_tags($_POST['serviceName']));
    $serviceDescription = htmlspecialchars(strip_tags($_POST['serviceDescription']));

    $service = new Service($db);
    $service->serviceId = $serviceId;
    $service->serviceName = $serviceName;
    $service->serviceDescription = $serviceDescription;

    if ($service->updateService()) { // You need to create this method
        $_SESSION['success'] = "Service updated successfully!";
    } else {
        $_SESSION['error'] = "Error updating service.";
    }

    header('Location: ../dash_boards/serviceprovider.php#S_Services');
    exit();
}
?>
