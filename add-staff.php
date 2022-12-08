<!DOCTYPE html>
<html lang="en">
   <head>
      <title>GFG- Store Data</title>
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
   </head>
   <body>
      <center>
         <h1>Adding a Patient</h1>
         <form action="insert-staff.php" method="post">

<p>
               <label for="Employee_name">Employee Name:</label>
               <input type="text" name="patient_name" id="patient_name">
            </p>


<p>
               <label for="ssn">Social Security Number:</label>
               <input type="text" name="ssn" id="ssn">
            </p>

<p>
               <label for="gender">Gender:</label>
               <select name="gender">
               <option value="">Select...</option>
               <option value="male">Male</option>
               <option value="female">Female</option>
               <option value="nonbinary">NonBinary</option>
               <option value="other">Other</option>
               </select>
</p>
                </p>


<p>
               <label for="address">address:</label>
               <input type="text" name="address" id="address">
            </p>


<p>
               <label for="telephone_number">Telephone Number:</label>
               <input type="text" name="telephone_number" id="telephone_number">
            </p>

<p>
                <label for="Position">Position:</label>
                <select name="position" id="position">
                <option value="">Select...</option>
                <option value="nurse">Nurse</option>
                <option value="surgeon">Surgeon</option>
                <option value="physician">Physician</option>
                <option value="chief of staff">Chief of Staff</option>
                <option value="janitor">Janitor</option>
                <option value="Secretary">Secretary</option>
                </select>
            </p>
            <div id="nurses" class="specific_staff" style="display: none">
              <label for="salary">Salary:</label>
               <input type="text" name="salary" id="salary">
               <label for="grade">Grade:</label>
                <input type="text" name="grade" id="grade">
              <label for="experience">Experience:</label>
                 <input type="text" name="experience" id="experience">
            </div>
            <div id="surgeon" class="specific_staff"  style="display: none">
              <label for="contract_type">Contract Type:</label>
               <input type="text" name="contract_type" id="contract_type">
            </div>
            <div id="physician" class="specific_staff"  style="display: none">
              <label for="salary">Salary:</label>
               <input type="text" name="salary" id="salary">
               <label for="specialty">Specialty:</label>
                <input type="text" name="specialty" id="specialty">
              <label for="ownership">Has Ownership Stake?:</label>
               <input type="radio" name="ownership" id="ownership">Yes
               <input type="radio" name="ownership" id="ownership">No
               <div class="owner_fields" style="display: none">
                 <label for="shares">Shares:</label>
                  <input type="number" name="salary" id="salary">
               </div>
            </div>
            <div id="chief" class="specific_staff"  style="display: none">
              <label for="salary">Salary:</label>
               <input type="text" name="salary" id="salary">
               <label for="specialty">Specialty:</label>
                <input type="text" name="specialty" id="specialty">
              <label for="ownership">Has Ownership Stake?:</label>
               <input type="radio" name="ownership" id="ownership">Yes
               <input type="radio" name="ownership" id="ownership">No
               <div class="owner_fields" style="display: none">
                 <label for="shares">Shares:</label>
                  <input type="number" name="salary" id="salary">
               </div>
            </div>

            <input type="submit" value="Submit">
         </form>
      </center>
   </body>


   <script>
     $( document ).ready(function() {
        $('#position').change(function() {
           $('.specific_staff').hide()
           if($(this).val() == "nurse")
              $('#nurses').show();
           else if($(this).val() == "surgeon")
              $('#surgeon').show();
              else if($(this).val() == "physician")
                 $('#physician').show();
                 else if($(this).val() == "chief of staff")
                    $('#chief').show();
        });
      });
      $( document ).ready(function() {
        $('#ownership').change(function() {
          $('.owner_fields').hide()
          if($(this.val() == "Yes")
          $('#owner_fields').show();
        });
      });
   </script>
</html>
