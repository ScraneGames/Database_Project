<?php
include "/var/www/html/functions.php";


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql_find_surgery_types = "SELECT type_name, surgery_code FROM surgery_types";
$all_surgeries = mysqli_query($conn,$sql_find_surgery_types);

$sql_find_surgery_skills = "SELECT skill_name, skill_id FROM surgery_skills";
$all_surgery_skills = mysqli_query($conn,$sql_find_surgery_skills);

// public mysqli::multi_query(string $sql): bool


?>




<!DOCTYPE html>
<html lang="en">
   <head>
      <title>Find Staff</title>
   </head>
   <body>
      <center>
         <h1>Choose an Surgery Type</h1>

         <form action="insert-surgery-requirement.php" method="post">

         <label>Select a Surgery Type</label>
        <select name="surgery">
            <?php
                // use a while loop to fetch data
                // from the $all_categories variable
                // and individually display as an option
                while ($surgeries = mysqli_fetch_array(
                        $all_surgeries,MYSQLI_ASSOC)):;
            ?>
                <option value="<?php echo $surgeries["surgery_code"];
                    // The value we usually set is the primary key
                ?>">
                    <?php echo $surgeries["type_name"] . " ".$surgeries["surgery_code"];
                        // To show the surgery name to the user
                    ?>
                </option>
            <?php
                endwhile;
                // While loop must be terminated
            ?>
        </select>
        <br>
        <label>Select a Surgery Skill</label>
        <select name="skill">
            <?php
                // use a while loop to fetch data
                // from the $all_categories variable
                // and individually display as an option
                while ($skills = mysqli_fetch_array(
                        $all_surgery_skills,MYSQLI_ASSOC)):;
            ?>
                <option value="<?php echo $skills["skill_id"];
                    // The value we usually set is the primary key
                ?>">
                    <?php echo $skills["skill_name"] . " ".$skills["skill_id"];
                        // To show the employee name to the user
                    ?>
                </option>
            <?php
                endwhile;
                // While loop must be terminated
            ?>
        </select>
        <br>
            <input type="submit" value="Submit">
         </form>
      </center>
   </body>
   <?php   $conn->close(); ?>
</html>
