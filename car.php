<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
        <title>Car Page</title>
        <style>
            body {
                background-image: url('R.jpg');
                background-size: cover;
                background-repeat: no-repeat;
                background-attachment: fixed;
                color: #fff;
            font-family: Arial, sans-serif;
            }
            #carTable {
                /* border: 1px solid #000; */
                border-collapse: collapse;
                width: 70%;
                text-align: center;
                margin-top: -20px;
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
                // Extract values from the form
                $name = $_POST["name"];
                $model = $_POST["model"];
                $year = $_POST["year"];
                $made = $_POST["made"];

                // Insert data into the "car" table
                $insertSql = "INSERT INTO car (name, model, year, made) VALUES ('$name', '$model', '$year', '$made')";
                if ($conn->query($insertSql) === TRUE) {
                    echo "New record added successfully";
                } 
                else {
                    echo '<script>alert("Error: ' . $insertSql . '\\n' . $conn->error . '");</script>';
                }
            }

            $carName = isset($_POST['carName']) ? $_POST['carName'] : ''; // Using isset() to check if the variable is set
            if (empty($carName)) {
                // If $carName is empty, select all rows
                $sql = "SELECT * FROM car";
            } else {
                $sql = "SELECT * FROM car where name='" . $carName . "'";
            }
            $result = $conn->query($sql);

            echo "<h3 style='text-align: center; margin-top: 10px;'>Car Table </h3>";

            // Center the form and table
            echo "<div style='display: flex; justify-content: center; align-items: center; height: 80vh; width:100%'>";
            // Display input fields for each column
            echo "<form method='post' action='' style='text-align: center;'>";
                echo "<table id='carTable'>";
                    echo "<tr style='background-color: #f2f2f2;'>";
                        echo "<th style='border: 1px solid #000;color:black;'>Name</th><th style='border: 1px solid #000;color:black;'>Model</th><th style='border: 1px solid #000;color:black;'>Year</th><th style='border: 1px solid #000;color:black;'>Made</th>";
                    echo "</tr>";

                    // output data of each row
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                            echo "<td style='border: 1px solid #fff; text-align: center;'>" . $row["name"] . "</td>";
                            echo "<td style='border: 1px solid #fff; text-align: center;'>" . $row["model"] . "</td>";
                            echo "<td style='border: 1px solid #fff; text-align: center;'>" . $row["year"] . "</td>";
                            echo "<td style='border: 1px solid #fff; text-align: center;'>" . $row["made"] . "</td>";
                        echo "</tr>";
                    }

                    // Single set of input fields for each column
                    echo "<tr>";
                        echo "<td style='text-align: center;'><input type='text' name='name' placeholder='Name'></td>";
                        echo "<td style='text-align: center;'><input type='text' name='model' placeholder='Model'></td>";
                        echo "<td style='text-align: center;'><input type='text' name='year' placeholder='Year'></td>";

                        // Modified part for the "made" column during insertion
                        echo "<td style='text-align: center;'>";
                            echo "<select name='made'>";
                                echo "<option value=''>Select Made</option>";

                                $sqlNamess = "SELECT name FROM manufacture";
                                $resultNamess = $conn->query($sqlNamess);
                                // Populate the combo box with existing car names
                                while ($row = $resultNamess->fetch_assoc()) {
                                    echo "<option value='" . $row["name"] . "'>" . $row["name"] . "</option>";
                                }
                            echo "</select>";
                        echo "</td>";
                        echo "<td style='text-align: center;'><button type='submit'>Insert</button></td>";
                    echo "</tr>";

                    echo "<tr>";
                        echo "<td style='text-align: center;'><input type='text' id='updateName' placeholder='Name'></td>";
                        echo "<td style='text-align: center;'><input type='text' id='updateModel' placeholder='Model'></td>";
                        echo "<td style='text-align: center;'><input type='text' id='updateYear' placeholder='Year'></td>";

                        echo "<td style='text-align: center;'>";
                            echo "<select id='updateMade'>";
                                echo "<option value=''>Select Made</option>";

                                $sqlNamess = "SELECT name FROM manufacture";
                                $resultNamess = $conn->query($sqlNamess);
                                // Populate the combo box with existing car names
                                while ($row = $resultNamess->fetch_assoc()) {
                                    echo "<option value='" . $row["name"] . "'>" . $row["name"] . "</option>";
                                }
                            echo "</select>";
                        echo "</td>";
                        echo "<td id='updateButton' style='text-align: center;'><button type='submit'>Update</button></td>";
                    echo "</tr>";
                echo "</table>";

                // Single search button
                echo "<br><label for='carName'>Car Name:</label>";
                echo "<input type='text' id='carName' name='carName'>";
                echo "<button type='button' id='b'>Search</button>";
                echo "<div id='result'></div>";

            echo "</form>";
            $conn->close();
        ?>
        <script>
        $(document).ready(function () {
            $("#b").click(function () {
                // Check if the search input is empty
                var carName = $("#carName").val();
                if (carName.trim() === "") {
                    // If empty, reload the original table
                    location.reload();
                } else {
                    // If not empty, send an AJAX request
                    $.post("carSearch.php", {
                        carName: carName
                    }, function (data, status) {
                        // Replace the table rows with the search results
                        $("#carTable tbody").html(data);
                    });
                }
            });

            // Add click event handler for the update button
            $("button[type='submit']").click(function () {
                var updateName = $("#updateName").val();
                var updateModel = $("#updateModel").val();
                var updateYear = $("#updateYear").val();
                var updateMade = $("#updateMade").val();

                // Perform AJAX update request
                $.post("carUpdate.php", {
                    updateName: updateName,
                    updateModel: updateModel,
                    updateYear: updateYear,
                    updateMade: updateMade
                }, function (data, status) {
                    // Refresh the table with the updated data
                    location.reload();
                });
            });
        });

        function updateRow(name, model, year, made) {
            // Set the values of the update text fields based on the selected row
            $("#updateName").val(name);
            $("#updateModel").val(model);
            $("#updateYear").val(year);
            $("#updateMade").val(made);
        }
        </script>
    </body>
</html>