<?php
include "/var/www/html/functions.php";


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql_find_names = "SELECT patient_personal_data.patient_name, patient_personal_data.patient_id, nursing_unit, wing, room_number, bed_number
                    FROM patient_personal_data, inpatients, beds
                    WHERE patient_personal_data.patient_id =  fk_inpatients_patient_id
                    AND inpatients.fk_inpatients_bed_id = beds.bed_id";

$all_patients = mysqli_query($conn,$sql_find_names);

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

         <form action="remove-inpatient.php" method="post">

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
                    <?php echo $patients["patient_name"] .
                    " Patient ID: ".$patients["patient_id"] .
                    " Nursing Unit: ".$patients["nursing_unit"] .
                    " Wing: ".$patients["wing"] .
                    " Room Number: ".$patients["room_number"] .
                    " Bed Letter ".$patients["bed_number"];
                        // To show the employee name to the user
                    ?>
                </option>
            <?php
                endwhile;
                // While loop must be terminated
            ?>
        </select>
        <br>
            <input type="submit" name="button" value="delete">
         </form>
      </center>
   </body>

   <?php   $conn->close(); ?>
</html>
