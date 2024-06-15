<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "carsproject";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["manName"])) {
    $manName = $_POST["manName"];

    // Prepare SQL statement to fetch car data based on name
    $sql = "SELECT * FROM manufacture WHERE name LIKE '$manName'";
    $result = $conn->query($sql);

    echo "<table id='carTable' style='border: 1px solid #000; border-collapse: collapse; width: 70%; text-align: center; margin-top: -90px;'>";
        echo "<tr style='background-color: #f2f2f2;'>";
            echo "<th style='border: 1px solid #000;color:black;'>Name</th><th style='border: 1px solid #000;color:black;'>Type</th><th style='border: 1px solid #000;color:black;'>City</th><th style='border: 1px solid #000;color:black;'>Country</th>";
        echo "</tr>";

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td style='padding: 10px;'>" . $row["name"] . "</td><td style='padding: 10px;'>" . $row["type"] . "</td><td style='padding: 10px;'>" . $row["city"] . "</td><td style='padding: 10px;'>" . $row["country"] . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='4' style='text-align: center; padding: 10px;'>No results found</td></tr>";
        }
    echo "</table>";
}
$conn->close();
?>