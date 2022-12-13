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

$current_cholesterol_total = ($cholesterol_user['hdl']+$cholesterol_user['ldl']+(0.2*$cholesterol_user['triglycerides']));
$current_cholesterol_risk = ($current_cholesterol_total/$cholesterol_user['hdl']);

// $all_consultations = mysqli_fetch_array($consultation_result,MYSQLI_ASSOC);

echo "$original_patient_id";

echo "<br>";
echo "$sql";
echo "<br>";
echo $user['blood_type'];
echo "<br>";
echo $user['high_risk'];
echo "<br>";
echo "$sql_cholesterol";
echo "<br>";
echo $cholesterol_user['HDL'];
// echo $consultation_user['date'];

if ($user['$high_risk'] == "1"){
   $check = "checked";
} else {
   $check = " ";
}

echo "$check";

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
<p>
               <label for="high_risk">High Risk?:</label>
               <input type="checkbox" <?php echo "$check"; ?> name="high_risk" value="1" id="high_risk">
               <br>
</p>
<br>
               <?php
//               echo  "The most recent total cholesterol of $personal_result is $current_cholesterol and their cholesterol/hdl ratio is $current_cholesterol_risk";
//               echo "<br>";
               ?>
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
</html>
