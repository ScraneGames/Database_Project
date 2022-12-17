<?php
include "/var/www/html/functions.php";


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql_find_positions = "SELECT UNIQUE position FROM staff";

$all_positions = mysqli_query($conn,$sql_find_positions);

// public mysqli::multi_query(string $sql): bool


?>




<!DOCTYPE html>
<html lang="en">
   <head>
      <title>Find Staff</title>
   </head>
   <body>
      <center>
      <h1>View All Staff</h1>

         <form action="view-schedule.php" method="post">

         <label>View All of The Staff</label>
        <br>
            <input type="submit" name="button" value="View All Schedules">
            <br>
            <br>
</form>
      <h1>View Based On Position</h1>

         <form action="view-schedule-per-position.php" method="post">

         <label>Select a Position</label>
        <select name="position">
            <?php
                // use a while loop to fetch data
                // from the $all_categories variable
                // and individually display as an option
                while ($positions = mysqli_fetch_array(
                    $all_positions,MYSQLI_ASSOC)):;
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
        <input type="submit" name="button" value="Choose Position">
        <br>
        <br>
            </form>

<form action="view-schedule-per-day.php" method="post">

<label>View Schedule Per Day</label>
<br>

           <label for="day">Select a Day To View Schedule:</label>
                           <select name="day" id="day">
                           <option value="">Select...</option>
                           <option value="sunday">Sunday</option>
                           <option value="monday">Monday</option>
                           <option value="tuesday">Tuesday</option>
                           <option value="wednesday">Wednesday</option>
                           <option value="thursday">Thursday</option>
                           <option value="friday">Friday</option>
                           <option value="saturday">Saturday</option>
                           </select>
                           <br>
            <input type="submit" name="button" value="View Schedule on Selected Day">
   <br>
   <br>
</form>

<?php   $conn->close(); ?>


         </form>
      </center>
   </body>
</html>
