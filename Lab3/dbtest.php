<?php
/* A simple script to test if the connection to the database and
 * the 'students' table is working correctly. Doesn't output valid
 * HTML -- it's just a quick sanity check, to be run from a command line.
 */
$db = new mysqli('mysql.cosc.canterbury.ac.nz', 'mch177', '64282398');
if ($db->connect_error) {
    die("Could not connect to MySQL server\n");
}

if (!$db->select_db('mch177')) {
    die("Could not select database\n");
}

$sql = "SELECT * FROM students";
$result = $db->query($sql);   
if (!$result) {
    die("Select query failed: " . $db->error ."\n");
}

echo $result->num_rows . " students found: \n";
while (($row = $result->fetch_object()) !== NULL) {
    print_r($row);
}
?>
