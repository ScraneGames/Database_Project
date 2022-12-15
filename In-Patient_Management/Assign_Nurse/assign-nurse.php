<?php
include "/var/www/html/functions.php";


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql_find_names = "SELECT patient_name, patient_id, bed_id, nursing_unit, wing, room_number, bed_number
                    FROM patient_personal_data
                    JOIN inpatients
                    ON inpatients.fk_inpatients_patient_id = patient_personal_data.patient_id
                    JOIN beds
                    ON inpatients.fk_inpatients_bed_id = beds.bed_id
                    WHERE patient_id
                    NOT IN (SELECT fk_assignment_patient_id FROM nurse_inpatient_assignments)";
$all_patients = mysqli_query($conn,$sql_find_names);

$sql_find_nurses_less_5 = "SELECT staff.employee_name, nurses.nurse_id
                        FROM staff
                        JOIN nurses
                        ON  staff.employee_id = nurses.employee_id
                        LEFT OUTER JOIN nurse_inpatient_assignments
                        ON nurses.nurse_id = fk_assignment_nurse_id
                        GROUP BY nurses.nurse_id
                        HAVING COUNT(nurse_inpatient_assignments.fk_assignment_nurse_id) < 5";

$sql_find_nurses_less_5_result = mysqli_query($conn,$sql_find_nurses_less_5);

$sql_find_all_nurses = "SELECT staff.employee_name, nurses.nurse_id FROM staff, nurses";

$sql_find_all_nurses_result = mysqli_query($conn,$sql_find_all_nurses);

// public mysqli::multi_query(string $sql): bool


?>




<!DOCTYPE html>
<html lang="en">
   <head>
      <title>Assign a Nurse to an Inpatient</title>
   </head>
   <body>
      <center>
         <h1>Choose a Patient</h1>

         <form action="insert-assign-nurse.php" method="post">

         <label>Select a Patient</label>
        <select name="patient">
            <?php
                // use a while loop to fetch data
                // from the $all_categories variable
                // and individually display as an option
                while ($patients = mysqli_fetch_array(
                        $all_patients,MYSQLI_ASSOC)):;
            ?>
                <option value="<?php echo $patients["fk_inp_patient_id"];
                    // The value we usually set is the primary key
                ?>">
                    <?php echo $patients["patient_name"] .
                    " Patient ID: ".$patients["patient_id"] .
                    " Unit: ".$patients["nursing_unit"] .
                    " Wing: ".$patients["wing"] .
                    " Room#: ".$patients["room_number"] .
                    " Bed: ".$patients["bed_number"];
                        // To show the employee name to the user
                    ?>
                </option>
            <?php
                endwhile;
                // While loop must be terminated
            ?>
        </select>
        <br>
        <?php if (mysqli_num_rows($sql_find_nurses_less_5) > 0): ?>
<p>
               <label for="nurse_less_5">Nurse:</label>
               <select name="nurse_less_5">
            <?php
                // use a while loop to fetch data
                // from the $all_categories variable
                // and individually display as an option
                while ($nurses_less_5 = mysqli_fetch_array(
                    $sql_find_nurses_less_5_result,MYSQLI_ASSOC)):;
            ?>
                <option value="<?php echo $nurses_less_5["nurse_id"];
                    // The value we usually set is the primary key
                ?>">
                    <?php echo $nurses_less_5["employee_name"] . " Nurse ID: ".$nurses_less_5["nurse_id"];
                        // To show the employee name to the user
                    ?>
                </option>
               <?php
               endwhile;
               // While loop must be terminated
         ?>
      </select>
</p>
      <?php else: ?>
<p>
         <label for="all_nurse">Nurse:</label>
                        <select name="all_nurse">
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
                           <?php echo $all_nurses["employee_name"] . " Nurse ID: ".$all_nurses["nurse_id"];
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
            <input type="submit" name="button" value="Assign">
         </form>
      </center>
   </body>
</html>
