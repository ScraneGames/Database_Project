<!DOCTYPE html>
<html>

<head>
    <title>Consultations With Selected Physician</title>
</head>


<body>
    <center>
        <?php

$physician = $_REQUEST['view_consultations_per_physician'];

        // check Connection
include "/var/www/html/functions.php";


        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }


        // Taking all the values from the patient-administration.php

        $sql = "SELECT * FROM view_consultations
        WHERE physician_id = '$physician'";
        $result = mysqli_query($conn,$sql);

        $result = mysqli_query($conn,$sql);
        echo "All Scheduled Surgeries";
        echo "<br>";
        echo "<table border='1'>
        <tr>
        <th>Consultation ID</th>
        <th>Date</th>
        <th>Time</th>
        <th>Physician Name</th>
        <th>Physician ID</th>
        <th>Patient Name</th>
        <th>Patient ID</th>
        </tr>";

        while($row = mysqli_fetch_array($result)){
            echo "<tr>";
            echo "<td>" . $row['consultation_number'] . "</td>";
            echo "<td>" . $row['date'] . "</td>";
            echo "<td>" . $row['time'] . "</td>";
            echo "<td>" . $row['physician'] . "</td>";
            echo "<td>" . $row['physician_id'] . "</td>";
            echo "<td>" . $row['patient'] . "</td>";
            echo "<td>" . $row['patient_id'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";

        echo "<br>";

?>

        </center>
    </body>
</html>
