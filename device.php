<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
        <title>Device Page</title>
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
                width: 50%;
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
            input, select {
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

            // Handle form submission
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                if (isset($_POST["insert"])) {
                    // Insert data into the "device" table
                    $no = $_POST["no"];
                    $name = $_POST["name"];
                    $price = $_POST["price"];
                    $weight = $_POST["weight"];
                    $made = $_POST["made"];

                    $insertSql = "INSERT INTO device (no, name, price, weight, made) VALUES ('$no', '$name', '$price', '$weight', '$made')";
                    if ($conn->query($insertSql) === TRUE) {
                        echo "<div style='color: green; text-align: center;'>New record added successfully</div>";
                    } else {
                        $errorMessage = "Error: " . $conn->error;
                        echo "<div style='color: red; text-align: center;'>$errorMessage</div>";
                    }
                } elseif (isset($_POST["update"])) {
                    // Update data in the "device" table
                    $no = $_POST["update_no"];
                    $name = $_POST["update_name"];
                    $price = $_POST["update_price"];
                    $weight = $_POST["update_weight"];
                    $made = $_POST["update_made"];

                    $updateSql = "UPDATE device SET name='$name', price='$price', weight='$weight', made='$made' WHERE no='$no'";
                    if ($conn->query($updateSql) === TRUE) {
                        echo "<div style='color: green; text-align: center;'>Record updated successfully</div>";
                    } else {
                        $errorMessage = "Error: " . $conn->error;
                        echo "<div style='color: red; text-align: center;'>$errorMessage</div>";
                    }
                }
            }
           
                    $devNo = isset($_POST['devNo']) ? $_POST['devNo'] : ''; // Using isset() to check if the variable is set
                    if (empty($devNo)) {
                        // If $devNo is empty, select all rows
                        $sql = "SELECT * FROM device";
                    } else {
                        $sql = "SELECT * FROM device where no='" . $devNo . "'";
                    }
                    $result = $conn->query($sql);
           

            // Fetch manufacturers for the combo box
            $manufacturerSql = "SELECT name FROM manufacture";
            $manufacturerResult = $conn->query($manufacturerSql);
            $manufacturers = [];
            while ($rowManufacturer = $manufacturerResult->fetch_assoc()) {
                $manufacturers[] = $rowManufacturer["name"];
            }

            echo "<h3 style='text-align: center; margin-top: 10px;'>Device Table</h3>";
            echo "<div style='display: flex; justify-content: center; align-items: center; height: 100vh;'>";

            echo "<form method='post' action='' style='text-align: center;'>";
                echo "<table id='carTable'>";
                    echo "<tr>";
                        echo "<th style='border: 1px solid #000;color:black;'>NO</th><th style='border: 1px solid #000;color:black;'>Name</th><th style='border: 1px solid #000;color:black;'>Price</th><th style='border: 1px solid #000;color:black;'>Weight</th><th style='border: 1px solid #000;color:black;'>Made</th>";
                    echo "</tr>";
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                            echo "<td style='border: 1px solid #fff; text-align: center;'>" . $row["no"] . "</td><td style='border: 1px solid #fff; text-align: center;'>" . $row["name"] . "</td><td style='border: 1px solid #fff; text-align: center;'>" . $row["price"] . "</td><td style='border: 1px solid #fff; text-align: center;'>" . $row["weight"] . "</td><td style='border: 1px solid #fff; text-align: center;'>" . $row["made"] . "</td>";
                        echo "</tr>";
                    }

                    echo "<tr>";
                        echo "<td style='border: 1px solid #000; text-align: center;'><input type='text' name='no' placeholder='NO'></td>";
                        echo "<td style='border: 1px solid #000; text-align: center;'><input type='text' name='name' placeholder='Name'></td>";
                        echo "<td style='border: 1px solid #000; text-align: center;'><input type='text' name='price' placeholder='Price'></td>";
                        echo "<td style='border: 1px solid #000; text-align: center;'><input type='text' name='weight' placeholder='Weight'></td>";
                        echo "<td style='border: 1px solid #000; text-align: center;'>";
                            echo "<select name='made'>";
                                echo "<option value=''>Select Manufacturer</option>";
                                foreach ($manufacturers as $manufacturer) {
                                    echo "<option value='$manufacturer'>$manufacturer</option>";
                                }
                            echo "</select>";
                        echo "</td>";
                        echo "<td style='text-align: center;'><button type='submit' name='insert'>Insert</button></td>";
                    echo "</tr>";

                    echo "<tr>";
                        echo "<td style='border: 1px solid #000; text-align: center;'><input type='text' name='update_no' placeholder='NO to Update'></td>";
                        echo "<td style='border: 1px solid #000; text-align: center;'><input type='text' name='update_name' placeholder='New Name'></td>";
                        echo "<td style='border: 1px solid #000; text-align: center;'><input type='text' name='update_price' placeholder='New Price'></td>";
                        echo "<td style='border: 1px solid #000; text-align: center;'><input type='text' name='update_weight' placeholder='New Weight'></td>";
                        echo "<td style='border: 1px solid #000; text-align: center;'>";
                            echo "<select name='update_made'>";
                                echo "<option value=''>Select New Manufacturer</option>";
                                foreach ($manufacturers as $manufacturer) {
                                    echo "<option value='$manufacturer'>$manufacturer</option>";
                                }
                            echo "</select>";
                        echo "</td>";
                        echo "<td style='text-align: center;'><button type='submit' name='update'>Update</button></td>";
                    echo "</tr>";
                echo "</table>";
               
                // Single search button
                echo "<br><label for='devNo'>Device No:</label>";
                echo "<input type='text' id='devNo' name='devNo'>";
                echo "<button type='button' id='b'>Search</button>";
                echo "<div id='result'></div>";
               
            echo "</form>";
            $conn->close();
        ?>
        <script>
            $(document).ready(function () {
                $("#b").click(function () {
                    // Check if the search input is empty
                    var devNo = $("#devNo").val();
                    if (devNo.trim() === "") {
                        // If empty, reload the original table
                        location.reload();
                    } else {
                        // If not empty, send an AJAX request
                        $.post("devicesearch.php", {
                            devNo: devNo
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