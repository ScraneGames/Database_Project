<!DOCTYPE html>
<html>

<head>
    <title> View Medical Information</title>
</head>


<body>
    <center>

<h2>Patient Medical Data</h2>
        <?php



        // check Connection
include "/var/www/html/functions.php";


        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }


        // Taking all the values from the patient-administration.php
        $patient = $_REQUEST['view_medical'];

$sql = "SELECT * FROM patient_medical_data
        JOIN patient_personal_data
        ON patient_medical_data.fk_medical_data_patient_id = patient_personal_data.patient_id
        WHERE fk_medical_data_patient_id = '$patient'";

$result = mysqli_query($conn,$sql);
echo "Basic Patient Information";
echo "<br>";
echo "<table border='1'>
<tr>
<th>Name</th>
<th>Blood Type</th>
</tr>";

while($row = mysqli_fetch_array($result)){
    echo "<tr>";
    echo "<td>" . $row['patient_name'] . "</td>";
    echo "<td>" . $row['blood_type'] . "</td>";
    echo "</tr>";
}
echo "</table>";

echo "<br>";

?>
 <h2>Diagnosed Illnesses and Allergies</h2>
<?php

$illness_sql = "SELECT * FROM view_patient_allergies_and_illnesses
                WHERE patient_id = '$patient'";

$illness_result = mysqli_query($conn,$illness_sql);

echo "Diagnosed Illnesses And Allergies";
echo "<br>";

echo "<table border='1'>
<tr>
<th>Illness Name</th>
<th>Illness Description</th>
<th>Allergy Name</th>
<th>Allergy Description</th>
</tr>";

while($illness_row = mysqli_fetch_array($illness_result)){
    echo "<tr>";
    echo "<td>" . $illness_row['illness_name'] . "</td>";
    echo "<td>" . $illness_row['illness_desc'] . "</td>";
    echo "<td>" . $illness_row['allergy_name'] . "</td>";
    echo "<td>" . $illness_row['allergy_desc'] . "</td>";
    echo "</tr>";
}
echo "</table>";

echo "<br>";
?>

<h2> Prescribed Medications</h2>
<?php
$prescribed_medications = "SELECT medication_code, name, dosage, frequency
                            FROM medications
                            JOIN patient_medications
                            ON medications.medication_code = patient_medications.fk_patient_medication_code
                            WHERE fk_medications_patient_id = '$patient'";
$prescribed_results = mysqli_query($conn,$prescribed_medications);

echo "<br>";
echo "<br>";
echo "$prescribed_medications";
echo "<br>";
echo "<br>";
echo "Prescribed Medications";
echo "<br>";

echo "<table border='1'>
<tr>
<th>Medication Code</th>
<th>Medciation Name</th>
<th>Dosage</th>
<th>Frequency</th>
</tr>";

while($prescribed_row = mysqli_fetch_array($prescribed_results)){
    echo "<tr>";
    echo "<td>" . $prescribed_row['medication_code'] . "</td>";
    echo "<td>" . $prescribed_row['name'] . "</td>";
    echo "<td>" . $prescribed_row['dosage'] . "</td>";
    echo "<td>" . $prescribed_row['frequency'] . "</td>";
    echo "</tr>";
}
echo "</table>";

echo "<br>";


?>
<h2>Patient's Cholesterol and Heart Risk</h2>
<?php

$cholesterol_sql = "SELECT * FROM heart_risk_view
                    WHERE patient_id = '$patient'";
$cholesterol_result = mysqli_query($conn,$cholesterol_sql);


$sql_high_risk = "SELECT high_risk FROM patient_medical_data WHERE fk_medical_data_patient_id = '$patient'";
$high_risk_result =  mysqli_query($conn,$sql_high_risk);
if ($high_risk_result > 0){
    $high_risk = "at high risk.";
} else {
    $high_risk = "not at high risk.";
}


echo "Cholesterol and Heart Risk";
echo "While each appointment has an individual, calculated, heart risk ranging from none to moderate, a doctor may individually mark a patient as high risk.";
echo "<br>";
echo "As of the last consultation, the patient is $high_risk";
echo "<br>";

echo "<table border='1'>
<tr>
<th>Date of Consultation</th>
<th>Physician</th>
<th>Blood Sugar</th>
<th>HDL</th>
<th>LDL</th>
<th>Triglycerides</th>
<th>Total Cholesterol</th>
<th>Heart Risk</th>
</tr>";

while($cholesterol_row = mysqli_fetch_array($cholesterol_result)){
echo "<tr>";
echo "<td>" . $cholesterol_row['date'] . "</td>";
echo "<td>" . $cholesterol_row['employee_name'] . "</td>";
echo "<td>" . $cholesterol_row['blood_sugar'] . "</td>";
echo "<td>" . $cholesterol_row['hdl'] . "</td>";
echo "<td>" . $cholesterol_row['ldl'] . "</td>";
echo "<td>" . $cholesterol_row['triglycerides'] . "</td>";
echo "<td>" . $cholesterol_row['total_cholesterol'] . "</td>";
echo "<td>" . $cholesterol_row['heart_risk'] . "</td>";
echo "</tr>";
}
echo "</table>";

echo "<br>";

mysqli_close($conn);
?>
        </center>
    </body>
</html>
