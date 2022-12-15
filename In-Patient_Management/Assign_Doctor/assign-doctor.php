<?php
include "/var/www/html/functions.php";


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql_find_names = "SELECT patient_name, patient_id
                    FROM patient_personal_data
                    JOIN inpatients
                    ON inpatients.fk_inpatients_patient_id = patient_personal_data.patient_id
                    WHERE patient_id NOT IN (SELECT patient_id
                    FROM physician_inpatient_assignments)";
$all_patients = mysqli_query($conn,$sql_find_names);

$sql_find_phyisicans = "SELECT physicians.employee_name, physicians.physician_id FROM physicians";

$sql_find_physicians_result = mysqli_query($conn,$sql_find_phyisicans);

// public mysqli::multi_query(string $sql): bool


?>




<!DOCTYPE html>
<html lang="en">
   <head>
      <title>Assign a Doctor to Inpatient</title>
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
        <p>
               <label for="physician">Physician:</label>
               <select name="physician">
            <?php
                // use a while loop to fetch data
                // from the $all_categories variable
                // and individually display as an option
                while ($physicians = mysqli_fetch_array(
                  $sql_find_physicians_result,MYSQLI_ASSOC)):;
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
</p>
        <br>
            <input type="submit" name="button" value="Assign">
         </form>
      </center>
   </body>
</html>
