<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of pollresult
 *
 * @author mch177
 */

require_once('dbinit.php');  // Make sure the database connection is open.

class PollResult {
    public $id;            // Primary key (generated by DB using auto-inc)
    public $studentid;     // Foreign key (to Student DB)
    public $response;
    
    /** Constructor for a PollResult.
     *  Used only to construct an empty PollResult object.
     */
    public function __construct() {
    }


    // Construct a student object, write it to DB and return it.
    public static function create($studentid, $response) {
        global $DB;
        $pollResult = new PollResult();
        unset($pollResult->id);  // Not defined yet. Leave that to DB
        $pollResult->studentid = $studentid;
        $pollResult->response = $response;
        $query = "INSERT INTO pollresults SET studentid=$studentid, response=$response";
        $result = $DB->query($query);
        return $pollResult;
    }
    
    public static function averageVote() {
        global $DB;
        $query = "SELECT AVG(response) FROM pollresults";
        $result = $DB->query($query);
        $row = $result->fetch_array(MYSQLI_ASSOC);
        return implode($row);
    }
}
