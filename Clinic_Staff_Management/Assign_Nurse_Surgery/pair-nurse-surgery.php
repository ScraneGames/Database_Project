<?php
include "/var/www/html/functions.php";


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$nurse = $_REQUEST['nurse'];

$sql_find_nurse = "SELECT staff.employee_name, nurses.nurse_id FROM staff, nurses
                    WHERE staff.employee_id = nurses.employee_id AND nurses.nurse_id = '$nurse'";
$sql_find_nurse_result = mysqli_query($conn,$sql_find_nurse);

$nurse_array = mysqli_fetch_array($sql_find_nurse_result,MYSQLI_ASSOC);
$nurse_name = $nurse_array['employee_name'];

$sql_find_all_surgeries = "SELECT UNIQUE surgery_code, type_name FROM surgery_types JOIN surgery_requirements
                        ON surgery_types.surgery_code = surgery_requirements.fk_requirement_surgery_code
                        JOIN nurse_skills
                        ON surgery_requirements.fk_requirement_skill_id = nurse_skills.fk_nurse_skills_skill_id
                        WHERE nurse_skills.fk_skills_nurse_id = '$nurse'";
$sql_find_all_surgeries_result = mysqli_query($conn,$sql_find_all_surgeries)
// public mysqli::multi_query(string $sql): bool


?>




<!DOCTYPE html>
<html lang="en">
   <head>
      <title>Assign a Surgery to the Nurse</title>
   </head>
   <body>
      <center>
      <form action="insert-nurse-surgery.php" method="post">
<p>
 <?php
 echo "<h3>Choose a Surgery to assign to $nurse_name</h3";
 ?>
</p>
<p>
         <label for="all_nurse">Surgery:</label>
                        <select name="surgery">
                     <?php
                        // use a while loop to fetch data
                        // from the $all_categories variable
                        // and individually display as an option
                        while ($surgeries = mysqli_fetch_array(
                            $sql_find_all_surgeries_result,MYSQLI_ASSOC)):;
                     ?>
                        <option value="<?php echo $surgeries["surgery_code"];
                           // The value we usually set is the primary key
                        ?>">
                           <?php echo $surgeries["type_name"] . " Surgery Code: ".$surgeries["surgery_code"];
                                 // To show the employee name to the user
                           ?>
                        </option>
                        <?php
                        endwhile;
                        // While loop must be terminated
                        ?>
      </select>
      <input type="hidden" id="nurse" name="nurse" value="<?php echo $nurse; ?>">
      <br>
</p>
            <input type="submit" name="button" value="Assign">
         </form>
      </center>
   </body>
</html>
