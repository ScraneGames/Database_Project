<?php
include "/var/www/html/functions.php";


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql_find_names = "SELECT employee_name, employee_id FROM staff";

$all_employees = mysqli_query($conn,$sql);

// public mysqli::multi_query(string $sql): bool


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

         <label>Select an Employee</label>
        <select name="employee">
            <?php
                // use a while loop to fetch data
                // from the $all_categories variable
                // and individually display as an option
                while ($employees = mysqli_fetch_array(
                        $all_employees,MYSQLI_ASSOC)):;
            ?>
                <option value="<?php echo $employee["employee_id"];
                    // The value we usually set is the primary key
                ?>">
                    <?php echo $employee["employee_name"];
                        // To show the category name to the user
                    ?>
                </option>
            <?php
                endwhile;
                // While loop must be terminated
            ?>
        </select>
        <br>
            <input type="submit" value="Submit">
         </form>
      </center>
   </body>
</html>
