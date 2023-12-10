<?php 

    // database connection settings
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "rannaghor";

    // create connection
    $link = new mysqli($servername, $username, $password, $dbname);

    // check connection
    if ($link->connect_error) {
      die("Connection failed: " . $link->connect_error);
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Get recipe id from the form
        $id = $_POST["id"];
        
        // Update the approve column to 1 for the recipe with the given id
        $sql = "UPDATE recipes SET approved = 1 WHERE id = '$id'";
        if ($link->query($sql) === TRUE) {
            // Redirect to the recipe list page
            header("location: dashboard.php");
            exit();
        } else {
            // Handle error
        }
    }    

?>