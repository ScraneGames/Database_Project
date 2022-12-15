<?php
include "/var/www/html/functions.php";


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql_find_names = "SELECT UNIQUE patient_name, patient_id FROM view_surgeries";
$all_schedule_patients = mysqli_query($conn,$sql_find_names);

$sql_find_date = "SELECT UNIQUE date FROM view_surgeries";
$all_dates = mysqli_query($conn,$sql_find_date);

$sql_find_surgeons = "SELECT UNIQUE surgeon, surgeon_id FROM surgeries_by_surgeons";
$all_surgeons = mysqli_query($conn,$sql_find_surgeons);



// public mysqli::multi_query(string $sql): bool


?>




<!DOCTYPE html>
<html lang="en">
   <head>
      <title>Choose How You Would Like To View Surgeries</title>
   </head>
   <body>
      <center>
         <h1>Choose How You Would Like To View Surgeries</h1>

         <form action="view-recorded-surgeries.php" method="post">

         <label>View Recorded Surgeries</label>
        <br>
            <input type="submit" name="button" value="View Recorded Surgeries">
         </form>
         <br>

         <form action="view-scheduled-surgeries.php" method="post">

<label>View Scheduled Surgeries</label>
<br>
   <input type="submit" name="button" value="View Scheduled Surgeries">
   <br>
   <br>
</form>


   <form action="view-surgery-per-patient.php" method="post">

<label>Select a Patient to View All Surgeries</label>
<br>
<select name="view_surgeries_per_patient">
    <br>
   <?php
       // use a while loop to fetch data
       // from the $all_categories variable
       // and individually display as an option
       while ($view_surgeries_per_patient = mysqli_fetch_array(
               $all_schedule_patients,MYSQLI_ASSOC)):;
   ?>
       <option value="<?php echo $view_consultations["patient_id"];
           // The value we usually set is the primary key
       ?>">
           <?php echo $view_surgeries_per_patient["patient_name"] . " Patient ID: ".$view_surgeries_per_patient["patient_id"];
               // To show the employee name to the user
           ?>
       </option>
   <?php
       endwhile;
       // While loop must be terminated
   ?>
</select>
<br>
   <input type="submit" name="button" value="View Surgeries For This Patient">
   <br>
<br>
</form>

<form action="view-surgery-per-day.php" method="post">

<label>Select a Date to View All Surgeries On That Date</label>
<br>
<select name="view_surgeries_per_date">
   <?php
       // use a while loop to fetch data
       // from the $all_categories variable
       // and individually display as an option
       while ($view_surgeries_per_date = mysqli_fetch_array(
               $all_dates,MYSQLI_ASSOC)):;
   ?>
       <option value="<?php echo $view_surgeries_per_date["date"];
           // The value we usually set is the primary key
       ?>">
           <?php echo $view_surgeries_per_date["date"];
               // To show the employee name to the user
           ?>
       </option>
   <?php
       endwhile;
       // While loop must be terminated
   ?>
</select>
<br>
   <input type="submit" name="button" value="View Surgeries On This Date">
   <br>
   <br>
</form>

<form action="view-surgery-per-surgeon.php" method="post">

<label>Select a Surgeon to View All Surgeries</label>
<br>
<select name="view_surgeries_per_surgeon">
   <?php
       // use a while loop to fetch data
       // from the $all_categories variable
       // and individually display as an option
       while ($view_surgeries_per_patient = mysqli_fetch_array(
               $all_surgeons,MYSQLI_ASSOC)):;
   ?>
       <option value="<?php echo $view_surgeries_per_patient["surgeon_id"];
           // The value we usually set is the primary key
       ?>">
           <?php echo $view_surgeries_per_patient["surgeon"] . " Surgeon ID: ".$view_surgeries_per_patient["surgeon_id"];
               // To show the employee name to the user
           ?>
       </option>
   <?php
       endwhile;
       // While loop must be terminated
   ?>
</select>
<br>
   <input type="submit" name="button" value="View Surgeries Performed By This Surgeon">
   <br>
   <br>
</form>
        </center>
   </body>
</html>
