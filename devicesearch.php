<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "carsproject";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["devNo"])) {
    $devNo = $_POST["devNo"];

    // Prepare SQL statement to fetch car data based on name
    $sql = "SELECT * FROM device WHERE no LIKE '$devNo'";
    $result = $conn->query($sql);

    echo "<table id='carTable' style='border: 1px solid #000; border-collapse: collapse; width: 70%; text-align: center; margin-top: -90px;'>";
        echo "<tr style='background-color: #f2f2f2;'>";
            echo "<th style='border: 1px solid #000;color:black;'>NO</th><th style='border: 1px solid #000;color:black;'>Name</th><th style='border: 1px solid #000;color:black;'>Price</th><th style='border: 1px solid #000;color:black;'>Weight</th><th style='border: 1px solid #000;color:black;'>Made</th>";
        echo "</tr>";

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td style='padding: 10px;'>" . $row["no"] . "</td><td style='padding: 10px;'>" . $row["name"] . "</td><td style='padding: 10px;'>" . $row["price"] . "</td><td style='padding: 10px;'>" . $row["weight"] . "</td> <td style='padding: 10px;'>" . $row["made"] . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='5' style='text-align: center; padding: 10px;'>No results found</td></tr>";
        }
    echo "</table>";
}
$conn->close();
?>