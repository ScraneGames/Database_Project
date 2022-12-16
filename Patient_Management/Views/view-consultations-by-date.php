<!DOCTYPE html>
<html>

<head>
    <title>Consultations On Selected Date</title>
</head>


<body>
    <center>
        <?php



        // check Connection
include "/var/www/html/functions.php";


        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
$date = $_REQUEST['view_consultations_per_date'];

        // Taking all the values from the patient-administration.php
echo $_REQUEST['view_consultations_per_date'];
        $sql = "SELECT * FROM view_consultations
                WHERE date = '$date'";
        $result = mysqli_query($conn,$sql);

        echo "$sql";
        echo "<br>";
        echo "<br>";

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
