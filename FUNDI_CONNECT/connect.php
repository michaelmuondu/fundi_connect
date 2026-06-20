<?php
// create a variable for connection
$conn = mysqli_connect(
    //pass the db credentials
    //eg 'localhost', 'root', '', 'mydb'  
    // mysql -u root -h 127.0.0.1 -p
    "localhost",
    "root",
    "",
    "fundi_connect"
);
//testing the connection
if (!$conn) {
    die("Connection failed");
}
// echo "Connection successful";
?>