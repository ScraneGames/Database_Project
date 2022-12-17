<!DOCTYPE html>
<html>

<head>
    <title>Available Beds</title>
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

        $sql_find_beds = "SELECT bed_id, nursing_unit, wing, room_number, bed_number
                        FROM beds
                        WHERE bed_id
                        NOT IN (SELECT fk_inpatients_bed_id FROM inpatients)
                        ORDER BY bed_id";
        $result = mysqli_query($conn,$sql_find_beds);

echo "All Beds Without Assigned Patients";
echo "<br>";
echo "<table border='1'>
<tr>
<th>Bed ID</th>
<th>Nursing Unit</th>
<th>Wing</th>
<th>Room Number</th>
<th>Bed Letter</th>
</tr>";

while($row = mysqli_fetch_array($result)){
    echo "<tr>";
    echo "<td>" . $row['bed_id'] . "</td>";
    echo "<td>" . $row['nursing_unit'] . "</td>";
    echo "<td>" . $row['wing'] . "</td>";
    echo "<td>" . $row['room_number'] . "</td>";
    echo "<td>" . $row['bed_number'] . "</td>";
    echo "</tr>";
}
echo "</table>";

echo "<br>";

?>

        </center>
    </body>

    <?php   $conn->close(); ?>
</html>
