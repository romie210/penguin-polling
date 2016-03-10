<?php
/* The "poll view" component of the rudimentary MVC solution to lab3 step3.
 * This particular view displays the poll form.
 *
 *  Parameters:
 *      $title (for header)
 *      $username - for prefilling the username field
 *      $buttons  - the button array
 *      $checkedButton - the value of the button to be checked (if any)
 *      $error - an array of error message strings
 */

// First, some view-support functions

// Format an array of error messages for HTML display
function displayErrors($errorMessages) {
    $messageListHtml =
            '<p class="errormessage">' .
            implode('<br>', $errorMessages) .
            '</p>';
    return $messageListHtml;
}

// Format a radio button for HTML display
function radioButtonHtml($groupName, $buttonValue, $displayValue, $isChecked) {
    $checked = $isChecked ? ' checked' : '';
    $html = "<input type='radio' name='$groupName' value='$buttonValue'$checked>";
    return $html . $displayValue . '<br>';
}


// ========== The main form ("view") ============

require('headerview.php');
?>
<h1>My opinion of SENG365 so far</h1>
<?php
$user = $_SESSION['name'];
$visits = $_SESSION['visits'];
echo "<p>Welcome, $user, on visit #$visits</p>";
?>
<form action="controller.php" method="post">
    <?php echo displayErrors($errorMessages); ?>
<!--    <input type="hidden" name="submissioncount" value="<?#php echo $submissionCount; ?>">-->
    <?php if ($visits > 1) {
        echo "<p><i>Please phone our help desk, 0800 123 4567, if you need assistance.</i></p>";
    } ?>
    <p>Username: <input type="text" name="username"
                        value="<?php echo $username; ?>" size="8">
    </p>
    <p>Please choose the option that best describes your opinion of
        SENG365 so far and click 'Submit'.
    </p>
    <p>
        <?php
        foreach ($buttons as $buttonValue => $displayText) {
            $isChecked = $buttonValue === $checkedButton;
            echo radioButtonHtml('opinion', $buttonValue, $displayText, $isChecked);
        }
        ?>
    </p>
    <p><input type="submit" name='submit' value="Submit">
    </p>
</form>

<?php
require('footerview.php');
