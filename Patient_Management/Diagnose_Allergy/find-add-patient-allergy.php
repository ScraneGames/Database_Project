<?php
include "/var/www/html/functions.php";


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql_find_names = "SELECT patient_name, patient_id FROM patient_personal_data ORDER BY patient_name";
$all_patients = mysqli_query($conn,$sql_find_names);

$sql_find_allergies = "SELECT allergy_name, allergy_code FROM allergies ORDER BY allergy_name";
$all_allergies = mysqli_query($conn,$sql_find_allergies);

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

         <form action="insert-add-patient-allergy.php" method="post">

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
        <label>Select an Allergy</label>
        <select name="allergy">
            <?php
                // use a while loop to fetch data
                // from the $all_categories variable
                // and individually display as an option
                while ($allergies = mysqli_fetch_array(
                        $all_allergies,MYSQLI_ASSOC)):;
            ?>
                <option value="<?php echo $allergies["allergy_code"];
                    // The value we usually set is the primary key
                ?>">
                    <?php echo $allergies["allergy_name"] . " ".$allergies["allergy_code"];
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
   <?php   $conn->close(); ?>
</html>
