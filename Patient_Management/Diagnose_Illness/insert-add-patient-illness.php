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
        $illness = $_REQUEST['illness'];





        // Performing insert query execution
        // here for our table name is patient_personal_data

        $sql = "INSERT INTO patient_illness (fk_illnesses_patient_id, fk_illnesses_illness_code)
                VALUES ('$patient', '$illness')";

if (mysqli_query($conn, $sql)) {
    echo "Patient Illness Assigned";
    } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }

  $conn->close();
  ?>
    </center>
</body>

</html>
