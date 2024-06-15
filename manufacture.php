<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
        <title>Manufacture Page</title>
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
            input {
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
            if(isset($_SESSION['username'])){
            } else {
                header('Location: loginView.html');
            }

            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "carsproject";

            $conn = new mysqli($servername, $username, $password, $dbname);
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                // Handle form submission
                if (isset($_POST["insert"])) {
                    // Insert data into the "manufacture" table
                    $name = $_POST["insert_name"];
                    $type = $_POST["insert_type"];
                    $city = $_POST["insert_city"];
                    $country = $_POST["insert_country"];

                    $insertSql = "INSERT INTO manufacture (name, type, city, country) VALUES ('$name', '$type', '$city', '$country')";
                    if ($conn->query($insertSql) === TRUE) {
                        echo "<div style='color: green; text-align: center;'>New record added successfully</div>";
                    } else {
                        echo "<div style='color: red; text-align: center;'>Error: " . $insertSql . "<br>" . $conn->error . "</div>";
                    }
                } elseif (isset($_POST["update"])) {
                    // Update data in the "manufacture" table
                    $name = $_POST["update_name"];
                    $type = $_POST["update_type"];
                    $city = $_POST["update_city"];
                    $country = $_POST["update_country"];

                    $updateSql = "UPDATE manufacture SET type='$type', city='$city', country='$country' WHERE name='$name' ";
                    if ($conn->query($updateSql) === TRUE) {
                        echo "<div style='color: green; text-align: center;'>Record updated successfully</div>";
                    } else {
                        echo "<div style='color: red; text-align: center;'>Error: " . $updateSql . "<br>" . $conn->error . "</div>";
                    }
                }
            }

         
            $manName = isset($_POST['manName']) ? $_POST['manName'] : ''; // Using isset() to check if the variable is set
            if (empty($manName)) {
                // If $manName is empty, select all rows
                $sql = "SELECT * FROM manufacture";
            } else {
                $sql = "SELECT * FROM manufacture where name='" . $manName . "'";
            }
            $result = $conn->query($sql);
         
            echo "<h3 style='text-align: center; margin-top: 10px;'>Manufacture Table .</h3>";
            echo "<div style='display: flex; justify-content: center; align-items: center; height: 100vh;'>";

            echo "<form method='post' action='' style='text-align: center;'>";
                echo "<table id='carTable'>";
                    echo "<tr>";
                        echo "<th>Name</th><th>Type</th><th>City</th><th>Country</th>";
                    echo "</tr>";
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                            echo "<td>" . $row["name"] . "</td><td>" . $row["type"] . "</td><td>" . $row["city"] . "</td><td>" . $row["country"] . "</td>";
                        echo "</tr>";
                    }
                    echo "<tr>";
                        echo "<td><input type='text' name='insert_name' placeholder='New Name'></td>";
                        echo "<td><input type='text' name='insert_type' placeholder='New Type'></td>";
                        echo "<td><input type='text' name='insert_city' placeholder='New City'></td>";
                        echo "<td><input type='text' name='insert_country' placeholder='New Country'></td>";
                        echo "<td><button type='submit' name='insert'>Insert</button></td>";
                    echo "</tr>";
                    echo "<tr>";
                        echo "<td><input type='text' name='update_name' placeholder='New Name'></td>";
                        echo "<td><input type='text' name='update_type' placeholder='New Type'></td>";
                        echo "<td><input type='text' name='update_city' placeholder='New City'></td>";
                        echo "<td><input type='text' name='update_country' placeholder='New Country'></td>";
                        echo "<td><button type='submit' name='update'>Update</button></td>";
                    echo "</tr>";
                echo "</table>";
             
                    // Single search button
                    echo "<br><label for='manName'>Manufacure Name:</label>";
                    echo "<input type='text' id='manName' name='manName'>";
                    echo "<button type='button' id='b'>Search</button>";
                    echo "<div id='result'></div>";
             
            echo "</form>";
            $conn->close();
        ?>
        <script>
            $(document).ready(function () {
                $("#b").click(function () {
                    // Check if the search input is empty
                    var manName = $("#manName").val();
                    if (manName.trim() === "") {
                        // If empty, reload the original table
                        location.reload();
                    } else {
                        // If not empty, send an AJAX request
                        $.post("manufacturesearch.php", {
                            manName: manName
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