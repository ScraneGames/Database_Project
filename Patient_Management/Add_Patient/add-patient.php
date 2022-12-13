<?php
include "/var/www/html/functions.php";


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

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

$sql_find_illnesses = "SELECT illness_code, illness_name FROM illnesses";
$sql_find_illness_result = mysqli_query($conn,$sql_find_illnesses);

?>


<!DOCTYPE html>
<html lang="en">
   <head>
      <title>Add Patient</title>
   </head>
   <body>
      <center>
         <h1>Adding a Patient</h1>
         <form action="insert-patient.php" method="post">

<p>
               <label for="patient_name">Patient Name:</label>
               <input type="text" name="patient_name" id="patient_name" required>
            </p>


<p>
               <label for="ssn">Social Security Number:</label>
               <input type="text" name="ssn" id="ssn" required>
            </p>

<p>
               <label for="gender">Gender:</label>
               <select name="gender" required>
               <option value="">Select...</option>
               <option value="Male">Male</option>
               <option value="Female">Female</option>
               <option value="NonBinary">NonBinary</option>
               <option value="Other">Other</option>
               </select>
</p>


<p>
               <label for="blood_type">Blood type:</label>
               <select name="blood_type" required>
               <option value="">Select...</option>
               <option value="O+">O+</option>
               <option value="O-">O-</option>
               <option value="A+">A+</option>
               <option value="A-">A-</option>
               <option value="B+">B+</option>
               <option value="B-">B-</option>
               <option value="AB">AB</option>
               </select>
</p>


<p>
               <label for="address">Address:</label>
               <input type="text" name="address" id="address" required>
            </p>


<p>
               <label for="telephone_number">Telephone Number:</label>
               <input type="tel" name="telephone_number" id="telephone_number" required>
            </p>

<p>
                <label for="dob">Date of Birth:</label>
                <input type="date" name="dob" id="dob" required>
            </p>

<!--Add a primary physician-->
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
<!-- Here we have a dropdown for illnesses -->
<label>Select an initial Illness</label>
        <select name="illness" required>
            <?php
                // use a while loop to fetch data
                // from the $all_categories variable
                // and individually display as an option
                while ($illness = mysqli_fetch_array(
                        $sql_find_illness_result,MYSQLI_ASSOC)):;
            ?>
                <option value="<?php echo $illnesses["illness_code"];
                    // The value we usually set is the primary key
                ?>">
                    <?php echo $illnesses["illness_name"] . " ".$employees["illness_code"];
                        // To show the employee name to the user
                    ?>
                </option>
            <?php
                endwhile;
                // While loop must be terminated
            ?>
        </select>


            <input type="submit" value="Submit">
         </form>
      </center>
   </body>
</html>
