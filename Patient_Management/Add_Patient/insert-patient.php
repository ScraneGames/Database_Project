<!DOCTYPE html>
<html>

<head>
    <title> Insert Patient Page</title>
</head>


<body>
    <center>


        <?php
        // Connect to Database
include "/var/www/html/functions.php";
        // check Connection

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }


        // Taking all the values from the patient-administration.php
        $patient_name = $_REQUEST['patient_name'];
        $ssn = $_REQUEST['ssn'];
        $gender = $_REQUEST['gender'];
        $dob = $_REQUEST['dob'];
        $address = $_REQUEST['address'];
        $telephone_number = $_REQUEST['telephone_number'];
        $illness=$_REQUEST['illness'];
        $blood_type=$_REQUEST['blood_type'];

        if ($_REQUEST['primary_less_7']) {
            $primary = $_REQUEST['primary_less_7'];
        } else {
            $primary = $_REQUEST['primary_less_20'];
        }


        // Performing insert query execution
        // here for our table name is patient_personal_data

        $sql = "INSERT INTO patient_personal_data (patient_name, ssn, gender, dob, address, telephone_number)
            VALUES ('$patient_name', '$ssn', '$gender', '$dob', '$address', '$telephone_number'); ";
        $sql .= "INSERT INTO patient_medical_data (fk_medical_data_patient_id, blood_type, primary_physician_id)
                VALUES ((SELECT patient_id FROM patient_personal_data WHERE ssn = '$ssn'), '$blood_type', '$primary'); ";
        $sql .= "INSERT INTO patient_illness (fk_illnesses_patient_id, fk_illnesses_illness_code)
                VALUES ( (SELECT patient_id FROM patient_personal_data WHERE ssn = '$ssn'), '$illness'); ";


        if(mysqli_multi_query($conn, $sql)){
            echo "<h3>Information added successfully. </h3>";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;

        }

        // Close connection
    $conn->close();
            ?>
    </center>
</body>

</html>
