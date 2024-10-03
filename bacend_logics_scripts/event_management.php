<?php
session_start();
require_once '../Classes/Database.php';

$database = new Database();
$db = $database->getConnection();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data
    $eventName = $_POST['eventName'] ?? '';
    $eventType = $_POST['eventType'] ?? '';
    $eventDescription = $_POST['eventDescription'] ?? '';
    $eventDate = $_POST['eventDate'] ?? '';
    $eventVenue = $_POST['eventVenue'] ?? '';
    $noOfGuests = $_POST['noOfGuests'] ?? '';
    $adminId = $_SESSION['user_id']; // Assuming admin ID is stored in session

    // Validate the data
    if (!empty($eventName) && !empty($eventType) && !empty($eventDescription) && !empty($eventDate) && !empty($eventVenue) && !empty($noOfGuests)) {
        
        // Check if adminId exists in the admin table
        $checkAdminQuery = "SELECT COUNT(*) FROM admin WHERE adminId = :adminId";
        $checkAdminStmt = $db->prepare($checkAdminQuery);
        $checkAdminStmt->bindParam(':adminId', $adminId);
        $checkAdminStmt->execute();
        
        $adminExists = $checkAdminStmt->fetchColumn();
        
        if (!$adminExists) {
            $_SESSION['error'] = "Invalid admin ID. Please log in again.";
            header('Location: ../dash_boards/admin_page.php#Event Management');
            exit();
        }

        // Insert new event into the database
        $query = "INSERT INTO event (eventName, eventType, eventDescription, eventDate, eventVenue, noOfGuests, adminId) 
                  VALUES (:eventName, :eventType, :eventDescription, :eventDate, :eventVenue, :noOfGuests, :adminId)";
        
        $stmt = $db->prepare($query);
        $stmt->bindParam(':eventName', $eventName);
        $stmt->bindParam(':eventType', $eventType);
        $stmt->bindParam(':eventDescription', $eventDescription);
        $stmt->bindParam(':eventDate', $eventDate);
        $stmt->bindParam(':eventVenue', $eventVenue);
        $stmt->bindParam(':noOfGuests', $noOfGuests);
        $stmt->bindParam(':adminId', $adminId);

        if ($stmt->execute()) {
            $_SESSION['success'] = "Event added successfully!";
        } else {
            $_SESSION['error'] = "Error adding event: " . implode(", ", $stmt->errorInfo());
        }
    } else {
        $_SESSION['error'] = "All fields are required.";
    }

    // Redirect back to the event management page
    header('Location: ../dash_boards/admin_page.php#Event Management');
    exit();
}
?>
