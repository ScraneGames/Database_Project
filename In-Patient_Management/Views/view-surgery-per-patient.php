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
$patient = $_REQUEST['view_surgeries_per_patient'];

        // Taking all the values from the patient-administration.php

        $sql = "SELECT * FROM view_surgeries
        WHERE patient_id = '$patient'
        ORDER BY surgery_id";
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

        </center>
    </body>

    <?php   $conn->close(); ?>
</html>
