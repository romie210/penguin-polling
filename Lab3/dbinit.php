<?php
/* This file opens a connection to the database and defines a global variable
 * $DB for subsequent use. It should be "called" using require_once by any
 * DB model file.
 */

define('SERVER', 'mysql.cosc.canterbury.ac.nz');
define('USERNAME', 'mch177');
define('PASSWORD', '64282398');
define('DATABASE', mch177);  // Database name usually same as username

// Define a special exception class for use by the model
class DBException extends Exception {
    public function __construct($message = null, $code = 0,
                                Exception $previous = null) {
        parent::__construct($message, $code, $previous);
    }
}


function connectDb() {
    $db = new mysqli(SERVER, USERNAME, PASSWORD);
    if ($db->connect_error) {
        throw new DBException('Could not connect to MySQL server');
    }

    if (!$db->select_db(DATABASE)) {
        throw new DBException('Could not select database');
    }
    $db->set_charset('utf8');  // Make sure we talk utf-8 to the server
    return $db;
}


$DB = connectDb();

