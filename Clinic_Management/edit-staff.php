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
?>


<!DOCTYPE html>
<html lang="en">
   <head>
      <title>edit Staff</title>
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
   </head>
   <body>
      <center>
         <h1>Editing a Patient</h1>
         <form action="update-staff.php" method="post">

<p>
               <label for="Employee_name">Employee Name:</label>
               <input type="text" name="employee_name" value="<?php echo $user['employee_name']; ?>" id="employee_name">
            </p>


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
<!-- Hidden fields class sections
 Salary -->
            <div id="salary_field" class="fields" style="display: none">
<p>
            <label for="salary">Salary:</label>
            <input type="number" name="salary" id="salary" min="25000" max="300000">
            </p>
            </div>
<!-- Grade -->
            <div id="grade_field" class="fields" style="display: none">
<p>
            <label for="grade">Grade:</label>
            <input type="text" name="grade" id="grade">
            </p>
            </div>
 <!-- Experience -->
 <div id="experience_field" class="fields" style="display: none">
<p>
              <label for="experience">Experience(in years):</label>
                 <input type="number" name="experience" id="experience">
               </p>
            </div>
<!-- Contracts -->
<div id="contracts_field" class="fields" style="display: none">
            <p>
              <label for="contract_type">Contract Type:</label>
               <input type="text" name="contract_type" id="contract_type">
             </p>
 <p>
             <label for="contract_length">Contract Length(in years):</label>
            <input type="number" name="contract_length" id="contract_length">
                          </p>
                          </div>

<!-- Specialty -->
<div id="specialty_field" class="fields" style="display: none">
<p>
               <label for="specialty">Specialty:</label>
                <input type="text" name="specialty" id="specialty">
              </p>
              </div>

<!-- Has Ownership -->
            <div id="has_ownership" class="fields" style="display: none">
 <p>
                           <label for="own">Has Ownership Stake?:</label>
                           <select name="own" id="own">
                           <option value="">Select...</option>
                           <option value="yes">Yes</option>
                           <option value="no">No</option>
                           </select>
                           </p>
                        </div>

<!-- Hidden specific_staff class sections
 Nurses
            <div id="nurses" class="specific_staff" style="display: none">
<p>
              <label for="salary">Salary:</label>
               <input type="number" name="salary" id="salary" min="25000" max="300000">
             </p>
<p>
               <label for="grade">Grade:</label>
                <input type="text" name="grade" id="grade">
              </p>
<p>
              <label for="experience">Experience(in years):</label>
                 <input type="number" name="experience" id="experience">
               </p>
            </div>
<!-- Surgeon
            <div id="surgeon" class="specific_staff"  style="display: none">
<p>
              <label for="contract_type">Contract Type:</label>
               <input type="text" name="contract_type" id="contract_type">
             </p>
 <p>
             <label for="contract_type">Contract Length(in years):</label>
            <input type="number" name="contract_length" id="contract_type">
                          </p>
            </div>
<!-- Physician
            <div id="physician" class="specific_staff"  style="display: none">
<p>
              <label for="salary">Salary:</label>
               <input type="number" name="salary" id="salary" min="25000" max="300000">
             </p>
<p>
               <label for="specialty">Specialty:</label>
                <input type="text" name="specialty" id="specialty">
              </p>
<!-- Other Staff
            </div>
            <div id="other_staff" class="specific_staff"  style="display: none">
<p>
              <label for="salary">Salary:</label>
               <input type="number" name="salary" id="salary" min="25000" max="300000">
             </p>
            </div>

<!-- Enter Shares -->
            <div id="owner" class="owner_fields" style="display: none">
<p>
              <label for="shares">Shares:</label>
               <input type="number" name="shares" id="shares">
             </p>
            </div>
            <input type="submit" value="Submit">
         </form>
      </center>
   </body>
<script>
    echo "$position";
    echo "<br>";
$( document ).ready(function(){
    $('.fields').hide()
        if($position == "nurse"){
            $('#salary_field').show();
            $('#grade_field').show();
            $('#experience_field').show();
            } else if ($position == "surgeon"){
                $('#contracts_field').show();
                $('#specialty_field').show();
                }
});
</script>

<!-- Original function change sript
   <script>
     $( document ).ready(function() {
        $('$position').change(function() {
           $('.fields').hide()
           if($(this).val() == "nurse"){
              $('#salary_field').show();
              $('#grade_field').show();
              $('#experience_field').show();
           } else if($(this).val() == "surgeon"){
               $('#contracts_field').show();
               $('#specialty_field').show();
           }else if($(this).val() == "physician"){
                  $('#salary_field').show();
                  $('#specialty_field').show();
                  $('#has_ownership').show();
                }
                   else if($(this).val() == "chief_of_staff") {
                     $('#salary_field').show();
                     $('#specialty_field').show();
                      $('#has_ownership').show();
                    }
                      else if($(this).val() == "secretary"){
                        $('#salary_field').show();
                      }else if($(this).val() == "janitor"){
                           $('#salary_field').show();
                      }
        });
      });
    -->
   </script>
   <script>
   $( document ).ready(function() {
     $('#own').change(function() {
       $('.owner_fields').hide()
         if($(this).val() == "yes")
          $('#owner').show();
     });
   });
   </script>
</html>
