<?php
/*
 * Declare the Student class, representing a row of the students table.
 * It publishes all its fields to clients, shock horror.
 *
 * Although most of the functionality is not needed for this lab, the class
 * provides a full CRUD interface (Create, Read, Update and Delete) in order to
 * demonstrate the idea.
 */

require_once('dbinit.php');  // Make sure the database connection is open.

class Student {
    public $id;            // Primary key (generated by DB using auto-inc)
    public $studentNo;     // Student ID number
    public $username;      // Used in this code as the key for all db access
    public $firstName;
    public $lastName;
    public $address1;
    public $address2;
    public $address3;

    /** Constructor for a student.
     *  Used only to construct an empty Student object.
     */
    public function __construct() {
    }


    // Construct a student object, write it to DB and return it.
    public static function create($studentNo, $username, $firstName, $lastName,
            $address1, $address2, $address3) {
        global $DB;
        $stud = new Student();
        unset($stud->id);  // Not defined yet. Leave that to DB
        $stud->studentNo = $studentNo;
        $stud->username = $username;
        $stud->firstName = $firstName;
        $stud->lastName = $lastName;
        $stud->address1 = $address1;
        $stud->address2 = $address2;  // Ignore possibility it's NULL. [Hack]
        $stud->address3 = $address3;
        $fields = $stud->makeSetString();
        $query = "INSERT INTO students $fields";
        $result = $DB->query($query);
        Student::checkResult($result);
        return $stud;
    }


    /*
     * Return a Student object read from the database for the given student.
     * Throws an exception if no such student exists in the database.
     */
    public static function read($username) {
        global $DB;
        $stud = new Student();
        $sql = "SELECT * FROM students WHERE username='$username'";
        $result = $DB->query($sql);
        Student::checkResult($result);
        if ($result->num_rows !== 1) {
            throw new Exception("Student $username not found in database");
        }

        // Copy all database column values into this.
        $row = $result->fetch_array(MYSQLI_ASSOC);
        foreach ($row as $field => $value) {
            $stud->$field = $value;
        }
        return $stud;
    }


    /*
     * Writes this student to the database.
     */
    public function update() {
        global $DB;
        $fields = $this->makeSetString();
        $query = "UPDATE students $fields WHERE id = {$this->id}";
        $result = $DB->query($query);
        Student::checkResult($result);
    }


    /*
     * Delete this student from the database.
     */
    public function delete() {
        global $DB;
        $query = "DELETE FROM students WHERE id = {$this->id}";
        $result = $DB->query($query);
        Student::checkResult($result);
    }


    /*
     * Return true iff the given username exists in the students table
     * of the database.
     */
    public static function exists($username) {
        global $DB;
        $sql = "select username from students where username='$username'";
        $result = $DB->query($sql);
        Student::checkResult($result);
        return $result->num_rows === 1;
    }

    // ============== Private support methods follow ============

    // Build a string of "SET field='value', ..." for all existing object
    // attributes (except id). Doing it this way makes it easy to add
    // attributes, without having to update all the database queries.
    private function makeSetString() {
        global $DB;
        $s = "SET ";
        $separator = '';
        foreach ($this as $name=>$value) {
            if ($name !== 'id') {  // Don't try updating id!
                $escapedValue = $DB->escape_string($value);
                $s .= $separator . "$name='$escapedValue'";
                $separator = ',';  // ',' for all except first
            }
        }
        return $s;
    }

    // Check that the result from a DB query was OK.
    // Throws an exception if not.
    private static function checkResult($result) {
        global $DB;
        if (!$result) {
            throw new Exception("DB error: {$DB->error}");
        }
    }
};
