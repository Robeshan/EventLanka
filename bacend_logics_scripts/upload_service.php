<?php
session_start();
require_once '../Classes/Database.php';
require_once '../Classes/Service.php'; // Ensure you have a Service class for handling services

$database = new Database();
$db = $database->getConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve data from the form
    $serviceName = htmlspecialchars(strip_tags($_POST['serviceName']));
    $serviceDescription = htmlspecialchars(strip_tags($_POST['serviceDescription']));
    $userId = $_SESSION['user_id']; // Assuming you have user_id in session

    // Create a new service object
    $service = new Service($db);

    // Set the service properties
    $service->userId = $userId;
    $service->serviceName = $serviceName;
    $service->serviceDescription = $serviceDescription;

    // Attempt to upload the service
    try {
        if ($service->uploadService()) {
            $_SESSION['success'] = "Service uploaded successfully!";
            header('Location: ../dash_boards/serviceprovider.php'); // Redirect to the service provider dashboard
            exit();
        } else {
            $_SESSION['error'] = "Failed to upload service.";
        }
    } catch (Exception $e) {
        $_SESSION['error'] = "Error: " . $e->getMessage();
    }
}
