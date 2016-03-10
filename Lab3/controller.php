<?php
// The "controller" portion of Richard's solution to lab 3 step 3.
// Handles an imaginary SENG365 poll.
// Extends the postback pattern into a rudimentary MVC approach. This file
// is the "controller". Note that there is no database access code here and nor
// is there any html output. Those belong in the model and view code
// respectively.

require_once('student.php');  // Get the student class (the "model")
require_once('pollresult.php');

define('DEBUGGING', true);

if (defined('DEBUGGING') && DEBUGGING) {
    error_reporting(E_ALL);
    ini_set('display_errors', '1'); // Only if debugging!
}

session_start();

$buttons = array('Excellent', 'Good', 'OK', 'Substandard', 'Dreadful',
    'What\'s SENG365?');
$checkedButton = null;
$username = '';
$errorMessages = array();
//$submissionCount = 0;

if (isset($_SESSION['name'])) {
    $user = $_SESSION['name'];
}
else {
   $user = 'visitor';
   $_SESSION['name'] = $user;
}
if (!isset($_SESSION['visits'])) {
    $_SESSION['visits'] = 0;
}
$_SESSION['visits'] = $_SESSION['visits'] + 1;

$postback = isset($_POST) && isset($_POST['submit']);
if ($postback) {
//    $submissionCount = $_POST['submissioncount'] + 1;
    if (!isset($_POST['username']) || trim($_POST['username']) == '') {
        $errorMessages[] = 'You must provide a username';
    } else {
        $username = $_POST['username'];
        if (!Student::exists($username)) {
            $errorMessages[] = "Student $username not found in database";
        } else {
            $user = Student::read($username);
            $name = implode(" ", array($user->firstName, $user->lastName));
            $_SESSION['name'] = $name;
        }
    }

    if (!isset($_POST['opinion'])) {
        $errorMessages[] = 'You must select one of the opinions';
    } else {
        $checkedButton = intval($_POST['opinion']);
    }
}

if ($postback && count($errorMessages) == 0) {
    $title = 'Thanks';
    $opinion = $buttons[$checkedButton];
    $successMessage = "Thank you, $user->firstName $user->lastName, for your opinion, namely $opinion.";
    PollResult::create($user->id, $checkedButton);
    $average = PollResult::averageVote();
    $format = "FYI: The average opinion so far, on a scale of 0 (Excellent) to 5 (What's SENG365?) is %.2f";
    echo sprintf($format, $average);
    require('thanksview.php');  // Load the "Thanks" view
} else {
    $title = 'Opinion poll';
    require('pollview.php');    // Load (or reload) the poll form view
}
