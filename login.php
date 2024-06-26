<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Event Lanka</title>
    </head>
    <body>
        <?php
        
        include("database/config.php");
      if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username='$username' OR email='$username'";
     $result = mysqli_query($mysqli, $sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            echo "Login successful!";
            // Start session and set user information
        } else {
            echo "Invalid password!";
        }
    } else {
        echo "No user found with that username/email!";
    }

  
}
?>


        
        
    </body>
</html>
