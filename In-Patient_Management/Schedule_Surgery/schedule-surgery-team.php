<?php
include "/var/www/html/functions.php";


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$patient = $_REQUEST['patient'];
$surgery_type = $_REQUEST['surgery'];
$operating_theater = $_REQUEST['operating_theater'];
$date = $_REQUEST['date'];
$time = $_REQUEST['time'];

// surgery_skills.skill_name, surgery_skills.skill_id


$sql = "SELECT patient_id, patient_name, primary_physician_id, employee_name FROM patient_personal_data JOIN patient_medical_data
                ON patient_personal_data.patient_id = patient_medical_data.fk_medical_data_patient_id
                JOIN physicians
                ON  patient_medical_data.primary_physician_id = physicians.physician_id
                WHERE patient_id = '$patient'";
$result = mysqli_query($conn,$sql);
$user = mysqli_fetch_array($result,MYSQLI_ASSOC);

$sql_find_surgeons = "SELECT staff.employee_name, surgeons.surgeon_id, surgeons.specialty FROM staff, surgeons WHERE staff.employee_id = surgeons.employee_id";
$all_surgeons = mysqli_query($conn,$sql_find_surgeons);

$sql_find_all_nurses = "SELECT UNIQUE staff.employee_name, nurses.nurse_id
                        FROM staff
                        JOIN nurses
                        ON staff.employee_id = nurses.employee_id
                        JOIN nurse_surgery_assignments
                        ON nurse_surgery_assignments.nurse_id = nurses.nurse_id
                        WHERE nurse_surgery_assignments.surgery_code = $surgery_type";
$sql_all_nurses1 = mysqli_query($conn,$sql_find_all_nurses);

$category_sql = "SELECT category FROM surgery_types WHERE surgery_code = '$surgery_type'";
$category_result = mysqli_query($conn,$category_sql);
$surg_category = mysqli_fetch_array($category_result,MYSQLI_ASSOC);

$sql_find_beds = "SELECT bed_id, nursing_unit, wing, room_number, bed_number
                    FROM beds
                    WHERE bed_id
                    NOT IN (SELECT fk_inpatients_bed_id FROM inpatients)";
$all_beds = mysqli_query($conn,$sql_find_beds);

$sql_inpatient_check = "SELECT fk_inpatients_patient_id FROM inpatients
                        WHERE fk_inpatients_patient_id = '$patient'";
$sql_inpatient_check_result = mysqli_query($conn,$sql_inpatient_check);
$inpatient_rows = mysqli_num_rows($sql_inpatient_check_result);


$sql_find_phyisicans_less_7 = "SELECT physicians.employee_name, physicians.physician_id
                        FROM physicians
                        LEFT OUTER JOIN inpatients
                        ON physicians.physician_id = inpatients.attending_physician_id
                        WHERE physicians.position <> 'chief_of_staff'
                        GROUP BY physicians.physician_id
                        HAVING COUNT(inpatients.attending_physician_id) < 7";

$sql_find_physicians_less_7_result = mysqli_query($conn,$sql_find_phyisicans_less_7);

$sql_find_phyisicans_less_20 = "SELECT physicians.employee_name, physicians.physician_id
                        FROM physicians
                        LEFT OUTER JOIN inpatients
                        ON physicians.physician_id = inpatients.attending_physician_id
                        WHERE physicians.position <> 'chief_of_staff'
                        GROUP BY physicians.physician_id
                        HAVING COUNT(inpatients.attending_physician_id) < 20";

$sql_find_physicians_less_20_result = mysqli_query($conn,$sql_find_phyisicans_less_20);

echo "<br>";
if ($inpatient_rows > 0 && $surg_category['category'] == "H"){
    $input_category = "O";
    echo "The input category is $input_category";
} else {
    $input_category = $surg_category['category'];
    echo "The input Category is $input_category";
}

// if ($inpatient_rows > 0) {
//    unset($category);
//    $categpry = "O";
//    echo "the category is $category";
// }


?>

