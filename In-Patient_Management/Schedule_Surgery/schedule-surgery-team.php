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


$sql = "SELECT * FROM patient_personal_data WHERE patient_id = '$patient'";
$result = mysqli_query($conn,$sql);
$user = mysqli_fetch_array($result,MYSQLI_ASSOC);

$sql_find_surgeons = "SELECT staff.employee_name, surgeons.surgeon_id, surgeons.specialty FROM staff, surgeons WHERE staff.employee_id = surgeons.employee_id";
$all_surgeons = mysqli_query($conn,$sql_find_surgeons);

$sql_find_all_nurses = "SELECT UNIQUE staff.employee_name, nurses.nurse_id
                        FROM staff
                        JOIN nurses
                        ON staff.employee_id = nurses.employee_id
                        JOIN nurse_skills
                        ON nurses.nurse_id = nurse_skills.fk_skills_nurse_id
                        JOIN surgery_requirements
                        ON nurse_skills.fk_nurse_skills_skill_id = surgery_requirements.fk_requirement_skill_id
                        JOIN surgery_skills
                        ON surgery_requirements.fk_requirement_skill_id = surgery_skills.skill_id
                        WHERE surgery_requirements.fk_requirement_surgery_code = $surgery_type";
$sql_all_nurses1 = mysqli_query($conn,$sql_find_all_nurses);
$sql_all_nurses2 = mysqli_query($conn,$sql_find_all_nurses);

$category_sql = "SELECT category FROM surgery_types WHERE surgery_code = '$surgery_type'";
$category_result = mysqli_query($conn,$category_sql);
$category = mysqli_fetch_array($category_result,MYSQLI_ASSOC);

$sql_find_beds = "SELECT bed_id, nursing_unit, wing, room_number, bed_number
                    FROM beds
                    WHERE bed_id
                    NOT IN (SELECT fk_inpatients_bed_id FROM inpatients)";
$all_beds = mysqli_query($conn,$sql_find_beds);

$sql_inpatient_check = "SELECT fk_inpatients_patient_id FROM inpatients
                        WHERE fk_inpatients_patient_id = '$patient'";
$sql_inpatient_check_result = mysqli_query($conn,$sql_inpatient_check);
$inpatient_rows = mysqli_num_rows($sql_inpatient_check_result);

echo "Inpatient Rows is $inpatient_rows";
echo "<br>";
echo "$sql_inpatient_chack";
echo "<br>";
echo "The category is" .$category['category'];

if ($inpatient_rows > 0) {
    unset($category);
    $categpry = "O";
    echo "the category is $category";
}


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
         <input type="hidden" id="category" name="category" value=<?php echo "$category"; ?>>
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
                    <br>
            <label>Select The First Nurse</label>
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
            <br>
            <label>Select The Second Nurse</label>
            <select name="nurse2">
                <?php
                    // use a while loop to fetch data
                    // from the $all_categories variable
                    // and individually display as an option
                    while ($nurses2 = mysqli_fetch_array(
                            $sql_all_nurses2,MYSQLI_ASSOC)):;
                ?>
                    <option value="<?php echo $nurses2["nurse_id"];
                        // The value we usually set is the primary key
                    ?>">
                        <?php echo $nurses2["employee_name"] . " Nurse ID: ".$nurses2["nurse_id"];
                            // To show the employee name to the user
                        ?>
                    </option>
                <?php
                    endwhile;
                    // While loop must be terminated
                ?>
            </select>
            <br>



<div data-show-if="category:H">
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
            </div>

        <br>

            <input type="submit" name="button" value="Book Surgery">
                </p>
         </form>
      </center>
   </body>
  <script>
   $( document ).ready(function() {
     $('#category').change(function() {
       $('.add_fields').hide()
         if($(this).val() == "H")
          $('#add_inpatient').show();
     });
   });
   </script>
</html>
