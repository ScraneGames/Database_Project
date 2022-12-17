<?php
include "/var/www/html/functions.php";


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql_find_medications = "SELECT name, medication_code FROM medications";
$all_medications = mysqli_query($conn,$sql_find_medications);
$all_medications2 = mysqli_query($conn,$sql_find_medications);


$medication_reactions = "SELECT medication_name, reacting_name, severity
                           FROM view_medication_reactions
                           ORDER BY medication_name'";
$reaction_results = mysqli_query($conn,$medication_reactions);

var_dump($reaction_results);
?>




<!DOCTYPE html>
<html lang="en">
   <head>
      <title>Add Medical reaction</title>
   </head>
   <body>
      <center>
         <h1>Pair a Reaction</h1>

         <form action="insert-medication-reaction.php" method="post">

         <label>Select a Medication</label>
        <select name="medication1">
            <?php
                // use a while loop to fetch data
                // from the $all_categories variable
                // and individually display as an option
                while ($medications = mysqli_fetch_array(
                        $all_medications,MYSQLI_ASSOC)):;
            ?>
                <option value="<?php echo $medications["medication_code"];
                    // The value we usually set is the primary key
                ?>">
                    <?php echo $medications["name"] . " - Medication Code: ".$medications["medication_code"];
                        // To show the medication name to the user
                    ?>
                </option>
                <?php
                endwhile;
                // While loop must be terminated
            ?>
        </select>
        <br>
        <label>Select a reacting Medication</label>
        <select name="medication2">
            <?php
                // use a while loop to fetch data
                // from the $all_categories variable
                // and individually display as an option
                while ($medications2 = mysqli_fetch_array(
                        $all_medications2,MYSQLI_ASSOC)):;
            ?>
                <option value="<?php echo $medications2["medication_code"];
                    // The value we usually set is the primary key
                ?>">
                    <?php echo $medications2["name"] . " - Medication Code: ".$medications2["medication_code"];
                        // To show the medication name to the user
                    ?>
                </option>
            <?php
                endwhile;
                // While loop must be terminated
            ?>
        </select>
        <br>
        <label for="severity">Medication Severity:</label>
                           <select name="severity" id="severity">
                           <option value="">Select...</option>
                           <option value="s">(S) Severe Interaction</option>
                           <option value="m">(M) Moderate Interaction</option>
                           <option value="l">(L) Little Interaction</option>
                           <option value="n">(N) No Interaction</option>
        <br>
        <br>
        <p>
        <?php
echo "Current Medication Reactions";
echo "<br>";

echo "<table border='1'>
<tr>
<th>Medication Name</th>
<th>Reacting Medication Name</th>
<th>Severity</th>
</tr>";

while($reacting_row = mysqli_fetch_array($reaction_results)){
    echo "<tr>";
    echo "<td>" . $reacting_row['medication_name'] . "</td>";
    echo "<td>" . $reacting_row['reacting_name'] . "</td>";
    echo "<td>" . $reacting_row['severity'] . "</td>";
    echo "</tr>";
}
echo "</table>";

echo "<br>";
        ?>
        </p>
            <input type="submit" value="Submit">
         </form>
      </center>
   </body>
   <?php   $conn->close(); ?>
</html>
