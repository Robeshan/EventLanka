<?php
session_start();
require_once '../Classes/Database.php';
require_once '../Classes/Service.php'; // Ensure you have a Service class for handling services

$database = new Database();
$db = $database->getConnection();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve service ID and action
    $serviceId = $_POST['service_id'];
    $action = $_POST['action'];

    $service = new Service($db);

    if ($action === 'delete') {
        // Handle deletion of the service
        $service->serviceId = $serviceId; // Assuming you have a property for serviceId in your Service class
        if ($service->deleteService()) {
            $_SESSION['success'] = "Service deleted successfully!";
        } else {
            $_SESSION['error'] = "Error deleting service.";
        }
    } elseif ($action === 'modify') {
        // Redirect to a modify page
        header("Location: modify_service.php?service_id=" . urlencode($serviceId));
        exit();
    }

    // Redirect back to the service provider dashboard
    header('Location: ../dash_boards/serviceprovider.php#S_Services');
    exit();
}
?>
