<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DataBase Tables</title>
    <style>
      * { 
        box-sizing: border-box; 
      }
      body { 
        font-family: Arial, sans-serif; 
        margin: 0;
        padding: 2rem; 
        background-color: rgb(196, 196, 196);
        background-image: url('R.jpeg');
        background-size: cover;
        background-repeat: no-repeat;
        background-attachment: fixed;
        color: #ffffff;
      }
      h1 { 
        color: #000000; 
        text-align: center; 
        font-size: 2.5em
      }
      button { 
        width: 19%; 
        background:coral; 
        color: white; 
        height: 45px; 
        font: size 14px; 
        margin: 8px; 
        margin-left: 40%;
      }
      #logout{
        width: 70px; 
        background:coral; 
        color: white; 
        height: 35px; 
        font: size 14px; 
        margin: 8px; 
        margin-left: 20px;
      }
      #logout:hover{
        background: #333; 
      }
      button:hover{
        background: #333;
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
    ?>
    <button id="logout" onclick="window.location.href='logout.php'">logout</button>

<h1 style="text-align: center;color: white;">Welcome To Cars Project Done By Celina</h1>
    <button onclick="window.location.href='address.php'">address table</button>
    <br>
    <button onclick="window.location.href='car_part.php'">car_part table</button>
    <br>
    <button onclick="window.location.href='car.php'">car table</button>
    <br>
    <button onclick="window.location.href='customer.php'">customer table</button>
    <br>
    <button onclick="window.location.href='device.php'">device table</button>
    <br>
    <button onclick="window.location.href='manufacture.php'">manufacture table</button>
    <br>
    <button onclick="window.location.href='orders.php'">orders table</button>
    <br>
 

  </body>
</html>