<?php
session_start();
require_once '../Classes/Database.php';

$database = new Database();
$db = $database->getConnection(); // Ensure you have the database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data
    $packageSelect = $_POST['packageSelect'] ?? '';
    $packageDetails = $_POST['packageDetails'] ?? '';
    $serviceProviders = $_POST['serviceProviders'] ?? '';
    $packagePrice = $_POST['packagePrice'] ?? '';

    // Validate the data
    if (!empty($packageSelect) && !empty($packageDetails) && !empty($serviceProviders) && !empty($packagePrice)) {
        
        // Ensure packagePrice is a valid decimal
        if (!is_numeric($packagePrice)) {
            $_SESSION['error'] = "Package price must be a number.";
            header('Location: ../dash_boards/admin_page.php#A_Packages');
            exit();
        }

        // Prepare the INSERT statement
        $query = "INSERT INTO packages (packageName, packageDetails, serviceProviderId, packagePrice) VALUES (:packageName, :packageDetails, :serviceProviderId, :packagePrice)";

        $stmt = $db->prepare($query);
        $stmt->bindParam(':packageName', $packageSelect);
        $stmt->bindParam(':packageDetails', $packageDetails);
        $stmt->bindParam(':serviceProviderId', $serviceProviders);
        $stmt->bindParam(':packagePrice', $packagePrice);

        // Execute the statement and check for errors
        try {
            if ($stmt->execute()) {
                $_SESSION['success'] = "Package added successfully!";
            } else {
                $_SESSION['error'] = "Error adding package: " . implode(", ", $stmt->errorInfo());
            }
        } catch (PDOException $e) {
            $_SESSION['error'] = "Database error: " . $e->getMessage();
        }
    } else {
        $_SESSION['error'] = "All fields are required.";
    }

    // Redirect back to the package management page
    header('Location: ../dash_boards/admin_page.php#A_Packages');
    exit();
}
?>