<!DOCTYPE html>
<html lang="en">
   <head>
      <title>Editing a Patient</title>
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
   </head>
   <body>
      <center>
         <h1>Editing a Patient</h1>
         <form action="insert-schedule-surgery.php" method="post">

         <input type="hidden" id="patient" name="patient" value=<?php echo "$patient"; ?>>
         <input type="hidden" id="surgery_type" name="surgery_type" value=<?php echo"$surgery_type"; ?>>
         <input type="hidden" id="operating_theater" name="operating_theater" value= <?php echo "$operating_theater"; ?>>
         <input type="hidden" id="date" name="date" value=<?php echo "$date"; ?>>
         <input type="hidden" id="time" name="time" value=<?php echo "$time"; ?>>
         <input type="hidden" id="category" name="category" value="<?php echo "$input_category";?>">


         <p>
            <label>Select a Surgeon</label>
                    <select name="surgeon">
                        <?php
                            // use a while loop to fetch data
                            // from the $all_categories variable
                            // and individually display as an option
                            while ($surgeons = mysqli_fetch_array(
                                    $all_surgeons,MYSQLI_ASSOC)):;
                        ?>
                            <option value="<?php echo $surgeons["surgeon_id"];
                                // The value we usually set is the primary key
                            ?>">
                                <?php echo $surgeons["employee_name"] . " Specialty: ".$surgeons["specialty"] . " Surgeon ID: ".$surgeons["surgeon_id"];
                                    // To show the employee name to the user
                                ?>
                            </option>
                        <?php
                            endwhile;
                            // While loop must be terminated
                        ?>
                    </select>
                        </p>
                        <p>
                    <br>
            <label>Select The Assiting Nurse</label>
            <select name="nurse1">
                <?php
                    // use a while loop to fetch data
                    // from the $all_categories variable
                    // and individually display as an option
                    while ($nurses1 = mysqli_fetch_array(
                            $sql_all_nurses1,MYSQLI_ASSOC)):;
                ?>
                    <option value="<?php echo $nurses1["nurse_id"];
                        // The value we usually set is the primary key
                    ?>">
                        <?php echo $nurses1["employee_name"] . " Nurse ID: ".$nurses1["nurse_id"];
                            // To show the employee name to the user
                        ?>
                    </option>
                <?php
                    endwhile;
                    // While loop must be terminated
                ?>
            </select>
                </p>
                <br>




            <?php if ($input_category == "H"): ?>

                <label>Select a Bed For the Patient After the Surgery</label>
        <select name="bed">
            <?php
                // use a while loop to fetch data
                // from the $all_categories variable
                // and individually display as an option
                while ($beds = mysqli_fetch_array(
                        $all_beds,MYSQLI_ASSOC)):;
            ?>
                <option value="<?php echo $beds["bed_id"];
                    // The value we usually set is the primary key
                ?>">
                    <?php echo $beds["bed_id"] . " Nursing Unit ".$beds["nursing_unit"] . " Wing ".$beds["wing"] . " Bed Label ".$beds["bed_number"];
                        // To show the employee name to the user
                    ?>
                </option>
            <?php
                endwhile;
                // While loop must be terminated
            ?>
        </select>

        <?php echo "The primary physician for " . $user['patient_name'] ." is " .$user['employee_name'] . " With Physician ID " . $user ['primary_physician_id']; ?>

        <?php if (mysqli_num_rows($sql_find_physicians_less_7_result) > 0): ?>
<p>
               <label for="primary_less_7">Assign A Physician:</label>
               <select name="primary_less_7">
            <?php
                // use a while loop to fetch data
                // from the $all_categories variable
                // and individually display as an option
                while ($primary_less_7 = mysqli_fetch_array(
                  $sql_find_physicians_less_7_result,MYSQLI_ASSOC)):;
            ?>
                <option value="<?php echo $primary_less_7["physician_id"];
                    // The value we usually set is the primary key
                ?>">
                    <?php echo $primary_less_7["employee_name"] . " ".$primary_less_7["physician_id"];
                        // To show the employee name to the user
                    ?>
                </option>
               <?php
               endwhile;
               // While loop must be terminated
         ?>
      </select>
</p>
      <?php elseif (mysqli_num_rows($sql_find_physicians_less_20_result) > 0): ?>
<p>
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
                        ?>">
                           <?php echo $primary_less_20["employee_name"] . " ".$primary_less_20["physician_id"];
                                 // To show the employee name to the user
                           ?>
                        </option>
                        <?php
                        endwhile;
                        // While loop must be terminated
                        ?>
      </select>
      <?php endif; ?>
      <br>
<?php endif; ?>
        <br>

            <input type="submit" name="button" value="Book Surgery">
                </p>
         </form>
      </center>
   </body>
  <script>
   $( document ).ready(function() {
       $('.add_fields').hide()
         if($(#category).val() == "H")
          $('#add_inpatient').show();
   });
   </script>
</html>
