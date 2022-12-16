<!DOCTYPE html>
<html>

<head>
    <title>Recorded Surgeries</title>
</head>


<body>
    <center>
        <?php



        // check Connection
include "/var/www/html/functions.php";


        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
$room = $_REQUEST['room'];


$sql_find_date = "SELECT UNIQUE date FROM view_surgeries WHERE operating_theater = '$room'";
$all_dates = mysqli_query($conn,$sql_find_date);

        // Taking all the values from the patient-administration.php

        $sql = "SELECT * FROM view_surgeries
        WHERE operating_theater = '$room'";
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
<th>First Nurse</th>
<th>Second Nurse</th>
<th>Patient Name</th>
<th>Patient ID</th>
</tr>";

while($row = mysqli_fetch_array($result)){
    echo "<tr>";
    echo "<td>" . $row['surgery_id'] . "</td>";
    echo "<td>" . $row['operating_theater'] . "</td>";
    echo "<td>" . $row['date'] . "</td>";
    echo "<td>" . $row['time'] . "</td>";
    echo "<td>" . $row['surgery_type'] . "</td>";
    echo "<td>" . $row['category'] . "</td>";
    echo "<td>" . $row['surgeon'] . "</td>";
    echo "<td>" . $row['first_nurse'] . "</td>";
    echo "<td>" . $row['second_nurse'] . "</td>";
    echo "<td>" . $row['patient_name'] . "</td>";
    echo "<td>" . $row['patient_id'] . "</td>";
    echo "</tr>";
}
echo "</table>";

echo "<br>";

?>
<br>
<br>
<h3> Narrow it down even further by selecting a date</h3>

<form action="view-surgeries-per-room-per-day.php" method="post">
<input type="hidden" id="room" name="room" value="<?php echo $room; ?>">

<label>Select a Room and a Date to View All Surgeries On That Date</label>
<br>
<select name="date">
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
   <input type="submit" name="button" value="View Surgeries In This Room On This Date">
   <br>
   <br>

</form>

        </center>
    </body>
</html>
