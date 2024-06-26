<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Lanka</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    </head>
    <body>
        <?php
        
        
        $servername = "localhost";
             $username = "root";
             $password = "";
             $dbname = "e_lanka";

             // Create connection
             $mysqli = new mysqli($servername, $username, $password, $dbname);

             // Check connection
             if ($mysqli->connect_error) {
                 die("Connection failed: " . $mysqli->connect_error);
             }
             
             
             $result = $mysqli->query("SELECT * FROM $", $resultmode)
       
        ?>
    </body>
</html>
