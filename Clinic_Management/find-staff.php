<?php
include "/var/www/html/functions.php";


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql_find_names = "SELECT UNIQUE employee_name FROM staff";

public mysqli::multi_query(string $sql): bool


?>




<!DOCTYPE html>
<html lang="en">
   <head>
      <title>Find Staff</title>
   </head>
   <body>
      <center>
         <h1>Choose an Employee</h1>

         <form action="edit-staff.php" method="post">

<p>
               <label for="allergy_name">Allergy Name:</label>
               <input type="text" name="allergy_name" id="allergy_name">
            </p>


<p>
               <label for="allergy_desc">Allergy Description:</label>
               <input type="text" name="allergy_desc" id="allergy_desc">
            </p>

            <input type="submit" value="Submit">
         </form>
      </center>
   </body>
</html>
