<?php
include "/var/www/html/functions.php";


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql_find_all_nurses = "SELECT staff.employee_name, nurses.nurse_id FROM staff, nurses WHERE staff.employee_id = nurses.employee_id";
$sql_find_all_nurses_result = mysqli_query($conn,$sql_find_all_nurses);

$sql_find_all_skills = "SELECT * FROM surgery_skills";
$sql_find_all_skills_result = mysqli_query($conn,$sql_find_all_skills)

// public mysqli::multi_query(string $sql): bool


?>




<!DOCTYPE html>
<html lang="en">
   <head>
      <title>Assign a Skill To a Nurse</title>
   </head>
   <body>
      <center>
      <form action="insert-nurse-skills.php" method="post">
<p>
         <label for="all_nurse">Nurse:</label>
                        <select name="nurse">
                     <?php
                        // use a while loop to fetch data
                        // from the $all_categories variable
                        // and individually display as an option
                        while ($all_nurses = mysqli_fetch_array(
                            $sql_find_all_nurses_result,MYSQLI_ASSOC)):;
                     ?>
                        <option value="<?php echo $all_nurses["nurse_id"];
                           // The value we usually set is the primary key
                        ?>">
                           <?php echo $all_nurses["employee_name"] . " Nurse ID: " . $all_nurses["nurse_id"];
                                 // To show the employee name to the user
                           ?>
                        </option>
                        <?php
                        endwhile;
                        // While loop must be terminated
                        ?>
      </select>
      <br>
</p>
<p>
         <label for="all_nurse">Skill:</label>
                        <select name="skill">
                     <?php
                        // use a while loop to fetch data
                        // from the $all_categories variable
                        // and individually display as an option
                        while ($skills = mysqli_fetch_array(
                            $sql_find_all_skills_result,MYSQLI_ASSOC)):;
                     ?>
                        <option value="<?php echo $skills["skill_id"];
                           // The value we usually set is the primary key
                        ?>">
                           <?php echo $skills["skill_name"] . " Skill ID: ".$skills["skill_id"];
                                 // To show the employee name to the user
                           ?>
                        </option>
                        <?php
                        endwhile;
                        // While loop must be terminated
                        ?>
      </select>
      <br>
</p>
<p>
<br>
<?php

$nurse_skills_sql = "SELECT nurse_skills.fk_nurse_skills_skill_id, nurse_skills.fk_skills_nurse_id,
                    surgery_skills.skill_name, staff.employee_name
                    FROM nurse_skills
                    JOIN surgery_skills
                    ON nurse_skills.fk_nurse_skills_skill_id = surgery_skills.skill_id
                    JOIN nurses
                    ON nurse_skills.fk_skills_nurse_id = nurse_id
                    JOIN staff
                    ON nurses.employee_id = staff.employee_id
                    ORDER BY employee_name, skill_name";
$nurse_skills_results = mysqli_query($conn,$nurse_skills_sql)

echo "Already Assigned Skills";
echo "<br>";

echo "<table border='1'>
<tr>
<th>Nurse ID</th>
<th>Nurse Name</th>
<th>Skill Name</th>
</tr>";

while($skills_row = mysqli_fetch_array($nurse_skills_results)){
    echo "<tr>";
    echo "<td>" . $skills_row['fk_nurse_skills_skill_id'] . "</td>";
    echo "<td>" . $skills_row['employee_name'] . "</td>";
    echo "<td>" . $skills_row['skill_name'] . "</td>";
    echo "</tr>";
}
echo "</table>";

echo "<br>";

?>

                    </p>
            <input type="submit" name="button" value="Assign">
         </form>
      </center>
   </body>
   <?php   $conn->close(); ?>
</html>
