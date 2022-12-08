<!DOCTYPE html>
<html lang="en">
   <head>
      <title>GFG- Store Data</title>
   </head>
   <body>
      <center>
         <h1>Adding a Patient</h1>
         <form action="insert-patient.php" method="post">

<p>
               <label for="patient_name">Patient Name:</label>
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
               <option value="Male">Male</option>
               <option value="Female">Female</option>
               <option value="NonBinary">NonBinary</option>
               <option value="Other">Other</option>
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
                <label for="dob">Date of Birth:</label>
                <input type="text" name="dob" id="dob">
            </p>

            <input type="submit" value="Submit">
         </form>
      </center>
   </body>
</html>
