<?php
include "/var/www/html/functions.php";


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql_find_names = "SELECT patient_personal_data.patient_name, patient_personal_data.patient_id, staff.employee_name, nurses.nurse_id
                    FROM patient_personal_data, nurse_inpatient_assignments, nurses, staff
                    WHERE patient_personal_data.patient_id = nurse_inpatient_assignments.fk_ass_Patient_ID
                    AND nurse_inpatient_assignments.fk_ass_Nurse_ID = nurses.nurse_id
                    AND nurses.employee_id = staff.employee_id";

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

         <form action="remove-nurse.php" method="post">

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
                    <?php echo $patients["patient_name"] . " Patient ID: ".$patients["patient_id"] . " Nurse To be Unassigned: ".$patients["employee_name"] . " Nurse ID: ".$patients["nurse_id"];
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
</html>
