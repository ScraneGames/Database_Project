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


$sql = "SELECT * FROM patient_personal_data WHERE patient_id = '$patient'";
$result = mysqli_query($conn,$sql);
$user = mysqli_fetch_array($result,MYSQLI_ASSOC);

$sql_find_surgeons = "SELECT staff.employee_name, surgeons.surgeon_id FROM staff, surgeons WHERE staff.employee_id = surgeons.employee_id";
$all_surgeons = mysqli_query($conn,$sql_find_surgeons);

$sql_find_all_nurses = "SELECT staff.employee_name, nurses.nurse_id, surgery_skills.skill_name, surgery_skills.skill_id
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

echo "$sql";
echo "<br>";
echo "$sql_find_surgeons";
echo "<br>";
echo "$sql_find_all_nurses";
echo "<br>";
echo ""
?>

<!DOCTYPE html>
<html lang="en">
   <head>
      <title>Editing a Patient</title>
   </head>
   <body>
      <center>
         <h1>Editing a Patient</h1>
         <form action="insert-schedule-surgery.php" method="post">

         <input type="hidden" id="patient" name="patient" value="$patient">
         <input type="hidden" id="surgery_type" name="surgery_type" value="$surgery_type">
         <input type="hidden" id="operating_theater" name="operating_theater" value="$operating_theater">
         <input type="hidden" id="date" name="date" value="$date">
         <input type="hidden" id="time" name="time" value="$time">
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
                            <option value="<?php echo $surgeons["surgeons.surgeon_id"];
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
                            $all_nurses1,MYSQLI_ASSOC)):;
                ?>
                    <option value="<?php echo $nurses1["nurses.nurse_id"];
                        // The value we usually set is the primary key
                    ?>">
                        <?php echo $nurses1["employee_name"] . " Specialty: ".$nurses1["skill_name"] . " Nurse ID: ".$nurses1["nurse_id"];
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
                    while ($nurses1 = mysqli_fetch_array(
                            $all_nurses2,MYSQLI_ASSOC)):;
                ?>
                    <option value="<?php echo $nurses2["nurses.nurse_id"];
                        // The value we usually set is the primary key
                    ?>">
                        <?php echo $nurses2["employee_name"] . " Specialty: ".$nurses2["skill_name"] . " Nurse ID: ".$nurses1["nurse_id"];
                            // To show the employee name to the user
                        ?>
                    </option>
                <?php
                    endwhile;
                    // While loop must be terminated
                ?>
            </select>
            <br>
</p?
         </form>
      </center>
   </body>
</html>
