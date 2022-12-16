<?php
include "/var/www/html/functions.php";


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$original_patient_id = $_REQUEST['patient'];


$sql = "SELECT * FROM patient_personal_data WHERE patient_id = '$original_patient_id'";

$result = mysqli_query($conn,$sql);

$user = mysqli_fetch_array($result,MYSQLI_ASSOC);

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

            <input type="submit" value="Submit">
         </form>
      </center>
   </body>
</html>
