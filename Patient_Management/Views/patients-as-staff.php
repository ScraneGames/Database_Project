<!DOCTYPE html>
<html>

<head>
    <title> View Patients Who Are Staff</title>
</head>


<body>
    <center>

<h2>Patients Who Are Staff</h2>
        <?php



        // check Connection
include "/var/www/html/functions.php";


        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }


        // Taking all the values from the patient-administration.php
        $patient = $_REQUEST['view_consultations'];

$sql = "SELECT name, position, employee_id, patient_id FROM staff_as_patients";

$result = mysqli_query($conn,$sql);
echo "All Staff Members Who Are Patients";
echo "<br>";
echo "<table border='1'>
<tr>
<th>Employee Name</th>
<th>Position</th>
<th>Employee ID</th>
<th>Patient ID</th>
</tr>";

while($row = mysqli_fetch_array($result)){
    echo "<tr>";
    echo "<td>" . $row['name'] . "</td>";
    echo "<td>" . $row['position'] . "</td>";
    echo "<td>" . $row['employee_id'] . "</td>";
    echo "<td>" . $row['patient_id'] . "</td>";
    echo "</tr>";
}
echo "</table>";

echo "<br>";
$conn->close();
?>

        </center>
    </body>


</html>
