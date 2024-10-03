<?php
require_once 'Database.php'; // Ensure you include your database connection class

class User {
    protected $conn;
    protected $table_name = "user";

    public $userId;
    public $username; 
    public $password;
    public $email;
    public $userType;
    public $profilePicture; // Added to store the profile picture path

    public function __construct($db) {
        $this->conn = $db;
    }

    // Register a new user
    public function register() {
        $query = "INSERT INTO " . $this->table_name . " (username, password, email, userType) VALUES (:username, :password, :email, :userType)";
        $stmt = $this->conn->prepare($query);

        // Sanitize input
        $this->username = htmlspecialchars(strip_tags($this->username));
        $this->password = password_hash($this->password, PASSWORD_DEFAULT); // Hashing the password
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->userType = htmlspecialchars(strip_tags($this->userType));

        // Bind parameters
        $stmt->bindParam(':username', $this->username);
        $stmt->bindParam(':password', $this->password);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':userType', $this->userType);

        // Execute and check for errors
        if (!$stmt->execute()) {
            throw new Exception("Failed to register user: " . implode(", ", $stmt->errorInfo()));
        }

        $this->userId = $this->conn->lastInsertId(); // Get the last inserted user ID
        return true;
    }

    // Login user
    public function login($username, $password) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE username = :username";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if (password_verify($password, $row['password'])) { // Verify password
                $this->userId = $row['userId'];
                $this->username = $row['username'];
                $this->userType = $row['userType'];
                return true;
            }
        }
        return false; // Return false if login fails
    }

    // Update user information
    public function updateUser() {
        $query = "UPDATE " . $this->table_name . " SET username = :username, email = :email WHERE userId = :userId";
        $stmt = $this->conn->prepare($query);

        // Sanitize input
        $this->username = htmlspecialchars(strip_tags($this->username));
        $this->email = htmlspecialchars(strip_tags($this->email));

        // Bind parameters
        $stmt->bindParam(':username', $this->username);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':userId', $this->userId);

        // Execute and check for errors
        if (!$stmt->execute()) {
            throw new Exception("Failed to update user information: " . implode(", ", $stmt->errorInfo()));
        }

        return true;
    }

    // Update profile picture
    public function updateProfilePicture() {
        $query = "UPDATE " . $this->table_name . " SET profilePicture = :profilePicture WHERE userId = :userId";
        $stmt = $this->conn->prepare($query);

        // Sanitize input
        $this->profilePicture = htmlspecialchars(strip_tags($this->profilePicture));

        // Bind parameters
        $stmt->bindParam(':profilePicture', $this->profilePicture);
        $stmt->bindParam(':userId', $this->userId);

        // Execute and check for errors
        if (!$stmt->execute()) {
            throw new Exception("Failed to update profile picture: " . implode(", ", $stmt->errorInfo()));
        }

        return true;
    }

    // Fetch user data by ID
    public function fetchUserData($userId) {
        $query = "SELECT username, email, profilePicture FROM " . $this->table_name . " WHERE userId = :userId";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':userId', $userId);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>
