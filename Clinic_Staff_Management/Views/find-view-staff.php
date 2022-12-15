<?php
include "/var/www/html/functions.php";


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql_find_positions = "SELECT position FROM staff";

$all_positions = mysqli_query($conn,$sql_find_positions);

// public mysqli::multi_query(string $sql): bool


?>




<!DOCTYPE html>
<html lang="en">
   <head>
      <title>Find Patient</title>
   </head>
   <body>
      <center>
      <h1>View All Schedules</h1>

         <form action="view-schedule.php" method="post">

         <label>Select a Patient</label>
        <br>
            <input type="submit" name="button" value="View All Schedules">
            <br>
            <br>
</form>
      <h1>View Based On Position</h1>

         <form action="edit-medical-information.php" method="post">

         <label>Select a Position</label>
        <select name="position">
            <?php
                // use a while loop to fetch data
                // from the $all_categories variable
                // and individually display as an option
                while ($positions = mysqli_fetch_array(
                        $all_ppositions,MYSQLI_ASSOC)):;
            ?>
                <option value="<?php echo $positions["position"];
                    // The value we usually set is the primary key
                ?>">
                    <?php echo $positions["position"];
                        // To show the employee name to the user
                    ?>
                </option>
            <?php
                endwhile;
                // While loop must be terminated
            ?>
        </select>
        <br>
            <input type="submit" name="button" value="Update">
         </form>
      </center>
   </body>
</html>
