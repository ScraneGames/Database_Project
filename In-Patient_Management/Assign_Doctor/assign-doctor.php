<?php
include "/var/www/html/functions.php";


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql_find_names = "SELECT patient_name, patient_id, attending_physician_id, employee_name, bed_id, nursing_unit, wing, room_number, bed_number
                    FROM patient_personal_data
                    JOIN inpatients
                    ON inpatients.fk_inpatients_patient_id = patient_personal_data.patient_id
                    JOIN beds
                    ON inpatients.fk_inpatients_bed_id = beds.bed_id
                    JOIN physicians
                    ON inpatients.attending_physician_id = physicians.physician_id
                    WHERE patient_id IN (SELECT patient_id
                    FROM inpatients)";
$all_patients = mysqli_query($conn,$sql_find_names);

$physician_array = mysqli_fetch_array($all_patients,MYSQLI_ASSOC);

$physician = $physician_array['attending_physician_id'];

$sql_find_phyisicans_less_7 = "SELECT physicians.employee_name, physicians.physician_id
                        FROM physicians
                        LEFT OUTER JOIN inpatients
                        ON physicians.physician_id = inpatients.attending_physician_id
                        WHERE physicians.position <> 'chief_of_staff'
                        GROUP BY physicians.physician_id
                        HAVING COUNT(inpatients.attending_physician_id) < 7";

$sql_find_physicians_less_7_result = mysqli_query($conn,$sql_find_phyisicans_less_7);

$sql_find_phyisicans_less_20 = "SELECT physicians.employee_name, physicians.physician_id
                        FROM physicians
                        LEFT OUTER JOIN inpatients
                        ON physicians.physician_id = inpatients.attending_physician_id
                        WHERE physicians.position <> 'chief_of_staff'
                        GROUP BY physicians.physician_id
                        HAVING COUNT(inpatients.attending_physician_id) < 20";

$sql_find_physicians_less_20_result = mysqli_query($conn,$sql_find_phyisicans_less_20);

// public mysqli::multi_query(string $sql): bool


?>




<!DOCTYPE html>
<html lang="en">
   <head>
      <title>Update the Doctor Assigned to the Inpatient</title>
   </head>
   <body>
      <center>
         <h1>Choose a Patient</h1>

         <form action="insert-assign-doctor.php" method="post">

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
                    <?php echo $patients["patient_name"] . " Patient ID: ".$patients["patient_id"] . " Attending Physician: ".$patients["attending_physician_id"] .
                    " Unit: ".$patients["nursing_unit"] . " Wing: ".$patients["wing"] . " Room: ".$patients["room_number"] . " Bed: ".$patients["bed_number"];
                        // To show the employee name to the user
                    ?>
                </option>
            <?php
                endwhile;
                // While loop must be terminated
            ?>
        </select>
        <br>
        <?php if (mysqli_num_rows($sql_find_physicians_less_7_result) > 0): ?>
<p>
               <label for="primary_less_7">Assign A Physician:</label>
               <select name="primary_less_7">
            <?php
                // use a while loop to fetch data
                // from the $all_categories variable
                // and individually display as an option
                while ($primary_less_7 = mysqli_fetch_array(
                  $sql_find_physicians_less_7_result,MYSQLI_ASSOC)):;
            ?>
                <option value="<?php echo $primary_less_7["physician_id"];
                    // The value we usually set is the primary key
                ?>">
                    <?php echo $primary_less_7["employee_name"] . " ".$primary_less_7["physician_id"];
                        // To show the employee name to the user
                    ?>
                </option>
               <?php
               endwhile;
               // While loop must be terminated
         ?>
      </select>
</p>
      <?php elseif (mysqli_num_rows($sql_find_physicians_less_20_result) > 0): ?>
<p>
         <label for="primary_less_20">Primary Physician:</label>
                        <select name="primary_less_20">
                     <?php
                        // use a while loop to fetch data
                        // from the $all_categories variable
                        // and individually display as an option
                        while ($primary_less_20 = mysqli_fetch_array(
                           $sql_find_physicians_less_20_result,MYSQLI_ASSOC)):;
                     ?>
                        <option value="<?php echo $primary_less_20["physician_id"];
                           // The value we usually set is the primary key
                        ?>">
                           <?php echo $primary_less_20["employee_name"] . " ".$primary_less_20["physician_id"];
                                 // To show the employee name to the user
                           ?>
                        </option>
                        <?php
                        endwhile;
                        // While loop must be terminated
                        ?>
      </select>
      <?php endif; ?>
      <br>

</p>
        <br>
            <input type="submit" name="button" value="Assign">
         </form>
      </center>
   </body>
   <?php   $conn->close(); ?>
</html>
