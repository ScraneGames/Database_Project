<!DOCTYPE html>
<html lang="en">
   <head>
      <title>GFG- Store Data</title>
   </head>
   <body>
      <center>
         <h1>Adding a Medication</h1>
         <form action="insert-medication.php" method="post">

<p>
               <label for="medication_name">Medication Name:</label>
               <input type="text" name="medication_name" id="medication_name">
            </p>

<p>
               <label for="quantity_on_hand">Quantity on Hand:</label>
               <input type="number" name="quantity_on_hand" id="quantity_on_hand">
            </p>
<p>
               <label for="quantity_on_order">Quantity on Order:</label>
               <input type="number" name="quantity_on_order" id="quantity_on_order">
            </p>
<p>
               <label for="unit_cost">Unit Cost:</label>
               <input type="number" name="unit_cost" id="unit_cost">
            </p>
<p>
               <label for="ytd_usage">Year To Date Usage:</label>
               <input type="number" name="ytd_usage" id="ytd_usage">
            </p>

            <input type="submit" value="Submit">
         </form>
      </center>
   </body>
</html>
