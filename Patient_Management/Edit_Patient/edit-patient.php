<?php
include "/var/www/html/functions.php";


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$original_patient_id = $_REQUEST['patient'];


$sql = "SELECT * FROM patient_personal_data WHERE patient_id = '$original_patient_id'";

$result = mysqli_query($conn,$sql);

$user = mysqli_fetch_array($result,MYSQLI_ASSOC);

$primary_id = $user['primary_physician_id'];

$primary_sql = "SELECT employee_name FROM physicians WHERE physician_id = '$primary_id";

$sql_find_phyisicans_less_7 = "SELECT physicians.employee_name, physicians.physician_id
                        FROM physicians
                        LEFT OUTER JOIN patient_primary
                        ON physicians.physician_id = patient_primary.fk_primary_physician_id
                        WHERE physicians.position <> 'chief_of_staff'
                        GROUP BY physicians.physician_id
                        HAVING COUNT(patient_primary.fk_primary_physician_id) < 7";

$sql_find_physicians_less_7_result = mysqli_query($conn,$sql_find_phyisicans_less_7);

$sql_find_phyisicans_less_20 = "SELECT physicians.employee_name, physicians.physician_id
                        FROM physicians
                        LEFT OUTER JOIN patient_primary
                        ON physicians.physician_id = patient_primary.fk_primary_physician_id
                        WHERE physicians.position <> 'chief_of_staff'
                        GROUP BY physicians.physician_id
                        HAVING COUNT(patient_primary.fk_primary_physician_id) < 20";

$sql_find_physicians_less_20_result = mysqli_query($conn,$sql_find_phyisicans_less_20);
?>

<!DOCTYPE html>
<html lang="en">
   <head>
      <title>Editing a Patient</title>
   </head>
   <body>
      <center>
         <h1>Editing a Patient</h1>
         <form action="update-patient.php" method="post">

<p>
               <label for="patient_name">Patient Name:</label>
               <input type="text" name="patient_name" value="<?php echo $user['patient_name']; ?>" id="patient_name">
            </p>

            <input type="hidden" id="patient_id" name="patient_id" value="<?php echo $original_patient_id; ?>">

<p>
               <label for="ssn">Social Security Number:</label>
               <input type="text" name="ssn" value="<?php echo $user['ssn']; ?>" id="ssn">
            </p>

<p>
<label for="gender">Gender:</label>
               <select name="gender">
               <option <?php echo $user['gender'] == "male" ? "selected": ""; ?>>Male</option>
               <option <?php echo $user['gender'] == "female" ? "selected": ""; ?>>Female</option>
               <option <?php echo $user['gender'] == "nonbinary" ? "selected": ""; ?>>NonBinary</option>
               <option <?php echo $user['gender'] == "other" ? "selected": ""; ?>>Other</option>
               </select>
</p>
                </p>


<p>
               <label for="address">address:</label>
               <input type="text" name="address" value="<?php echo $user['address']; ?>" id="address">
            </p>


<p>
               <label for="telephone_number">Telephone Number:</label>
               <input type="tel" name="telephone_number" value="<?php echo $user['telphone_number']; ?>" id="telephone_number">
            </p>

<p>
                <label for="dob">Date of Birth:</label>
                <input type="date" name="dob" value="<?php echo $user['dob']; ?>" id="dob">
            </p>
<p>
<?php
echo "<h3>The patient's current primary physician is $primary. </h3>"
?>
</p>
<?php if (mysqli_num_rows($sql_find_physicians_less_7_result) > 0): ?>
<p>
               <label for="primary_less_7">Primary Physician:</label>
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

            <input type="submit" value="Submit">
         </form>
      </center>
   </body>
</html>
