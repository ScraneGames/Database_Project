<!DOCTYPE html>
<html>

<head>
    <title>Recorded Surgeries</title>
</head>


<body>
    <center>
        <?php

$surgeon = $_REQUEST['surgeonn'];

        // check Connection
include "/var/www/html/functions.php";


        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $sql_find_surgeon = "SELECT * FROM view_surgeries WHERE surgeon_id = '$surgeon' ORDER BY date";
        $all_surgeries = mysqli_query($conn,$sql_find_surgeon);

        // Taking all the values from the patient-administration.php

        $sql = "SELECT * FROM view_surgeries
        WHERE surgeon_id = '$surgeon' ORDER BY surgery_id";
        $result = mysqli_query($conn,$sql);

$result = mysqli_query($conn,$sql);
echo "All Scheduled Surgeries";
echo "<br>";
echo "<table border='1'>
<tr>
<th>Surgery ID</th>
<th>Date</th>
<th>Time</th>
<th>Operating Theater</th>
<th>Surgery Type</th>
<th>Category</th>
<th>Surgeon Name</th>
<th>Nurse Name</th>
<th>Patient Name</th>
<th>Patient ID</th>
</tr>";

while($row = mysqli_fetch_array($result)){
    echo "<tr>";
    echo "<td>" . $row['surgery_id'] . "</td>";
    echo "<td>" . $row['date'] . "</td>";
    echo "<td>" . $row['time'] . "</td>";
    echo "<td>" . $row['operating_theater'] . "</td>";
    echo "<td>" . $row['surgery_type'] . "</td>";
    echo "<td>" . $row['category'] . "</td>";
    echo "<td>" . $row['surgeon'] . "</td>";
    echo "<td>" . $row['nurse'] . "</td>";
    echo "<td>" . $row['patient_name'] . "</td>";
    echo "<td>" . $row['patient_id'] . "</td>";
    echo "</tr>";
}
echo "</table>";

echo "<br>";

?>

<h3>Choose a Surgery From Above to Delete</h3>

<form action="delete-surgeries.php" method="post">

<input type="hidden" id="surgon" name="surgeon" value="<?php echo $surgeon; ?>">

<label>Choose a Surgery</label>
<br>
<select name="surgery">
   <?php
       // use a while loop to fetch data
       // from the $all_categories variable
       // and individually display as an option
       while ($all_surgeries = mysqli_fetch_array(
               $surgeries,MYSQLI_ASSOC)):;
   ?>
       <option value="<?php echo $all_surgeries["surgery_id"];
           // The value we usually set is the primary key
       ?>">
           <?php echo $all_surgeries["date"] . "Surgery ID: " . $all_surgeries["surgery_id"] . " Patient Name: " . $all_surgeries["patient_name"] . " Surgery Type: " . $all_surgeries["surgery_type"];
               // To show the employee name to the user
           ?>
       </option>
   <?php
       endwhile;
       // While loop must be terminated
   ?>
</select>
<br>
   <input type="submit" name="button" value="View Surgeries By This Surgeon On This Date">
   <br>
   <br>

        </center>
    </body>
    <?php   $conn->close(); ?>
</html>
