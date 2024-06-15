<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "carsproject";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Extract values from the form
    $updateName = $_POST["updateName"];
    $updateModel = $_POST["updateModel"];
    $updateYear = $_POST["updateYear"];
    $updateMade = $_POST["updateMade"];

    // Perform the database update
    $updateSql = "UPDATE car SET model='$updateModel', year='$updateYear', made='$updateMade' WHERE name='$updateName'";

    if ($conn->query($updateSql) === TRUE) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . $conn->error;
    }
}
$conn->close();
?>