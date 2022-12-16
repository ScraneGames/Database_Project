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
        $remove_prescribe = $_REQUEST['remove_prescribe'];
        $prescribe_medication = $_REQUEST['prescribe'];
        $dosage = $_REQUEST['dosage'];
        $frequency = $_REQUEST['frequency'];
        $want_prescribe = $_REQUEST['want_prescribe'];
        $want_remove = $_REQUEST['want_remove'];


        if ($high_risk == FALSE){
            $high_risk = '0';
        }

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

        if ($_REQUEST['want_remove'] == "yes") {
            $remove_sql = "DELETE FROM patient_medications WHERE fk_patient_medication_code = '$remove_prescribe'
                            AND fk_medications_patient_id = '$patient'";
            if (mysqli_multi_query($conn, $remove_sql)) {
                echo "Medical Information Updated Successfully";
                } else {
                echo "Error: " . $remove_sql . "<br>" . $conn->error;


                              }
        }



        if ($_REQUEST['want_prescribe'] == "yes") {
            $prescribe_sql = "INSERT INTO patient_medications ( fk_medications_patient_id, fk_patient_medication_code, fk_medications_consultation_number, dosage, frequency)
                              VALUES ('$patient', '$prescribe_medication', '$consultation', '$dosage', '$frequency')";

                if (mysqli_multi_query($conn, $prescribe_sql)) {
                    echo "Medical Information Updated Successfully";
                    } else {
                    echo "Error: " . $prescribe_sql . "<br>" . $conn->error;
                }

        }

if (mysqli_multi_query($conn, $sql)) {
    echo "Medical Information Updated Successfully";
    } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }



  $conn->close();
  ?>
    </center>
</body>

</html>
