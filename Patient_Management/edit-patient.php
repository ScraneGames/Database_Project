<?php
include "/var/www/html/functions.php";


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$original_patient_id = $_REQUEST['patient'];


$sql = "SELECT * FROM patient_personal_data WHERE patient_id = '$original_patient_id'";

$result = mysqli_query($conn,$sql);

$user = mysqli_fetch_array($result,MYSQLI_ASSOC);

echo "$sql";
echo "<br>";
echo "$original_patient_id";
echo "<br>";
echo $user['patient_name'];
echo "<br"

if($_REQUEST['button']=="Delete"){
    $delete_sql = "DELETE FROM patient_personal_data WHERE patient_id = '$original_patient_id";
    mysqli_query($conn,$delete_sql);
    echo "'$original_patient_id' deleted!"
}
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

            <input type="hidden" id="patient_id" name="patient_id" value="$original_patient_id">

<p>
               <label for="ssn">Social Security Number:</label>
               <input type="text" name="ssn" value="<?php echo $user['ssn']; ?>" id="ssn">
            </p>

<p>
               <label for="gender">Gender:</label>
               <select name="gender">
               <option value="Male">Male</option>
               <option value="Female">Female</option>
               <option value="NonBinary">NonBinary</option>
               <option value="Other">Other</option>
               </select>
</p>
                </p>


<p>
               <label for="address">address:</label>
               <input type="text" name="address" value="<?php echo $user['address']; ?>" id="address">
            </p>


<p>
               <label for="telephone_number">Telephone Number:</label>
               <input type="text" name="telephone_number" value="<?php echo $user['telphone_number']; ?>" id="telephone_number">
            </p>

<p>
                <label for="dob">Date of Birth:</label>
                <input type="text" name="dob" value="<?php echo $user['dob']; ?>" id="dob">
            </p>

            <input type="submit" value="Submit">
         </form>
      </center>
   </body>
</html>
