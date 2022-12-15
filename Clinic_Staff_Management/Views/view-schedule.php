<!DOCTYPE html>
<html>

<head>
    <title>View Everyone's Schedule</title>
</head>


<body>
    <center>
        <?php



        // check Connection
include "/var/www/html/functions.php";


        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
// $position = $_REQUEST['position'];

        // Taking all the values from the patient-administration.php

        $sql = "SELECT * FROM work_schedule JOIN staff on work_schedule.fk_work_schedule_employee_id = staff.employee_id";
        $result = mysqli_query($conn,$sql);

$result = mysqli_query($conn,$sql);
echo "The Full Work Schedule";
echo "<br>";
echo "<table border='1'>
<tr>
<th>Name</th>
<th>Employee Number</th>
<th>Position</th>
<th>Sunday</th>
<th>Monday</th>
<th>Tuesday</th>
<th>Wednesday</th>
<th>Thursday</th>
<th>Friday</th>
<th>Saturday</th>
<th>Start Time</th>
<th>End Time</th>
</tr>";

while($row = mysqli_fetch_array($result)){
    echo "<tr>";
    echo "<td>" . $row['employee_name'] . "</td>";
    echo "<td>" . $row['employee_id'] . "</td>";
    echo "<td>" . $row['position'] . "</td>";
    if ($row['sunday'] == 1){echo "<td>" . "Working" . "</td>";} else {echo "<td>" . "Off" . "</td>";}
    if ($row['monday'] == 1){echo "<td>" .  "Working" . "</td>";} else {echo "<td>" . "Off" . "</td>";}
    if ($row['tuesday'] == 1){echo "<td>" . "Working" . "</td>";} else {echo "<td>" . "Off" . "</td>";}
    if ($row['wednesday'] == 1){echo "<td>" .  "Working" . "</td>";} else {echo "<td>" . "Off" . "</td>";}
    if ($row['thursday'] == 1){echo "<td>" .  "Working" . "</td>";} else {echo "<td>" . "Off" . "</td>";}
    if ($row['friday'] == 1){echo "<td>" .  "Working" . "</td>";} else {echo "<td>" . "Off" . "</td>";}
    if ($row['saturday'] == 1){echo "<td>" .  "Working" . "</td>";} else {echo "<td>" . "Off" . "</td>";}
    echo "<td>" . $row['start_time'] . "</td>";
    echo "<td>" . $row['end_time'] . "</td>";
    echo "</tr>";
}
echo "</table>";

echo "<br>";

?>

        </center>
    </body>
</html>
