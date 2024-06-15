<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "carsproject";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["orderid"])) {
    $orderid = $_POST["orderid"];

    // Prepare SQL statement to fetch car data based on name
    $sql = "SELECT * FROM orders WHERE id LIKE '$orderid'";
    $result = $conn->query($sql);

    echo "<table id='carTable' style='border: 1px solid #000; border-collapse: collapse; width: 70%; text-align: center; margin-top: -90px;'>";
        echo "<tr style='background-color: #f2f2f2;'>";
            echo "<th style='border: 1px solid #000;color:black;'>ID</th><th style='border: 1px solid #000;color:black;'>Date</th><th style='border: 1px solid #000;color:black;'>Customer</th><th style='border: 1px solid #000;color:black;'>Car</th>";
        echo "</tr>";

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td style='padding: 10px;'>" . $row["id"] . "</td><td style='padding: 10px;'>" . $row["date"] . "</td><td style='padding: 10px;'>" . $row["customer"] . "</td><td style='padding: 10px;'>" . $row["car"] . "</td> ";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='4' style='text-align: center; padding: 10px;'>No results found</td></tr>";
        }
    echo "</table>";
}
$conn->close();
?>