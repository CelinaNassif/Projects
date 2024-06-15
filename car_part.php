<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
        <title>CarPart Page</title>
        <style>
            body {
                background-image: url('R.jpg');
                background-size: cover;
                background-repeat: no-repeat;
                background-attachment: fixed;
                color: #fff;
                font-family: Arial, sans-serif;
            }

            table {
                border: 1px solid #000;
                border-collapse: collapse;
                width: 70%;
                text-align: center;
                margin-top: -90px;
                background-color: rgba(0, 0, 0, 0.80);
            }

            th, td {
                border: 1px solid #fff;
                padding: 8px;
            }

            th {
                background-color: #f2f2f2;
                color: black;
            }

            select {
                padding: 5px;
                margin: 5px;
            }

            button {
                padding: 10px;
                margin-top: 10px;
                background-color: #4CAF50;
                color: white;
                border: none;
                border-radius: 5px;
                cursor: pointer;
            }

            button:hover {
                background-color: #45a049;
            }
        </style>
    </head>
    <body>
        <?php
            session_start();
            if (isset($_SESSION['username'])) {
            } else {
                header('Location: loginView.html');
            }

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

            // Fetch car options
            $sqlCars = "SELECT name FROM car";
            $resultCars = $conn->query($sqlCars);

            // Fetch part options
            $sqlParts = "SELECT no FROM device";
            $resultParts = $conn->query($sqlParts);

            // Handle form submission
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                // Insert data into the "CarPart" table
                if (isset($_POST["insert"])) {
                    $car = $_POST["car"];
                    $part = $_POST["part"];

                    $insertSql = "INSERT INTO car_part (car, part) VALUES ('$car', '$part')";
                    if ($conn->query($insertSql) === TRUE) {
                        echo "New record added successfully";
                    } else {
                        echo "Error: " . $insertSql . "<br>" . $conn->error;
                    }
                }
                // Update data in the "CarPart" table
                elseif (isset($_POST["update"])) {
                    $new_car = $_POST["new_car"];
                    $new_part = $_POST["new_part"];

                    $updateSql = "UPDATE car_part SET car='$new_car', part='$new_part' WHERE car='$new_car'";
                    if ($conn->query($updateSql) === TRUE) {
                        echo "Record updated successfully";
                    } else {
                        echo "Error: " . $updateSql . "<br>" . $conn->error;
                    }
                }
            }

$carpart = isset($_POST['carpart']) ? $_POST['carpart'] : ''; // Using isset() to check if the variable is set
if (empty($addid)) {
    // If $carpart is empty, select all rows
    $sql = "SELECT * FROM car_part";
} else {
    $sql = "SELECT * FROM car_part where car='" . $carpart . "'";
}
$result = $conn->query($sql);

            echo "<h3 style='text-align: center; margin-top: 10px;'>Car_part Table</h3>";
            // Center the form and table
            echo "<div style='display: flex; justify-content: center; align-items: center; height: 100vh;'>";
            // Display input fields for each column
            echo "<form method='post' action='' style='text-align: center;'>";
                echo "<table id='carTable' style='border: 1px solid #000; border-collapse: collapse; width: 50%; text-align: center; margin-top: -90px;'>";
                    echo "<tr style='background-color: #f2f2f2;'>";
                        echo "<th style='border: 1px solid #000;color:black;'>Car</th><th style='border: 1px solid #000;color:black;'>Part</th>";
                    echo "</tr>";

                    // output data of each row
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                            echo "<td style='border: 1px solid #fff; text-align: center;'>" . $row["car"] . "</td> <td style='border: 1px solid #fff; text-align: center;'>" . $row["part"] . "</td>";
                        echo "</tr>";
                    }
                    // Single set of input fields for each column
                    echo "<tr>";
                        echo "<td style='border: 1px solid #fff; text-align: center;'>";
                            echo "<select name='car'>";
                                echo "<option value=''>Select Car</option>";
                                while ($rowCar = $resultCars->fetch_assoc()) {
                                    echo "<option value='" . $rowCar["name"] . "'>" . $rowCar["name"] . "</option>";
                                }
                            echo "</select>";
                        echo "</td>";
                            echo "<td style='border: 1px solid #fff; text-align: center;'>";
                                echo "<select name='part'>";
                                echo "<option value=''>Select Part</option>";
                                while ($rowPart = $resultParts->fetch_assoc()) {
                                    echo "<option value='" . $rowPart["no"] . "'>" . $rowPart["no"] . "</option>";
                                }
                            echo "</select>";
                        echo "</td>";
                        // Single submit buttons for insert and update
                        echo "<td> <button type='submit' name='insert'>Insert</button> </td>";
                    echo "</tr>";

                    // Input fields for update
                    echo "<tr>";
                        echo "<td style='border: 1px solid #fff; text-align: center;'><select name='new_car'>";
                            echo "<option value=''>Select New Car</option>";
                            $resultCars->data_seek(0); // Reset pointer to fetch options again
                            while ($rowCar = $resultCars->fetch_assoc()) {
                                echo "<option value='" . $rowCar["name"] . "'>" . $rowCar["name"] . "</option>";
                            }
                        echo "</select></td>";

                        echo "<td style='border: 1px solid #fff; text-align: center;'><select name='new_part'>";
                            echo "<option value=''>Select New Part</option>";
                            $resultParts->data_seek(0); // Reset pointer to fetch options again
                            while ($rowPart = $resultParts->fetch_assoc()) {
                                echo "<option value='" . $rowPart["no"] . "'>" . $rowPart["no"] . "</option>";
                            }
                        echo "</select></td>";
                        // Single submit buttons for insert and update
                        echo "<td> <button type='submit' name='update'>Update</button> </td>";
                    echo "</tr>";
                echo "</table>";

                // Single search button
                echo "<br><label for='carpart'>Car Name:</label>";
                echo "<input type='text' id='carpart' name='carpart'>";
                echo "<button type='button' id='b'>Search</button>";
                echo "<div id='result'></div>";

            echo "</form>";
            $conn->close();
        ?>
        <script>
        $(document).ready(function () {
            $("#b").click(function () {
                // Check if the search input is empty
                var carpart = $("#carpart").val();
                if (carpart.trim() === "") {
                    // If empty, reload the original table
                    location.reload();
                } else {
                    // If not empty, send an AJAX request
                    $.post("car_partsearch.php", {
                        carpart: carpart
                    }, function (data, status) {
                        // Replace the table rows with the search results
                        $("#carTable").html(data);
                    });
                }
            });
        });
    </script>
    </body>
</html>