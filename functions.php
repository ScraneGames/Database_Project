<?php

// Connect to database function

function connectdatabase() {
  // store database info
 $servername = "localhost";
 $username = "username";
 $password = "password";
 $dbname = "Project_DB";

 // Connect to Database
 $conn = new mysqli($servername, $username, $password, $dbname);
}
