<?php
include "/var/www/html/functions.php";


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql_find_names = "SELECT patient_name, patient_id FROM patient_personal_data";
$all_patients = mysqli_query($conn,$sql_find_names);
$all_medical_patients = mysqli_query($conn,$sql_find_names);
$all_schedule_patients = mysqli_query($conn,$sql_find_names);

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

         <form action="view-patient.php" method="post">

         <label>Select a Patient To View Personal Information</label>
        <select name="view_patient">
            <?php
                // use a while loop to fetch data
                // from the $all_categories variable
                // and individually display as an option
                while ($view_patients = mysqli_fetch_array(
                        $all_patients,MYSQLI_ASSOC)):;
            ?>
                <option value="<?php echo $view_patients["patient_id"];
                    // The value we usually set is the primary key
                ?>">
                    <?php echo $view_patients["patient_name"] . " ".$view_patients["patient_id"];
                        // To show the employee name to the user
                    ?>
                </option>
            <?php
                endwhile;
                // While loop must be terminated
            ?>
        </select>
        <br>
            <input type="submit" name="button" value="View Patient Information">
         </form>

         <form action="view-medical-information.php" method="post">

<label>Select a Patient To View Medical Information</label>
<select name="view_medical">
   <?php
       // use a while loop to fetch data
       // from the $all_categories variable
       // and individually display as an option
       while ($view_medical_patients = mysqli_fetch_array(
               $all_medical_patients,MYSQLI_ASSOC)):;
   ?>
       <option value="<?php echo $view_medical_patients["patient_id"];
           // The value we usually set is the primary key
       ?>">
           <?php echo $view_medical_patients["patient_name"] . " ".$view_medical_patients["patient_id"];
               // To show the employee name to the user
           ?>
       </option>
   <?php
       endwhile;
       // While loop must be terminated
   ?>
</select>
<br>
   <input type="submit" name="button" value="View Medical Information">
</form>


   <form action="view-scheduled.php" method="post">

<label>Select a Patient to View All Consultations</label>
<select name="view_consultations">
   <?php
       // use a while loop to fetch data
       // from the $all_categories variable
       // and individually display as an option
       while ($view_consultations = mysqli_fetch_array(
               $all_schedule_patients,MYSQLI_ASSOC)):;
   ?>
       <option value="<?php echo $view_consultations["patient_id"];
           // The value we usually set is the primary key
       ?>">
           <?php echo $view_consultations["patient_name"] . " ".$view_consultations["patient_id"];
               // To show the employee name to the user
           ?>
       </option>
   <?php
       endwhile;
       // While loop must be terminated
   ?>
</select>
<br>
   <input type="submit" name="button" value="View Scheduled Consultations">
</form>
        </center>
   </body>
</html>
