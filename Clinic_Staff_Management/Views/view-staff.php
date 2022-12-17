<!DOCTYPE html>
<html>

<head>
    <title>View All Staff</title>
</head>


<body>
    <center>
        <?php



        // check Connection
include "/var/www/html/functions.php";


        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
// $patient = $_REQUEST['view_surgeries_per_patient'];

        // Taking all the values from the patient-administration.php

        $sql = "SELECT * FROM staff ORDER BY employee_id";
        $result = mysqli_query($conn,$sql);

$result = mysqli_query($conn,$sql);
echo "All Staff";
echo "<br>";
echo "<table border='1'>
<tr>
<th>Name</th>
<th>Employee Number</th>
<th>SSN</th>
<th>Gender</th>
<th>Address</th>
<th>Telephone Number</th>
<th>Position</th>
</tr>";

while($row = mysqli_fetch_array($result)){
    echo "<tr>";
    echo "<td>" . $row['employee_name'] . "</td>";
    echo "<td>" . $row['employee_id'] . "</td>";
    echo "<td>" . str_repeat('*', strlen($row['ssn']) -4) . substr($row['ssn'], -4) . "</td>";
    echo "<td>" . $row['gender'] . "</td>";
    echo "<td>" . $row['address'] . "</td>";
    echo "<td>" . $row['telephone_number'] . "</td>";
    echo "<td>" . $row['position'] . "</td>";
    echo "</tr>";
}
echo "</table>";

echo "<br>";

?>

        </center>
    </body>
    <?php   $conn->close(); ?>
</html>
