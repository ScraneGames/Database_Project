<?php
include "/var/www/html/functions.php";


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$original_employee_id = $_REQUEST['employee'];


$sql = "SELECT * FROM staff WHERE employee_id = '$original_employee_id'";

$result = mysqli_query($conn,$sql);

$user = mysqli_fetch_array($result,MYSQLI_ASSOC);

echo "$sql";
echo "<br>";
echo "$original_employee_id";
echo "<br>";
echo $user['employee_name'];
echo "<br>";
$position = $user['position'];
echo "$position";
echo "<br>";

if ($position == "nurse") {
    $nurse_sql = "SELECT * FROM nurses WHERE employee_id = '$original_employee_id'";
    $nurse_result = mysqli_query($conn,$nurse_sql);
    $nurse_user = mysqli_fetch_array($nurse_result,MYSQLI_ASSOC);
} elseif ($position == "surgeon") {
    $contract_sql = "SELECT * FROM contracts WHERE fk_contracts_employee_id = '$original_employee_id'";
    $contract_result = mysqli_query($conn,$contract_sql);
    $contract_user = mysqli_fetch_array($contract_result,MYSQLI_ASSOC);
    $surgeon_sql = "SELECT * FROM surgeons WHERE employee_id = '$original_employee_id'";
    $surgeon_result = mysqli_query($conn,$surgeon_sql);
    $surgeon_user = mysqli_fetch_array($surgeon_result,MYSQLI_ASSOC);
    echo $contract_sql;
    echo "<br>";
    echo $surgeon_sql;
    echo "<br>";
    echo $contract_user['length'];
    echo "<br>";
    echo $contract_user['type'];
    echo "<br>";
    echo $surgeon_user['specialty'];
} elseif ($position == "physician" || $position == "chief_of_staff") {
    $physician_sql = "SELECT * FROM physicians WHERE employee_id = '$original_employee_id'";
    $physician_result = mysqli_query($conn,$physician_sql);
    $physician_user = mysqli_fetch_array($physician_result,MYSQLI_ASSOC);
}

if ($position != "surgeon") {
    $salary_sql = "SELECT * FROM salaries WHERE fk_salary_employee_id = '$original_employee_id'";
    $salary_result = mysqli_query($conn,$salary_sql);
    $salary_user = mysqli_fetch_array($salary_result,MYSQLI_ASSOC);
    echo "$salary_sql";
    echo "<br>";
    echo $salary_user['salary'];

}

?>


<!DOCTYPE html>
<html lang="en">
   <head>
      <title>edit Staff</title>
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
   </head>
   <body>
      <center>
         <h1>Editing Staff</h1>
         <form action="update-staff.php" method="post">

<p>
               <label for="Employee_name">Employee Name:</label>
               <input type="text" name="employee_name" value="<?php echo $user['employee_name']; ?>" id="employee_name">
            </p>


            <input type="hidden" name="employee_id" value="<?php echo "$original_employee_id"; ?>" id="employee_id">
            <input type="hidden" name="position" value="<?php echo $user['position']; ?>" id="position">

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
               <label for="address">Address:</label>
               <input type="text" name="address" value="<?php echo $user['address']; ?>" id="address">
            </p>


<p>
               <label for="telephone_number">Telephone Number:</label>
               <input type="text" name="telephone_number" value="<?php echo $user['telephone_number']; ?>" id="telephone_number">
            </p>
<p>
<!--Salary -->
 <?php if ($user['position'] == "nurse" || $user['position'] == "physician" || $user['position'] == "chief_of_staff" || $user['position'] == "secretary" || $user['position'] == 'janitor'): ?>
 <p>
       <label for="salary">Salary:</label>
            <input type="number" name="salary" value="<?php if ($user['position'] != "surgeon")  echo $salary_user['salary']; ?>" id="salary" min="25000" max="300000">
            </p>
            <?php endif; ?>
<!-- Grade -->
<?php if ($user['position'] == "nurse"): ?>
<p>
            <label for="grade">Grade:</label>
            <input type="text" name="grade" value="<?php echo $nurse_user['grade']; ?>" id="grade">
            </p>
            <?php endif; ?>
 <!-- Experience -->
 <?php if ($user['position'] == "nurse"): ?>
<p>
              <label for="experience">Experience(in years):</label>
                 <input type="number" name="experience" value="<?php echo $nurse_user['experience']; ?>" id="experience">
               </p>
            <?php endif; ?>
<!-- Contracts -->
<?php if ($user['position'] == "surgeon"): ?>
            <p>
              <label for="contract_type">Contract Type:</label>
               <input type="text" name="contract_type" value="<?php echo $contract_user['type']; ?>" id="contract_type">
             </p>
 <p>
             <label for="contract_length">Contract Length(in years):</label>
            <input type="number" name="contract_length" value="<?php echo $contract_user['length']; ?>" id="contract_length">
                          </p>
            <?php endif; ?>


<!-- Specialty -->
<?php if ($user['position'] == "surgeon" || $user['position'] == "physician" || $user['position'] == "chief_of_staff"): ?>
<p>
               <label for="specialty">Specialty:</label>
                <input type="text" name="specialty" value="<?php if ($user['position'] == "surgeon") echo $surgeon_user['specialty']; elseif ($user['position'] == "physician" || $user['position'] == "chief_of_staff") echo $physician_user['specialty']; ?>" id="specialty">
              </p>
              <?php endif; ?>

<!-- Has Ownership
 <p>
                           <label for="own">Has Ownership Stake?:</label>
                           <select name="own" id="own">
                           <option value="">Select...</option>
                           <option value="yes">Yes</option>
                           <option value="no">No</option>
                           </select>
                           </p>

-->


<!-- Enter Shares
            <div id="owner" class="owner_fields" style="display: none">
<p>
              <label for="shares">Shares:</label>
               <input type="number" name="shares" id="shares">
             </p>
            </div>
-->
            <input type="submit" value="Submit">
         </form>
      </center>
</body>


</html>
