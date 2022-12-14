<?php
include "/var/www/html/functions.php";


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql_find_all_nurses = "SELECT staff.employee_name, nurses.nurse_id FROM staff, nurses";
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
                           <?php echo $all_nurses["staff.employee_name"] . " Nurse ID: ".$all_nurses["nurses.nurse_id"];
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
            <input type="submit" name="button" value="Assign">
         </form>
      </center>
   </body>
</html>
