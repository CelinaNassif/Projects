<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <title>Customer Page</title>
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
                // Insert data into the "customer" table
                $id = $_POST["id"];
                $f_name = $_POST["f_name"];
                $l_name = $_POST["l_name"];
                $address = $_POST["address"];
                $job = $_POST["job"];

                $addressExistsSql = "SELECT COUNT(*) as count FROM address WHERE id = '$address'";
                $addressExistsResult = $conn->query($addressExistsSql);
                $addressExistsRow = $addressExistsResult->fetch_assoc();

                if ($addressExistsRow['count'] > 0) {
                    // The provided address exists, proceed with the INSERT
                    $insertSql = "INSERT INTO customer (id, f_name, l_name, address, job) VALUES ('$id', '$f_name', '$l_name', '$address', '$job')";
                    if ($conn->query($insertSql) === TRUE) {
                        echo "<div style='color: green; text-align: center;'>New record added successfully</div>";
                    } else {
                        $errorMessage = "Error: " . $conn->error;
                        echo "<div style='color: red; text-align: center;'>$errorMessage</div>";
                    }
                } else {
                    // The provided address does not exist, handle accordingly (e.g., show an error message)
                    echo "<div style='color: red; text-align: center;'>Error: The provided address does not exist.</div>";
                }
            } elseif (isset($_POST["update"])) {
                // Update data in the "customer" table
                $id = $_POST["update_id"];
                $f_name = $_POST["update_f_name"];
                $l_name = $_POST["update_l_name"];
                $address = $_POST["update_address"];
                $job = $_POST["update_job"];

                $updateSql = "UPDATE customer SET f_name='$f_name', l_name='$l_name', address='$address', job='$job' WHERE id='$id'";
                if ($conn->query($updateSql) === TRUE) {
                    echo "<div style='color: green; text-align: center;'>Record updated successfully</div>";
                } else {
                    $errorMessage = "Error: " . $conn->error;
                    echo "<div style='color: red; text-align: center;'>$errorMessage</div>";
                }
            }
        }
      
        $custID = isset($_POST['custID']) ? $_POST['custID'] : ''; // Using isset() to check if the variable is set
        if (empty($custID)) {
            // If $custID is empty, select all rows
            $sql = "SELECT * FROM customer";
        } else {
            $sql = "SELECT * FROM customer where id='" . $custID . "'";
        }
        $result = $conn->query($sql);
      
        echo "<h3 style='text-align: center; margin-top: 10px;'>Customer Table </h3>";
        echo "<div style='display: flex; justify-content: center; align-items: center; height: 100vh;'>";

        echo "<form method='post' action='' style='text-align: center;'>";
            echo "<table id='carTable'>";
                echo "<tr>";
                    echo "<th>ID</th><th>First Name</th><th>Last Name</th><th>Address</th><th>Job</th>";
                echo "</tr>";
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                        echo "<td>" . $row["id"] . "</td><td>" . $row["f_name"] . "</td><td>" . $row["l_name"] . "</td><td>" . $row["address"] . "</td><td>" . $row["job"] . "</td>";
                    echo "</tr>";
                }
                echo "<tr>";
                    echo "<td><input type='text' name='id' placeholder='ID'></td>";
                    echo "<td><input type='text' name='f_name' placeholder='First Name'></td>";
                    echo "<td><input type='text' name='l_name' placeholder='Last Name'></td>";
                    echo "<td>";
                        echo "<select name='address'>";
                            echo "<option value=''>Select Address</option>";
                            $sqlAddresses = "SELECT id FROM address";
                            $resultAddresses = $conn->query($sqlAddresses);
                            while ($rowAddress = $resultAddresses->fetch_assoc()) {
                                echo "<option value='" . $rowAddress["id"] . "'>" . $rowAddress["id"] . "</option>";
                            }
                        echo "</select>";
                    echo "</td>";
                    echo "<td><input type='text' name='job' placeholder='Job'></td>";
                    echo "<td><button type='submit' name='insert'>Insert</button></td>";
                echo "</tr>";

                echo "<tr>";
                    echo "<td><input type='text' name='update_id' placeholder='ID to Update'></td>";
                    echo "<td><input type='text' name='update_f_name' placeholder='New First Name'></td>";
                    echo "<td><input type='text' name='update_l_name' placeholder='New Last Name'></td>";
                    echo "<td>";
                        echo "<select name='update_address'>";
                            echo "<option value=''>Select Address</option>";
                            $sqlAddresses = "SELECT id FROM address";
                            $resultAddresses = $conn->query($sqlAddresses);
                            while ($rowAddress = $resultAddresses->fetch_assoc()) {
                                echo "<option value='" . $rowAddress["id"] . "'>" . $rowAddress["id"] . "</option>";
                            }
                        echo "</select>";
                    echo "</td>";
                    echo "<td><input type='text' name='update_job' placeholder='New Job'></td>";
                    echo "<td><button type='submit' name='update'>Update</button></td>";
                echo "</tr>";
            echo "</table>";

                // Single search button
                echo "<br><label for='custID'>Customer ID:</label>";
                echo "<input type='text' id='custID' name='custID'>";
                echo "<button type='button' id='b'>Search</button>";
                echo "<div id='result'></div>";

        echo "</form>";
        $conn->close();
    ?>
    <script>
        $(document).ready(function () {
            $("#b").click(function () {
                // Check if the search input is empty
                var custID = $("#custID").val();
                if (custID.trim() === "") {
                    // If empty, reload the original table
                    location.reload();
                } else {
                    // If not empty, send an AJAX request
                    $.post("CustomerSearch.php", {
                        custID: custID
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