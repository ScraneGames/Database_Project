<?php
include "/var/www/html/functions.php";


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Pull patient ID
$original_patient_id = $_REQUEST['patient'];

// Gather Patient Medical Information
$sql = "SELECT * FROM patient_medical_data WHERE fk_medical_data_patient_id = '$original_patient_id'";
$result = mysqli_query($conn,$sql);
$user = mysqli_fetch_array($result,MYSQLI_ASSOC);


// Gather patient personal information
$sql_personal_info = "SELECT patient_name FROM patient_personal_data WHERE patient_id = '$original_patient_id'";
$personal_result = mysqli_query($conn,$sql_personal_info);
$personal_user = mysqli_fetch_array($personal_result,MYSQLI_ASSOC);


// Gather the most recent cholesterol information
$sql_cholesterol = "SELECT MAX(fk_cholesterol_consultation_number), HDL, LDL, triglycerides, blood_sugar FROM cholesterol WHERE fk_cholesterol_patient_id = '$original_patient_id'";
$cholesterol_result = mysqli_query($conn,$sql_cholesterol);
$cholesterol_user = mysqli_fetch_array($cholesterol_result,MYSQLI_ASSOC);


// Gather information on the consultations
$consultation_sql = "SELECT consultation_number, date, employee_name FROM consultations, physicians WHERE fk_consultation_patient_id = '$original_patient_id' AND consultations.fk_consultation_physician_id = physicians.physician_id";
$consultation_result = mysqli_query($conn,$consultation_sql);
// $consultation_user = mysqli_fetch_array($consultation_result,MYSQLI_ASSOC);

// Quick math on the cholesterol total
$current_cholesterol_total = ($cholesterol_user['HDL']+$cholesterol_user['LDL']+(0.2*$cholesterol_user['triglycerides']));
$current_cholesterol_risk = (round($current_cholesterol_total/$cholesterol_user['HDL'],2));

// Find all medications not prescribed to the patient
$medication_sql = "SELECT medication_code, name
                  FROM medications
                  WHERE medication_code NOT IN
                     (SELECT fk_patient_medication_code
                     FROM patient_medications
                     WHERE fk_medications_patient_id = '$original_patient_id')
                  AND quantity_on_hand > 0";
$medication_results = mysqli_query($conn,$medication_sql);


// Check Prescribed medications
$prescribed_medications = "SELECT medication_code, name, dosage, frequency
                           FROM medications
                           JOIN patient_medications
                           ON medications.medication_code = patient_medications.fk_patient_medication_code
                           WHERE fk_medications_patient_id = '$original_patient_id'";
$prescribed_results = mysqli_query($conn,$prescribed_medications);
$prescribed_remove_results = mysqli_query($conn,$prescribed_medications);
$prescribed_check_results = mysqli_query($conn,$prescribed_medications);

// Also find the medications prescribed to the patient
                           $medication_reactions = "SELECT medication_name, reacting_name, severity
                           FROM view_medication_reactions
                           JOIN patient_medications
                           ON view_medication_reactions.medication_id = patient_medications.fk_patient_medication_code
                           WHERE patient_medications.fk_medications_patient_id = '$original_patient_id'
                           ORDER BY medication_name";
$reactions_results = mysqli_query($conn,$medication_reactions);

// $all_consultations = mysqli_fetch_array($consultation_result,MYSQLI_ASSOC);

if ($user['high_risk'] > 0){
   $check = "checked";
} else {
   $check = " ";
}

$primary_id = $user['primary_physician_id'];


$primary_sql = "SELECT employee_name FROM physicians WHERE physician_id = '$primary_id'";
$primary_sql_result = mysqli_query($conn,$primary_sql);
$primary_user = mysqli_fetch_array($primary_sql_result,MYSQLI_ASSOC);

$primary = $primary_user['employee_name'];

$sql_find_phyisicans_less_7 = "SELECT physicians.employee_name, physicians.physician_id
                        FROM physicians
                        LEFT OUTER JOIN patient_medical_data
                        ON physicians.physician_id = patient_medical_data.primary_physician_id
                        WHERE physicians.position <> 'chief_of_staff'
                        GROUP BY physicians.physician_id
                        HAVING COUNT(patient_medical_data.primary_physician_id) < 7";

$sql_find_physicians_less_7_result = mysqli_query($conn,$sql_find_phyisicans_less_7);

