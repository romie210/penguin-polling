<?php
/* The "model" portion of the rudimentary MVC solution to lab3, step 3.
 * When included, this file opens a connection to the database as defines
 * a global variable $DB for subsequent use.
 */

define('DEBUGGING', true);
define('SERVER', 'mysql.cosc.canterbury.ac.nz');
define('USERNAME', 'rjl83');
define('PASSWORD', 'YourPasswordGoesHere');
define('DATABASE', USERNAME);  // Database name usually same as username

if (defined('DEBUGGING') && DEBUGGING) {
    error_reporting(E_ALL);
    ini_set('display_errors', '1'); // Only if debugging!
}

function connectDb() {
    $db = new mysqli(SERVER, USERNAME, PASSWORD);
    if ($db->connect_error) {
        die('Could not connect to MySQL server');
    }

    if (!$db->select_db(DATABASE)) {
        die('Could not select database');
    }
    $db->set_charset('utf8');  // Make sure we talk utf-8 to the server
    return $db;
}


$DB = connectDb();

