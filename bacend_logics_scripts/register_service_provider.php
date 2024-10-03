<?php
session_start(); 

require_once '../Classes/Database.php'; 
require_once '../Classes/User.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    
    $database = new Database();
    $db = $database->getConnection(); 

  
    $user = new User($db); 


    $providerName = htmlspecialchars(strip_tags($_POST['providerName']));
    $email = htmlspecialchars(strip_tags($_POST['email']));
    $contactInfo = htmlspecialchars(strip_tags($_POST['contactInfo']));
    $username = htmlspecialchars(strip_tags($_POST['username']));
    $password = $_POST['password']; 
    $userType = 'serviceProvider'; 

   
    $user->username = $username;
    $user->password = $password; 
    $user->email = $email;
    $user->userType = $userType;

    
    if ($_POST['password'] !== $_POST['cpassword']) {
        echo "<script>alert('Passwords do not match!'); window.location.href='service_provider_registration.php';</script>";
        exit();
    }

  
    if ($user->register()) {
        
        $query = "INSERT INTO serviceprovider (userId, providerName, contactInfo, serviceDetails) VALUES (:userId, :providerName, :contactInfo, :serviceDetails)";
        $stmt = $db->prepare($query);

     
        $userId = $user->userId;

      
        $serviceDetails = htmlspecialchars(strip_tags($_POST['serviceDetails']));

    
        $stmt->bindParam(':userId', $userId);
        $stmt->bindParam(':providerName', $providerName);
        $stmt->bindParam(':contactInfo', $contactInfo);
        $stmt->bindParam(':serviceDetails', $serviceDetails);

        
        if ($stmt->execute()) {
            echo "<script>alert('Registration successful!'); window.location.href='../login/login_form.php';</script>";
        } else {
            echo "<script>alert('Failed to register service provider details.'); window.location.href='service_provider_registration.php';</script>";
        }
    } else {
        echo "<script>alert('Failed to register user.'); window.location.href='service_provider_registration.php';</script>";
    }
}
?>