$sql_find_phyisicans_less_20 = "SELECT physicians.employee_name, physicians.physician_id
                                 FROM physicians
                                 LEFT OUTER JOIN patient_medical_data
                                 ON physicians.physician_id = patient_medical_data.primary_physician_id
                                 WHERE physicians.position <> 'chief_of_staff'
                                 GROUP BY physicians.physician_id
                                 HAVING COUNT(patient_medical_data.primary_physician_id) < 20";

$sql_find_physicians_less_20_result = mysqli_query($conn,$sql_find_phyisicans_less_20);

?>


<!DOCTYPE html>
<html lang="en">
   <head>
      <title>Editing a Patient</title>
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
   </head>
   <body>
      <center>
         <h1>Editing Medical Data</h1>

         <form action="insert-medical-information.php" method="post">

<!-- Show/Edit Blood type if needed -->
<p>
               <label for="blood_type">Blood Type:</label>
               <select name="blood_type">
               <option <?php echo $user['blood_type'] == "O+" ? "selected": ""; ?>>O+</option>
               <option <?php echo $user['blood_type'] == "O-" ? "selected": ""; ?>>O-</option>
               <option <?php echo $user['blood_type'] == "A+" ? "selected": ""; ?>>A+</option>
               <option <?php echo $user['blood_type'] == "A-" ? "selected": ""; ?>>A-</option>
               <option <?php echo $user['blood_type'] == "B+" ? "selected": ""; ?>>B+</option>
               <option <?php echo $user['blood_type'] == "B-" ? "selected": ""; ?>>B-</option>
               <option <?php echo $user['blood_type'] == "AB" ? "selected": ""; ?>>AB</option>
               </select>
               </select>
</p>
<input type="hidden" id="patient" name="patient" value="<?php echo $original_patient_id; ?>">

<!-- Display/Enter blood sugar -->
<p>
               <label for="blood_sugar">Blood Sugar:</label>
               <input type="text" name="blood_sugar" value="<?php echo $cholesterol_user['blood_sugar']; ?>" id="blood_sugar">
            </p>
<!-- Display/enter HDL -->
<p>
               <label for="hdl">HDL:</label>
               <input type="number" name="hdl" value="<?php echo $cholesterol_user['HDL']; ?>" id="hdl">
            </p>

<!-- Display/enter LDL -->
<p>
               <label for="ldl">LDL:</label>
               <input type="number" name="ldl" value="<?php echo $cholesterol_user['LDL']; ?>" id="ldl">
            </p>
<!-- Display/enter Triglycerides -->
<p>
                <label for="triglycerides">Triglycerides:</label>
                <input type="text" name="triglycerides" value="<?php echo $cholesterol_user['triglycerides']; ?>" id="triglycerides">
            </p>
            <br>
<!-- Show the most recent cholesterol and ratio to help judge if someone wants to  select as high risk -->
               <?php
               echo  "The most recent total cholesterol of " . $personal_user['patient_name'] . " is $current_cholesterol_total and their cholesterol/hdl ratio is $current_cholesterol_risk";
               echo "<br>";
               ?>
<!-- Allow select high risk -->
<p>
               <label for="high_risk">High Risk?:</label>
               <input type="checkbox" <?php echo "$check"; ?> name="high_risk" value="1" id="high_risk">
               <br>
</p>
<p>

<!-- See patient primary info and change it -->
<?php
echo "The patient's current primary physician is $primary.";
?>
<br>
</p>
         <label for="primary_less_20">Primary Physician:</label>
                        <select name="primary_less_20">
                     <?php
                        // use a while loop to fetch data
                        // from the $all_categories variable
                        // and individually display as an option
                        while ($primary_less_20 = mysqli_fetch_array(
                           $sql_find_physicians_less_20_result,MYSQLI_ASSOC)):;
                     ?>
                        <option value="<?php echo $primary_less_20["physician_id"];
                           // The value we usually set is the primary key
                        ?>"
                           <?php if ($primary_less_20['physician_id'] == $primary_id) { echo " selected";} ?>>
                           <?php echo $primary_less_20["employee_name"] . " ".$primary_less_20["physician_id"];
                                 // To show the employee name to the user
                           ?>
                        </option>
                        <?php
                        endwhile;
                        // While loop must be terminated
                        ?>
      </select>
      <br>

<!-- Selection to prescribe medication -->
 <p>
                           <label for="want_prescribe">Prescribe Medication?:</label>
                           <select name="want_prescribe" id="want_prescribe">
                           <option value="">Select...</option>
                           <option value="yes">Yes</option>
                           <option value="no">No</option>
                           </select>
                           </p>

