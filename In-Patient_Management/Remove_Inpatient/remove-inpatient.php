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





        // Performing insert query execution
        // here for our table name is patient_personal_data

        $sql = "DELETE FROM inpatients WHERE fk_inpatients_patient_id = '$patient';";

if (mysqli_query($conn, $sql)) {
    echo "Patient Removed From Inpatients";
    } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }

  $conn->close();
  ?>
    </center>
</body>

</html>
