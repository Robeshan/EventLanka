<?php

class Service {
    protected $conn;
    protected $table_name = "services"; // Adjust according to your table name

    public $serviceId;
    public $userId; // Add userId property
    public $serviceName; 
    public $serviceDescription;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Method to upload service
    public function uploadService() {
        $query = "INSERT INTO " . $this->table_name . " (userId, serviceName, serviceDescription) VALUES (:userId, :serviceName, :serviceDescription)";
        $stmt = $this->conn->prepare($query);

        // Sanitize inputs
        $this->serviceName = htmlspecialchars(strip_tags($this->serviceName));
        $this->serviceDescription = htmlspecialchars(strip_tags($this->serviceDescription));
        $this->userId = htmlspecialchars(strip_tags($this->userId));

        // Bind parameters
        $stmt->bindParam(':userId', $this->userId);
        $stmt->bindParam(':serviceName', $this->serviceName);
        $stmt->bindParam(':serviceDescription', $this->serviceDescription);

        // Execute and check for errors
        if ($stmt->execute()) {
            return true; // Successfully uploaded service
        }

        return false; // Failed to upload service
    }

    // Method to update a service
    public function updateService() {
        $query = "UPDATE " . $this->table_name . " SET serviceName = :serviceName, serviceDescription = :serviceDescription WHERE serviceId = :serviceId";
        $stmt = $this->conn->prepare($query);

        // Sanitize inputs
        $this->serviceName = htmlspecialchars(strip_tags($this->serviceName));
        $this->serviceDescription = htmlspecialchars(strip_tags($this->serviceDescription));
        $this->serviceId = htmlspecialchars(strip_tags($this->serviceId));

        // Bind parameters
        $stmt->bindParam(':serviceId', $this->serviceId);
        $stmt->bindParam(':serviceName', $this->serviceName);
        $stmt->bindParam(':serviceDescription', $this->serviceDescription);

        // Execute and check for errors
        if ($stmt->execute()) {
            return true; // Successfully updated service
        }

        return false; // Failed to update service
    }

    // Method to delete a service
    public function deleteService() {
        $query = "DELETE FROM " . $this->table_name . " WHERE serviceId = :serviceId";
        $stmt = $this->conn->prepare($query);
        $this->serviceId = htmlspecialchars(strip_tags($this->serviceId));
        $stmt->bindParam(':serviceId', $this->serviceId);

        // Execute and check for errors
        if ($stmt->execute()) {
            return true; // Successfully deleted service
        }

        return false; // Failed to delete service
    }

    // Fetch services by user ID
    public function fetchServicesByUserId($userId) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE userId = :userId";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':userId', $userId);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Method to fetch service by ID
    public function fetchServiceById($serviceId) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE serviceId = :serviceId";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':serviceId', $serviceId);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>
