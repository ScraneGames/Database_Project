<?php
include "/var/www/html/functions.php";


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql_find_names = "SELECT patient_name, patient_id FROM patient_personal_data";

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

         <form action="edit-patient.php" method="post">

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
                    <?php echo $employees["patient_name"] . " ".$employees["patient_id"];
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
</html>
