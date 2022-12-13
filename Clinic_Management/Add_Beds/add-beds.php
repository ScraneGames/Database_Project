<!DOCTYPE html>
<html lang="en">
   <head>
      <title>GFG- Store Data</title>
   </head>
   <body>
      <center>
         <h1>Adding a Bed to the System</h1>
         <form action="insert-beds.php" method="post">

           <p>
                          <label for="nursing_unit">Nursing Unit:</label>
                          <select name="nursing_unit" id="nursing_unit">
                          <option value="">Select...</option>
                          <option value="1">1</option>
                          <option value="2">2</option>
                          <option value="3">3</option>
                          <option value="4">4</option>
                          <option value="5">5</option>
                          <option value="6">6</option>
                          <option value="7">7</option>
                          </select>
           </p>
           <p>
                          <label for="wing">Wing:</label>
                          <select name="wing" id="wing">
                          <option value="">Select...</option>
                          <option value="Blue">Blue</option>
                          <option value="Green">Green</option>
                          </select>
           </p>

<p>
                        <label for="room_number">Room Number:</label>
                        <input type="number" id="room_number" name="room_number">
            </p>
            <p>
                           <label for="bed">Bed:</label>
                           <select name="bed" id="bed">
                           <option value="">Select...</option>
                           <option value="A">A</option>
                           <option value="B">B</option>
                           </select>
            </p>

            <input type="submit" value="Submit">
         </form>
      </center>
   </body>
</html>
