<?php
include "/var/www/html/functions.php";


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql_find_names = "SELECT patient_name, patient_id FROM patient_personal_data";
$all_patients = mysqli_query($conn,$sql_find_names);

$sql_find_surgery_types = "SELECT type_name, surgery_code FROM surgery_types";
$all_surgeries = mysqli_query($conn,$sql_find_surgery_types);

?>




<!DOCTYPE html>
<html lang="en">
   <head>
      <title>Schedule a Surgery</title>
   </head>
   <body>
      <center>
         <h1>Schedule a Surgery</h1>

         <form action="schedule-surgery-team.php" method="post">

         <label>Select a Patient</label>
        <select name="patient">
            <?php
                // use a while loop to fetch data
                // from the $all_categories variable
                // and individually display as an option
                while ($patients = mysqli_fetch_array(
                        $all_patients,MYSQLI_ASSOC)):;
            ?>
                <option value="<?php echo $patients["patient_id"];
                    // The value we usually set is the primary key
                ?>">
                    <?php echo $patients["patient_name"] . " ".$patients["patient_id"];
                        // To show the employee name to the user
                    ?>
                </option>
            <?php
                endwhile;
                // While loop must be terminated
            ?>
        </select>
        <br>
        <label>Select a Surgery Type</label>
        <select name="surgery">
            <?php
                // use a while loop to fetch data
                // from the $all_categories variable
                // and individually display as an option
                while ($surgeries = mysqli_fetch_array(
                        $all_surgeries,MYSQLI_ASSOC)):;
            ?>
                <option value="<?php echo $surgeries["surgery_code"];
                    // The value we usually set is the primary key
                ?>">
                    <?php echo $surgeries["type_name"] . " ".$surgeries["surgery_code"];
                        // To show the surgery name to the user
                    ?>
                </option>
            <?php
                endwhile;
                // While loop must be terminated
            ?>
        </select>
        <p>
               <label for="operating_theater">Operating Theater:</label>
               <select name="operating_theater" required>
               <option value="">Select...</option>
               <option value="1">1</option>
               <option value="2">2</option>
               <option value="3">3</option>
               <option value="4">4</option>
               <option value="5">5</option>
               <option value="6">6</option>
               <option value="7">7</option>
               </select>
</p>
<p>
               <label for="date">Date:</label>
               <input type="date" name="date" id="date" required>
            </p>
<p>
               <label for="time">Time:</label>
               <input type="time" name="time" id="time" required>
            </p>

            <input type="submit" name="button" value="Find a Team">
         </form>
      </center>
   </body>
   <?php   $conn->close(); ?>
</html>
