<?php
include "/var/www/html/functions.php";


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql_find_all_nurses = "SELECT UNIQUE staff.employee_name, nurses.nurse_id FROM staff, nurses WHERE staff.employee_id = nurses.employee_id
                        AND nurses.nurse_id NOT IN (SELECT nurse_id FROM nurse_surgery_assignments)";
$sql_find_all_nurses_result = mysqli_query($conn,$sql_find_all_nurses);

// public mysqli::multi_query(string $sql): bool


?>




<!DOCTYPE html>
<html lang="en">
   <head>
      <title>Choose a Nurse to Assign to Surgery</title>
   </head>
   <body>
      <center>
      <form action="pair-nurse-surgery.php" method="post">
<p>
         <label for="all_nurse">Nurse:</label>
                        <select name="nurse">
                     <?php
                        // use a while loop to fetch data
                        // from the $all_categories variable
                        // and individually display as an option
                        while ($all_nurses = mysqli_fetch_array(
                            $sql_find_all_nurses_result,MYSQLI_ASSOC)):;
                     ?>
                        <option value="<?php echo $all_nurses["nurse_id"];
                           // The value we usually set is the primary key
                        ?>">
                           <?php echo $all_nurses["employee_name"] . " Nurse ID: " . $all_nurses["nurse_id"];
                                 // To show the employee name to the user
                           ?>
                        </option>
                        <?php
                        endwhile;
                        // While loop must be terminated
                        ?>
      </select>
      <br>
</p>
            <input type="submit" name="button" value="Assign">
         </form>
      </center>
   </body>
</html>
