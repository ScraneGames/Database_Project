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
        $patient = $_REQUEST['view_consultations'];

$sql = "SELECT * FROM consultations
        JOIN patient_personal_data
        ON consultations.fk_consultation_patient_id = patient_personal_data.patient_id
        JOIN physicians
        ON consultations.fk_consultation_physician_id = physicians.physician_id
        WHERE consultations.fk_consultation_patient_id = '$patient'";

$result = mysqli_query($conn,$sql);
echo "All Patient Consultations";
echo "<br>";
echo "<table border='1'>
<tr>
<th>Physician Name</th>
<th>Date</th>
<th>Time</th>
</tr>";

while($row = mysqli_fetch_array($result)){
    echo "<tr>";
    echo "<td>" . $row['employee_name'] . "</td>";
    echo "<td>" . $row['date'] . "</td>";
    echo "<td>" . $row['time'] . "</td>";
    echo "</tr>";
}
echo "</table>";

echo "<br>";

?>

        </center>
    </body>
</html>