<br>
<!-- This should reveal if the above is set to yes -->
<div id="prescribe_medication" class="prescribe_fields" style="display: none">
   <p>
               <label>Medications to Prescribe:</label>
               <select name="prescribe">
            <?php
                // use a while loop to fetch data
                // from the $all_categories variable
                // and individually display as an option
                while ($all_medications = mysqli_fetch_array(
                  $medication_results,MYSQLI_ASSOC)):;
            ?>
                <option value="<?php echo $all_medications['medication_code'];
                    // The value we usually set is the primary key
                ?>">
                    <?php echo "Medication Code: " . $all_medications['medication_code'] . " Name: " .$all_medications['name'];
                        // To show the employee name to the user
                    ?>
                </option>
               <?php
               endwhile;
               // While loop must be terminated
         ?>
         </p>
      </select>
      <p>
               <label for="dosage">Dosage:</label>
               <input type="number" name="dosage" id="dosage">
            </p>

      <p>
         <label for="frequency">Frequency:</label>
         <input type="text" name="frequency" id="frequency">
            </p>

</div>
<p>
   <!-- Show this section if thre is a prescription for the patient -->
   <?php if (mysqli_num_rows($prescribed_check_results) > 0): ?>
      <?php

echo "Current Possible Medication Reactions";
echo "<br>";

echo "<table border='1'>
<tr>
<th>Medication Name</th>
<th>Reacting Medication Name</th>
<th>Severity</th>
</tr>";

while($reacting_row = mysqli_fetch_array($reactions_results)){
    echo "<tr>";
    echo "<td>" . $reacting_row['medication_name'] . "</td>";
    echo "<td>" . $reacting_row['reacting_name'] . "</td>";
    echo "<td>" . $reacting_row['severity'] . "</td>";
    echo "</tr>";
}
echo "</table>";

echo "<br>";


echo "<br>";
 echo "<p>";

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
<?php endif; ?>
            </p>
<!-- Selection to Remove Medications -->
<p>
                           <label for="want_remove">Un-Prescribe Medication?:</label>
                           <select name="want_remove" id="want_remove">
                           <option value="">Select...</option>
                           <option value="yes">Yes</option>
                           <option value="no">No</option>
                           </select>
                           </p>
<br>
<br>


<!-- This should show if the above is set to yes -->
<div id="remove_medication" class="remove_fields" style="display: none">
   <p>
               <label>Prescribed Medications to Remove:</label>
               <select name="remove_prescribe">
            <?php
                // use a while loop to fetch data
                // from the $all_categories variable
                // and individually display as an option
                while ($all_prescribed = mysqli_fetch_array(
                  $prescribed_remove_results,MYSQLI_ASSOC)):;
            ?>
                <option value="<?php echo $all_prescribed['medication_code'];
                    // The value we usually set is the primary key
                ?>">
                    <?php echo "Medication Code: " . $all_prescribed['medication_code'] . " Name: " .$all_prescribed['name'] . " Dosage: " . $all_prescribed['dosage'] . " Frequency: " .$all_prescribed['frequency'];
                        // To show the employee name to the user
                    ?>
                </option>
               <?php
               endwhile;
               // While loop must be terminated
         ?>
         </p>
      </select>
      </div>
<br>
<!-- Select the consultation to add the info to -->
<p>
               <label>Consultation This Data Is Coming From:</label>
               <select name="consultation">
            <?php
                // use a while loop to fetch data
                // from the $all_categories variable
                // and individually display as an option
                while ($all_consultations = mysqli_fetch_array(
                  $consultation_result,MYSQLI_ASSOC)):;
            ?>
                <option value="<?php echo $all_consultations['consultation_number'];
                    // The value we usually set is the primary key
                ?>">
                    <?php echo "Consultation ID: " . $all_consultations['consultation_number'] . " Date: " .$all_consultations['date'] . " Physician: ".$all_consultations['employee_name'];
                        // To show the employee name to the user
                    ?>
                </option>
               <?php
               endwhile;
               // While loop must be terminated
         ?>
         </p>
      </select>
      <br>
      <br>

            <input type="submit" value="Submit">
         </form>
      </center>
   </body>

   <script>
   $( document ).ready(function() {
     $('#want_prescribe').change(function() {
       $('.prescribe_fields').hide()
         if($(this).val() == "yes")
          $('#prescribe_medication').show();
     });
   });
   </script>

<script>
   $( document ).ready(function() {
     $('#want_remove').change(function() {
       $('.remove_fields').hide()
         if($(this).val() == "yes")
          $('#remove_medication').show();
     });
   });
   </script>

<?php   $conn->close(); ?>
</html>
