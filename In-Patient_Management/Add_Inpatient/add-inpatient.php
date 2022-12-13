<?php
include "/var/www/html/functions.php";


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql_find_names = "SELECT patient_name, patient_id FROM patient_personal_data";
$all_patients = mysqli_query($conn,$sql_find_names);

$sql_find_beds = "SELECT bed_id, nursing_unit, wing, room_number, bed_number  FROM beds WHERE bed_id NOT IN (SELECT fk_inpatients_bed_id FROM inpatients)";
$all_beds = mysqli_query($conn,$sql_find_beds);

// public mysqli::multi_query(string $sql): bool


?>




<!DOCTYPE html>
<html lang="en">
   <head>
      <title>Add a Patient to Inpatient</title>
   </head>
   <body>
      <center>
         <h1>Choose a Patient</h1>

         <form action="insert-patient.php" method="post">

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
        <label>Select a bed</label>
        <select name="bed">
            <?php
                // use a while loop to fetch data
                // from the $all_categories variable
                // and individually display as an option
                while ($beds = mysqli_fetch_array(
                        $all_beds,MYSQLI_ASSOC)):;
            ?>
                <option value="<?php echo $beds["bed_id"];
                    // The value we usually set is the primary key
                ?>">
                    <?php echo $beds["bed_id"] . " Nursing Unit ".$beds["nursing_unit"] . " Wing ".$beds["wing"] . " Bed Label ".$beds["bed_number"];
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
            <input type="submit" name="button" value="Assign">
         </form>
      </center>
   </body>
</html>
