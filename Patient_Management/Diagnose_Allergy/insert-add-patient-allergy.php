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
        $allergy = $_REQUEST['allergy'];





        // Performing insert query execution
        // here for our table name is patient_personal_data

        $sql = "INSERT INTO patient_allergies (fk_allergy_patient_id, fk_allergies_allergy_code)
                VALUES ('$patient', '$allergy')";

if (mysqli_query($conn, $sql)) {
    echo "Patient Allergy Assigned Booked";
    } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }

  $conn->close();
  ?>
    </center>
</body>

</html>
