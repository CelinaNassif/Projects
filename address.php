<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <title>Address Page</title>
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
            if (isset($_POST["insert"])) {
                // Insert data into the "address" table
                $id = $_POST["id"];
                $buidling = $_POST["buidling"];
                $street = $_POST["street"];
                $city = $_POST["city"];
                $country = $_POST["country"];

                $insertSql = "INSERT INTO address (id, buidling, street, city, country) VALUES ('$id', '$buidling', '$street', '$city', '$country')";
                if ($conn->query($insertSql) === TRUE) {
                    echo "<div style='color: green; text-align: center;'>New record added successfully</div>";
                } else {
                    echo "<div style='color: red; text-align: center;'>Error: " . $insertSql . "<br>" . $conn->error . "</div>";
                }
            } elseif (isset($_POST["update"])) {
                // Update data in the "address" table
                $id = $_POST["update_id"];
                $buidling = $_POST["update_building"];
                $street = $_POST["update_street"];
                $city = $_POST["update_city"];
                $country = $_POST["update_country"];

                $updateSql = "UPDATE address SET buidling='$buidling', street='$street', city='$city', country='$country' WHERE id='$id'";
                if ($conn->query($updateSql) === TRUE) {
                    echo "<div style='color: green; text-align: center;'>Record updated successfully</div>";
                } else {
                    echo "<div style='color: red; text-align: center;'>Error: " . $updateSql . "<br>" . $conn->error . "</div>";
                }
            }
        }
     
        $addid = isset($_POST['addid']) ? $_POST['addid'] : ''; 
        if (empty($addid)) {
            // If $addid is empty, select all rows
            $sql = "SELECT * FROM address";
        } else {
            $sql = "SELECT * FROM address where id='" . $addid . "'";
        }
        $result = $conn->query($sql);
        
        echo "<h3 style='text-align: center; margin-top: 10px;'>Address Table </h3>";
        echo "<div style='display: flex; justify-content: center; align-items: center; height: 100vh;'>";

        echo "<form method='post' action='' style='text-align: center;'>";
            echo "<table id='carTable'>";
                echo "<tr>";
                    echo "<th>ID</th><th>Building</th><th>Street</th><th>City</th><th>Country</th>";
                echo "</tr>";
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                        echo "<td>" . $row["id"] . "</td><td>" . $row["buidling"] . "</td><td>" . $row["street"] . "</td><td>" . $row["city"] . "</td><td>" . $row["country"] . "</td>";
                    echo "</tr>";
                }
                echo "<tr>";
                    echo "<td><input type='text' name='id' placeholder='ID'></td>";
                    echo "<td><input type='text' name='buidling' placeholder='Building'></td>";
                    echo "<td><input type='text' name='street' placeholder='Street'></td>";
                    echo "<td><input type='text' name='city' placeholder='City'></td>";
                    echo "<td><input type='text' name='country' placeholder='Country'></td>";
                    echo "<td><button type='submit' name='insert'>Insert</button></td>";
                echo "</tr>";
                echo "<tr>";
                    echo "<td><input type='text' name='update_id' placeholder='ID to Update'></td>";
                    echo "<td><input type='text' name='update_building' placeholder='New Building'></td>";
                    echo "<td><input type='text' name='update_street' placeholder='New Street'></td>";
                    echo "<td><input type='text' name='update_city' placeholder='New City'></td>";
                    echo "<td><input type='text' name='update_country' placeholder='New Country'></td>";
                    echo "<td><button type='submit' name='update'>Update</button></td>";
                echo "</tr>";
            echo "</table>";
            
            // Single search button
            echo "<br><label for='addid'>Address ID:</label>";
            echo "<input type='text' id='addid' name='addid'>";
            echo "<button type='button' id='b'>Search</button>";
            echo "<div id='result'></div>";
            
        echo "</form>";
        $conn->close();
    ?>
    <script>
        $(document).ready(function () {
            $("#b").click(function () {
                // Check if the search input is empty
                var addid = $("#addid").val();
                if (addid.trim() === "") {
                    // If empty, reload the original table
                    location.reload();
                } else {
                    // If not empty, send an AJAX request
                    $.post("addresssearch.php", {
                        addid: addid
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