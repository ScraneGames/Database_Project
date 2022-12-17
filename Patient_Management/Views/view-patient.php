<!DOCTYPE html>
<html>

<head>
    <title> View Medical Information</title>
</head>


<body>
    <center>

<h2>Patient Personal Data</h2>
        <?php



        // check Connection
include "/var/www/html/functions.php";


        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }


        // Taking all the values from the patient-administration.php
        $patient = $_REQUEST['view_patient'];

$sql = "SELECT * FROM patient_personal_data
        WHERE patient_id = '$patient'";

$result = mysqli_query($conn,$sql);
echo "Basic Patient Information";
echo "<br>";
echo "<table border='1'>
<tr>
<th>Patient ID</th>
<th>Patient Name</th>
<th>Gender</th>
<th>Date of Birth</th>
<th>Address</th>
<th>Telephone Number</th>
</tr>";

while($row = mysqli_fetch_array($result,MYSQLI_ASSOC)){
    echo "<tr>";
    echo "<td>" . $row['patient_id'] . "</td>";
    echo "<td>" . $row['patient_name'] . "</td>";
    echo "<td>" . $row['gender'] . "</td>";
    echo "<td>" . $row['dob'] . "</td>";
    echo "<td>" . $row['address'] . "</td>";
    echo "<td>" . $row['telephone_number'] . "</td>";
    echo "</tr>";
}
echo "</table>";

$staff_sql = "SELECT * FROM staff_as_patients WHERE patient_id = '$patient'";
$staff_result = mysqli_query($conn,$staff_sql);
$staff_results = mysqli_query($conn,$staff_sql);

if (mysqli_num_rows($staff_result) > 0){
    echo "<br>";
    $staff_emp = (mysqli_fetch_array($staff_results,MYSQLI_ASSOC));
    echo $staff_emp['name'] . " is also a staff member who works as a " . $staff_emp['position'] . " and has the employee ID of " . $staff_emp['employee_id'] . ".";
}

echo "<br>";
$conn->close();
?>

        </center>
    </body>
</html>
