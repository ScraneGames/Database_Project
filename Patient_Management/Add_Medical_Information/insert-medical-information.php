<!DOCTYPE html>
<html>

<head>
    <title> Update Medical Information</title>
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
        $blood_type = $_REQUEST['blood_type'];
        $blood_sugar = $_REQUEST['blood_sugar'];
        $hdl = $_REQUEST['hdl'];
        $ldl = $_REQUEST['ldl'];
        $triglycerides = $_REQUEST['triglycerides'];
        $high_risk = $_REQUEST['high_risk'];
        $consultation = $_REQUEST['consultation'];

        if ($high_risk)
        echo "$patient";
        echo "<br>";
        echo "$blood_type";
        echo "<br>";
        echo "$blood_sugar";
        echo "<br>";
        echo "$hdl";
        echo "<br>";
        echo "$ldl";
        echo "<br>";
        echo "$consultation";
        echo "<br>";
        echo "$high_risk";

        $medical_sql = "SELECT fk_medical_data_patient_id FROM patient_medical_data WHERE fk_medical_data_patient_id = '$patient'";
        $medical_result = mysqli_query($conn,$medical_sql);



        // Performing insert query execution
        // here for our table name is patient_personal_data
        if (mysqli_num_rows($medical_result) < 1){
            $sql = "INSERT INTO patient_medical_data (fk_medical_data_patient_id, blood_type, high_risk)
                    VALUES ('$patient', '$blood_type', '$high_risk'); ";
            $sql .= "INSERT INTO cholesterol (fk_cholesterol_patient_id, fk_cholesterol_consultation_number, blood_sugar, hdl, ldl, triglycerides)
                    VALUES ('$patient', '$consultation', '$blood_sugar', '$hdl', '$ldl', '$triglycerides')";
        } else {
            $sql = "UPDATE patient_medical_data
                    SET blood_type = '$blood_type', high_risk = '$high_risk'
                    WHERE fk_medical_data_patient_id = '$patient'; ";
            $sql .= "INSERT INTO cholesterol (fk_cholesterol_patient_id, fk_cholesterol_consultation_number, blood_sugar, hdl, ldl, triglycerides)
                    VALUES ('$patient', '$consultation', '$blood_sugar', '$hdl', '$ldl', '$triglycerides')";
        }

if (mysqli_multi_query($conn, $sql)) {
    echo "Medical Information Updated Successfully";
    } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }
  echo "<br>";
  echo "$sql";
  echo "<br>";

  $conn->close();
  ?>
    </center>
</body>

</html>
