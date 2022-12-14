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
<th>Date of Birth/th>
<th>Address</th>
<th>Telephone Number</th>
</tr>";

while($row = mysqli_fetch_array($result)){
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

$staff_sql = "SELECT * FROM staff_as_patients WHERE patient_id = $view_patient";
$staff_result = mysqli_query($conn,$sql);

if (mysqli_num_rows($sql_find_nurses_less_5) > 0){
    echo "<br>";
    $staff = (mysqli_fetch_array($staff_result));
    echo $staff['patient_name'] . " is also a staff member who works as a " . $staff['position'] . " and has the employee ID of " . $staff['employee_id'] . ".";
}

echo "<br>";

?>

        </center>
    </body>
</html>
