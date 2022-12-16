<?php
include "/var/www/html/functions.php";


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql_find_names = "SELECT UNIQUE patient_name, patient_id FROM view_consultations";
$all_schedule_patients = mysqli_query($conn,$sql_find_names);

$sql_find_date = "SELECT UNIQUE date FROM view_consultations";
$all_dates = mysqli_query($conn,$sql_find_date);

$sql_find_physicians = "SELECT UNIQUE employee_name, physician_id
                        FROM physicians";
$all_surgeons = mysqli_query($conn,$sql_find_surgeons);



// public mysqli::multi_query(string $sql): bool


?>




<!DOCTYPE html>
<html lang="en">
   <head>
      <title>Choose How You Would Like To View The Consultations</title>
   </head>
   <body>
      <center>
         <h1>Choose How You Would Like To View the Consultations</h1>

         <form action="view-all-consultations.php" method="post">

         <label>View all consultations</label>
        <br>
        <br>
            <input type="submit" name="button" value="View All Consultations">
         </form>
         <br>
         <br>

    <form action="view-patient-consultations.php" method="post">

<label>Select a Patient to View All Consultations</label>
<br>
<select name="view_consultations_per_patient">
    <br>
   <?php
       // use a while loop to fetch data
       // from the $all_categories variable
       // and individually display as an option
       while ($view_consultations_per_patient = mysqli_fetch_array(
               $all_schedule_patients,MYSQLI_ASSOC)):;
   ?>
       <option value="<?php echo $view_consultations_per_patient["patient_id"];
           // The value we usually set is the primary key
       ?>">
           <?php echo $view_consultations_per_patient["patient_name"] . " Patient ID: ".$view_consultations_per_patient["patient_id"];
               // To show the employee name to the user
           ?>
       </option>
   <?php
       endwhile;
       // While loop must be terminated
   ?>
</select>
<br>
<br>
   <input type="submit" name="button" value="View Consultations For This Patient">
   <br>
<br>
</form>

<form action="view-consultations-by-date.php" method="post">

<label>Select a Date to View All Consultations On That Date</label>
<br>
<select name="view_consultations_per_date">
   <?php
       // use a while loop to fetch data
       // from the $all_categories variable
       // and individually display as an option
       while ($view_consultations_per_date = mysqli_fetch_array(
               $all_dates,MYSQLI_ASSOC)):;
   ?>
       <option value="<?php echo $view_surgeries_per_date["date"];
           // The value we usually set is the primary key
       ?>">
           <?php echo $view_consultations_per_date["date"];
               // To show the employee name to the user
           ?>
       </option>
   <?php
       endwhile;
       // While loop must be terminated
   ?>
</select>
<br>
   <input type="submit" name="button" value="View Consultations On This Date">
   <br>
   <br>
</form>

<form action="view-consultations-by-physician.php" method="post">

<label>Select a Physician to View All Physicians</label>
<br>
<select name="view_consultations_per_physician">
   <?php
       // use a while loop to fetch data
       // from the $all_categories variable
       // and individually display as an option
       while ($view_consultations_by_physician = mysqli_fetch_array(
               $all_physicians,MYSQLI_ASSOC)):;
   ?>
       <option value="<?php echo $view_consultations_by_physician["surgeon_id"];
           // The value we usually set is the primary key
       ?>">
           <?php echo $view_consultations_by_physician["employee_name"] . " Physician ID: ".$view_consultations_by_physician["physician_id"];
               // To show the employee name to the user
           ?>
       </option>
   <?php
       endwhile;
       // While loop must be terminated
   ?>
</select>
<br>
   <input type="submit" name="button" value="View Consultations Schedule With This Physician">
   <br>
   <br>
</form>
        </center>
   </body>
</html>
