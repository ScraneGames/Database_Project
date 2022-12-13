<?php
include "/var/www/html/functions.php";


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql_find_names = "SELECT patient_name, patient_id FROM patient_personal_data";

$all_patients = mysqli_query($conn,$sql_find_names);

$sql_find_physicians = "SELECT employee_name, physician_id FROM physicians";

$all_physicians = mysqli_query($conn,$sql_find_physicians);

// public mysqli::multi_query(string $sql): bool


?>




<!DOCTYPE html>
<html lang="en">
   <head>
      <title>Find Patient</title>
   </head>
   <body>
      <center>
         <h1>Choose a Patient</h1>

         <form action="insert-consultation.php" method="post">

         <label>Select a Patient</label>
        <select name="patient" required>
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
                    <?php echo $patiens["patient_name"] . " ".$patients["patient_id"];
                        // To show the employee name to the user
                    ?>
                </option>
            <?php
                endwhile;
                // While loop must be terminated
            ?>
        </select>
        <br>
        <label>Select a Physician</label>
        <select name="physician" required>
            <?php
                // use a while loop to fetch data
                // from the $all_categories variable
                // and individually display as an option
                while ($physicians = mysqli_fetch_array(
                        $all_physicians,MYSQLI_ASSOC)):;
            ?>
                <option value="<?php echo $physicians["physician_id"];
                    // The value we usually set is the primary key
                ?>">
                    <?php echo $physicians["employee_name"] . " ".$physicians["physician_id"];
                        // To show the employee name to the user
                    ?>
                </option>
            <?php
                endwhile;
                // While loop must be terminated
            ?>
        </select>
        <br>
        <p>
               <label for="date">Date:</label>
               <input type="date" name="date" id="date" required>
            </p>
            <p>
               <label for="time">Time:</label>
               <input type="time" name="time" id="time" required>
            </p>

            <input type="submit" name="button" value="submit">
         </form>
      </center>
   </body>
</html>
