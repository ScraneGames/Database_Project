<?php
include "/var/www/html/functions.php";


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$original_patient_id = $_REQUEST['patient'];
$sql = "SELECT * FROM patient_medical_data WHERE fk_medical_data_patient_id = '$original_patient_id'";
$result = mysqli_query($conn,$sql);
$user = mysqli_fetch_array($result,MYSQLI_ASSOC);

$sql_personal_info = "SELECT patient_name FROM patient_personal_data WHERE patient_id = '$original_patient_id'";
$personal_result = mysqli_query($conn,$sql_personal_info);
$personal_user = mysqli_fetch_array($personal_result,MYSQLI_ASSOC);

$sql_cholesterol = "SELECT MAX(fk_cholesterol_consultation_number), HDL, LDL, triglycerides, blood_sugar FROM cholesterol WHERE fk_cholesterol_patient_id = '$original_patient_id'";
$cholesterol_result = mysqli_query($conn,$sql_cholesterol);
$cholesterol_user = mysqli_fetch_array($cholesterol_result,MYSQLI_ASSOC);

$consultation_sql = "SELECT consultation_number, date, employee_name FROM consultations, physicians WHERE fk_consultation_patient_id = '$original_patient_id' AND consultations.fk_consultation_physician_id = physicians.physician_id";
$consultation_result = mysqli_query($conn,$consultation_sql);
// $consultation_user = mysqli_fetch_array($consultation_result,MYSQLI_ASSOC);

$current_cholesterol_total = ($cholesterol_user['HDL']+$cholesterol_user['LDL']+(0.2*$cholesterol_user['triglycerides']));
$current_cholesterol_risk = (round($current_cholesterol_total/$cholesterol_user['HDL'],2));

$medication_sql = "SELECT medication_code, name
                  FROM medications
                  WHERE medication_code NOT IN
                     (SELECT fk_patient_medication_code
                     FROM patient_medications
                     WHERE fk_medications_patient_id = '$original_patient_id')
                  AND quantity_on_hand > 0";
$medication_results = mysqli_query($conn,$medication_sql);

$prescribed_medications = "SELECT medication_code, name, dosage, frequency
                           FROM medications
                           JOIN patient_medications
                           ON medications.medication_code = patient_medications.fk_patient_medication_code
                           WHERE fk_medications_patient_id = '$original_patient_id'";
$prescribed_results = mysqli_query($conn,$prescribed_medications);

// $all_consultations = mysqli_fetch_array($consultation_result,MYSQLI_ASSOC);

if ($user['high_risk'] > 0){
   $check = "checked";
} else {
   $check = " ";
}

?>


<!DOCTYPE html>
<html lang="en">
   <head>
      <title>Editing a Patient</title>
   </head>
   <body>
      <center>
         <h1>Editing Medical Data</h1>

         <form action="insert-medical-information.php" method="post">


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
<p>
               <label for="blood_sugar">Blood Sugar:</label>
               <input type="text" name="blood_sugar" value="<?php echo $cholesterol_user['blood_sugar']; ?>" id="blood_sugar">
            </p>

<p>
               <label for="hdl">HDL:</label>
               <input type="number" name="hdl" value="<?php echo $cholesterol_user['HDL']; ?>" id="hdl">
            </p>


<p>
               <label for="ldl">LDL:</label>
               <input type="number" name="ldl" value="<?php echo $cholesterol_user['LDL']; ?>" id="ldl">
            </p>

<p>
                <label for="triglycerides">Triglycerides:</label>
                <input type="text" name="triglycerides" value="<?php echo $cholesterol_user['triglycerides']; ?>" id="triglycerides">
            </p>
            <br>
               <?php
               echo  "The most recent total cholesterol of " . $personal_user['patient_name'] . " is $current_cholesterol and their cholesterol/hdl ratio is $current_cholesterol_risk";
               echo "<br>";
               ?>
<p>
               <label for="high_risk">High Risk?:</label>
               <input type="checkbox" <?php echo "$check"; ?> name="high_risk" value="1" id="high_risk">
               <br>
</p>

 <p>
                           <label for="want_prescribe">Prescribe Medication?:</label>
                           <select name="want_prescribe" id="want_prescribe">
                           <option value="">Select...</option>
                           <option value="yes">Yes</option>
                           <option value="no">No</option>
                           </select>
                           </p>
<p>

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
                <option value="<?php echo $all_consultations['medication_code'];
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

<?php

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
            </p>

<p>
                           <label for="want_remove">Un-Prescribe Medication?:</label>
                           <select name="want_remove" id="want_remove">
                           <option value="">Select...</option>
                           <option value="yes">Yes</option>
                           <option value="no">No</option>
                           </select>
                           </p>
<p>



<div id="remove_medication" class="remove_fields" style="display: none">
   <p>
               <label>Prescribed Medications to Remove:</label>
               <select name="remove_prescribe">
            <?php
                // use a while loop to fetch data
                // from the $all_categories variable
                // and individually display as an option
                while ($all_prescribed = mysqli_fetch_array(
                  $prescribed_results,MYSQLI_ASSOC)):;
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


</html>
