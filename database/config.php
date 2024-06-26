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
             ?>

    </body>
</html>
