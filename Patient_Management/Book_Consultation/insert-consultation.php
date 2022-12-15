<!DOCTYPE html>
<html>

<head>
    <title> Insert A Consultation</title>
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
        $patient = $_REQUEST['patient'];
        $physician = $_REQUEST['physician'];
        $date = $_REQUEST['date'];
        $time = $_REQUEST['time'];
        echo "$patient";
        echo "<br>";
        echo "$physician";
        echo "<br>";




        // Performing insert query execution
        // here for our table name is patient_personal_data

        $sql = "INSERT INTO consultations (fk_consultation_physician_id, fk_consultation_patient_id, date, time)
          VALUES ('$physician', '$patient', '$date', '$time')";

if (mysqli_query($conn, $sql)) {
    echo "Reservation Successfully Booked";
    } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }

  $conn->close();
  ?>
    </center>
</body>

</html>
