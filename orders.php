<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
        <title>Orders Page</title>
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

            // Fetch customer options for both insert and update
            $sqlCustomers = "SELECT id FROM customer";
            $resultCustomers = $conn->query($sqlCustomers);

            // Fetch car options for both insert and update
            $sqlCars = "SELECT name FROM car";
            $resultCars = $conn->query($sqlCars);

            // Handle form submission
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                // Insert data into the "orders" table
                if (isset($_POST["insert"])) {
                    $id = $_POST["id"];
                    $date = $_POST["date"];
                    $customer = $_POST["customer"];
                    $car = $_POST["car"];

                    $insertSql = "INSERT INTO orders (id, date, customer, car) VALUES ('$id', '$date', '$customer', '$car')";
                    if ($conn->query($insertSql) === TRUE) {
                        echo "New record added successfully";
                    } else {
                        echo "Error: " . $insertSql . "<br>" . $conn->error;
                    }
                }
                // Update data in the "orders" table
                elseif (isset($_POST["update"])) {
                    $id = $_POST["update_id"];
                    $date = $_POST["update_date"];
                    $customer = $_POST["update_customer"];
                    $car = $_POST["update_car"];

                    $updateSql = "UPDATE orders SET date='$date', customer='$customer', car='$car' WHERE id='$id'";
                    if ($conn->query($updateSql) === TRUE) {
                        echo "Record updated successfully";
                    } else {
                        echo "Error: " . $updateSql . "<br>" . $conn->error;
                    }
                }
            }
           
            $orderid = isset($_POST['orderid']) ? $_POST['orderid'] : ''; // Using isset() to check if the variable is set
            if (empty($orderid)) {
                // If $orderid is empty, select all rows
                $sql = "SELECT * FROM orders";
            } else {
                $sql = "SELECT * FROM orders where id='" . $orderid . "'";
            }
            $result = $conn->query($sql);
            
            echo "<h3 style='text-align: center; margin-top: 10px;'>Orders Table </h3>";
            // Center the form and table
            echo "<div style='display: flex; justify-content: center; align-items: center; height: 100vh;'>";

            echo "<form method='post' action='' style='text-align: center;'>";
                echo "<table id='carTable' style='border: 1px solid #000; border-collapse: collapse; width: 50%; text-align: center; margin-top: -90px;'>";
                    echo "<tr style='background-color: #f2f2f2;'>";
                        echo "<th style='border: 1px solid #000;color:black;'>ID</th><th style='border: 1px solid #000;color:black;'>Date</th><th style='border: 1px solid #000;color:black;'>Customer</th><th style='border: 1px solid #000;color:black;'>Car</th>";
                    echo "</tr>";
                    // output data of each row
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                            echo "<td style='border: 1px solid #fff; text-align: center;'>" . $row["id"] . "</td> <td style='border: 1px solid #fff; text-align: center;'>" . $row["date"] . "</td> <td style='border: 1px solid #fff; text-align: center;'>" . $row["customer"] . "</td> <td style='border: 1px solid #fff; text-align: center;'>" . $row["car"] . "</td>";
                        echo "</tr>";
                    }

                    echo "<tr>";
                        echo "<td style='border: 1px solid #fff; text-align: center;'><input type='text' name='id' placeholder='ID'></td>";
                        echo "<td style='border: 1px solid #fff; text-align: center;'><input type='text' name='date' placeholder='Date'></td>";

                        // Customer dropdown
                        echo "<td style='border: 1px solid #fff; text-align: center;'>";
                            echo "<select name='customer'>";
                                echo "<option value=''>Select Customer</option>";
                                $resultCustomers->data_seek(0); // Reset pointer to fetch options again
                                while ($rowCustomer = $resultCustomers->fetch_assoc()) {
                                    echo "<option value='" . $rowCustomer["id"] . "'>" . $rowCustomer["id"] . "</option>";
                                }
                            echo "</select>";
                        echo "</td>";

                        // Car dropdown
                        echo "<td style='border: 1px solid #fff; text-align: center;'>";
                            echo "<select name='car'>";
                                echo "<option value=''>Select Car</option>";
                                $resultCars->data_seek(0); // Reset pointer to fetch options again
                                while ($rowCar = $resultCars->fetch_assoc()) {
                                    echo "<option value='" . $rowCar["name"] . "'>" . $rowCar["name"] . "</option>";
                                }
                            echo "</select>";
                        echo "</td>";
                        echo "<td><button type='submit' name='insert' style='border: 1px solid #000;'>Insert</button></td>";
                    echo "</tr>";

                    // Input fields for update button
                    echo "<tr>";
                        echo "<td style='border: 1px solid #fff; text-align: center;'><input type='text' name='update_id' placeholder='ID'></td>";
                        echo "<td style='border: 1px solid #fff; text-align: center;'><input type='text' name='update_date' placeholder='New Date'></td>";

                        // Customer dropdown for update
                        echo "<td style='border: 1px solid #fff; text-align: center;'>";
                            echo "<select name='update_customer'>";
                                echo "<option value=''>Select Customer</option>";
                                $resultCustomers->data_seek(0); // Reset pointer to fetch options again
                                while ($rowCustomer = $resultCustomers->fetch_assoc()) {
                                    echo "<option value='" . $rowCustomer["id"] . "'>" . $rowCustomer["id"] . "</option>";
                                }
                            echo "</select>";
                        echo "</td>";

                        // Car dropdown for update
                        echo "<td style='border: 1px solid #fff; text-align: center;'>";
                            echo "<select name='update_car'>";
                                echo "<option value=''>Select Car</option>";
                                $resultCars->data_seek(0); // Reset pointer to fetch options again
                                while ($rowCar = $resultCars->fetch_assoc()) {
                                    echo "<option value='" . $rowCar["name"] . "'>" . $rowCar["name"] . "</option>";
                                }
                            echo "</select>";
                        echo "</td>";
                        echo "<td><button type='submit' name='update' style='border: 1px solid #000;'>Update</button></td>";
                    echo "</tr>";
                echo "</table>";
               
                // Single search button
                echo "<br><label for='orderid '>Order ID:</label>";
                echo "<input type='text' id='orderid' name='orderid'>";
                echo "<button type='button' id='b'>Search</button>";
                echo "<div id='result'></div>";
               
            echo "</form>";
            $conn->close();
        ?>
        <script>
                $(document).ready(function () {
                    $("#b").click(function () {
                        // Check if the search input is empty
                        var orderid = $("#orderid").val();
                        if (orderid.trim() === "") {
                            // If empty, reload the original table
                            location.reload();
                        } else {
                            // If not empty, send an AJAX request
                            $.post("ordersSearch.php", {
                                orderid: orderid
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