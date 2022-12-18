<?php
include "/var/www/html/functions.php";


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}



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


         <form action="select-surgery.php" method="post">
<label>Find a Surgery to Delete</label>


<label>Select a Surgeon to View Their Surgeries To Delete</label>
<br>
<select name="surgeon">
   <?php
       // use a while loop to fetch data
       // from the $all_categories variable
       // and individually display as an option
       while ($view_surgeries_per_surgeon = mysqli_fetch_array(
               $all_surgeons,MYSQLI_ASSOC)):;
   ?>
       <option value="<?php echo $view_surgeries_per_surgeon["surgeon_id"];
           // The value we usually set is the primary key
       ?>">
           <?php echo $view_surgeries_per_surgeon["surgeon"] . " Surgeon ID: ".$view_surgeries_per_surgeon["surgeon_id"];
               // To show the employee name to the user
           ?>
       </option>
   <?php
       endwhile;
       // While loop must be terminated
   ?>
</select>
<br>
   <input type="submit" name="button" value="Select This Surgeon">
   <br>
   <br>
</form>

        </center>
   </body>

   <?php   $conn->close(); ?>
</html>
