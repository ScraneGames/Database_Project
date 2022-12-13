<!DOCTYPE html>
<html lang="en">
   <head>
      <title>GFG- Store Data</title>
   </head>
   <body>
      <center>
         <h1>Adding a Surgery Type</h1>
         <form action="insert-surgery-types.php" method="post">

<p>
               <label for="type_name">Surgery Type Name:</label>
               <input type="text" name="type_name" id="type_name">
            </p>


<p>
               <label for="type_desc">Surgery Type Description:</label>
               <input type="text" name="type_desc" id="type_desc">
            </p>
<p>
               <label for="anatomical_location">Anatomical Location:</label>
               <input type="text" name="anatomical_location" id="anatomical_location">
            </p>
<p>
               <label for="special_needs">Special Needs:</label>
               <input type="text" name="special_needs" id="special_needs">
            </p>
<p>
               <label for="category">Category:</label>
               <select name="category">
               <option value="">Select...</option>
               <option value="H">(H) - Requires Hospitalization</option>
               <option value="O"> (O) - Outpatient</option>
               </select>
</p>

            <input type="submit" value="Submit">
         </form>
      </center>
   </body>
</html>
