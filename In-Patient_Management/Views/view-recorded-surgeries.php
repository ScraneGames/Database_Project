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


        // Taking all the values from the patient-administration.php

        $sql = "SELECT * FROM recorded_surgeries
        JOIN surgeons
        ON recorded_surgeries.fk_recorded_suregon_id = surgeons.surgeon_id
        JOIN staff
        ON surgeons.employee_id = staff.employee_id
        JOIN surgery_types
        ON recorded_surgeries.fk_recorded_surgery_code = surgery_types.surgery_code
        JOIN patient_personal_data
        ON  recorded_surgeries.fk_recorded_patient_id = patient_personal_data.patient_id
        JOIN surgery_schedule
        ON recorded_surgeries.surgery_id = surgery_schedule.surgery_ID
        AND recorded_surgeries.date = surgery_schedule.date
        WHERE recorded_surgeries.date <= CURDATE()";
        $result = mysqli_query($conn,$sql);

$result = mysqli_query($conn,$sql);
echo "All Recorded Surgeries";
echo "<br>";
echo "<table border='1'>
<tr>
<th>Surgery ID</th>
<th>Surgeon Name</th>
<th>Surgeon ID</th>
<th>Patient Name</th>
<th>Surgery Type/th>
<th>Surgery Description</th>
<th>Surgery Category</th>
<th>Date</th>
<th>Operating Theater</th>
</tr>";

while($row = mysqli_fetch_array($result)){
    echo "<tr>";
    echo "<td>" . $row['surgery_id'] . "</td>";
    echo "<td>" . $row['employee_name'] . "</td>";
    echo "<td>" . $row['surgeon_id'] . "</td>";
    echo "<td>" . $row['patient_name'] . "</td>";
    echo "<td>" . $row['type'] . "</td>";
    echo "<td>" . $row['type_desc'] . "</td>";
    echo "<td>" . $row['category'] . "</td>";
    echo "<td>" . $row['date'] . "</td>";
    echo "<td>" . $row['operating_theater'] . "</td>";
    echo "</tr>";
}
echo "</table>";

echo "<br>";

?>

        </center>
    </body>
</html>
